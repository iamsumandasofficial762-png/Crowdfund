<?php

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class FundraiserAuthController extends Controller
{
    public function start(): RedirectResponse
    {
        return redirect()->route('fundraiser.login');
    }

    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('fundraiser_id')) {
            $fundraiser = Fundraiser::approved()->find(session('fundraiser_id'));

            if ($fundraiser) {
                return redirect()->route('fundraiser.posts.create');
            }

            session()->forget('fundraiser_id');
        }

        return view('fundraiser.auth');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:fundraisers,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country_code' => ['required', 'string', 'max:10'],
            'phone' => ['required', 'string', 'max:30'],
            'cause' => ['required', 'string', 'max:100'],
            'documents' => ['nullable', 'array', 'max:4'],
            'documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $documents = [];

        foreach ($request->file('documents', []) as $document) {
            $documents[] = $document->store('fundraiser-documents', 'public');
        }

        Fundraiser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'country_code' => $validated['country_code'],
            'phone' => $validated['phone'],
            'cause' => $validated['cause'],
            'documents' => $documents,
            'status' => Fundraiser::STATUS_PENDING,
        ]);

        return redirect()
            ->route('fundraiser.login')
            ->with('auth_mode', 'register')
            ->with('status', 'Your fundraiser profile has been submitted successfully. You will receive a message when your profile is approved.');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $fundraiser = Fundraiser::where('email', $validated['email'])->first();

        if (! $fundraiser || ! $fundraiser->password || ! Hash::check($validated['password'], $fundraiser->password)) {
            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'Invalid fundraiser login credentials.']);
        }

        if ($fundraiser->status === Fundraiser::STATUS_PENDING) {
            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'Your fundraiser profile is pending admin approval.']);
        }

        if ($fundraiser->status === Fundraiser::STATUS_REJECTED) {
            return back()
                ->withInput($request->only('email') + ['auth_mode' => 'login'])
                ->withErrors(['email' => 'Your fundraiser profile was rejected. Please contact support.']);
        }

        $request->session()->regenerate();
        $request->session()->put('fundraiser_id', $fundraiser->id);

        return redirect()->route('fundraiser.posts.create');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('fundraiser_id');
        $request->session()->regenerateToken();

        return redirect()->route('fundraiser.login')->with('status', 'You have been logged out successfully.');
    }
}
