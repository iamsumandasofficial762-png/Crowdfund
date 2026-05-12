<?php

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FundraiserController extends Controller
{
    public function index(): View
    {
        $fundraisers = Fundraiser::approved()
            ->latest('approved_at')
            ->paginate(9);

        return view('pages.fundraisers.index', compact('fundraisers'));
    }

    public function show(): View
    {
        return view('pages.fundraiser-details');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
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
            'country_code' => $validated['country_code'],
            'phone' => $validated['phone'],
            'cause' => $validated['cause'],
            'documents' => $documents,
            'status' => Fundraiser::STATUS_PENDING,
        ]);

        return back()->with(
            'status',
            'Your fundraiser profile has been submitted successfully. You will receive a message when your profile is approved.'
        );
    }
}
