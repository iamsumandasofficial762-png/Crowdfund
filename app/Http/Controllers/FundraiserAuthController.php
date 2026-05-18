<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
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
            $fundraiser = Fundraiser::find(session('fundraiser_id'));

            if ($fundraiser) {
                return redirect()->route('fundraiser.dashboard');
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

        $fundraiser = Fundraiser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'country_code' => $validated['country_code'],
            'phone' => $validated['phone'],
            'cause' => $validated['cause'],
            'documents' => $documents,
            'status' => Fundraiser::STATUS_APPROVED,
            'approved_at' => now(),
        ]);

        $request->session()->regenerate();
        $request->session()->put('fundraiser_id', $fundraiser->id);

        AdminActivity::create([
            'title' => 'New Fundraiser Registered',
            'message' => $fundraiser->name.' registered as a fundraiser.',
            'type' => 'fundraiser',
            'created_by' => $fundraiser->name,
        ]);

        return redirect()
            ->route('fundraiser.dashboard')
            ->with('status', 'Your fundraiser account has been created successfully.');
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

        $request->session()->regenerate();
        $request->session()->put('fundraiser_id', $fundraiser->id);

        return redirect()->route('fundraiser.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('fundraiser_id');
        $request->session()->regenerateToken();

        return redirect()->route('fundraiser.login')->with('status', 'You have been logged out successfully.');
    }
}
