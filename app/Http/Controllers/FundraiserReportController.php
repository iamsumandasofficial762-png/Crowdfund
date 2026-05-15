<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use App\Models\FundraiserReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FundraiserReportController extends Controller
{
    public function store(Request $request, FundraiserPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'country_code' => ['nullable', 'string', 'max:8'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:3000'],
            'supporting_document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('supporting_document')) {
            $validated['supporting_document'] = $request->file('supporting_document')->store('fundraiser-reports', 'public');
        }

        $validated['fundraiser_post_id'] = $post->id;

        FundraiserReport::create($validated);

        return back()->with('status', 'Your report has been submitted successfully.');
    }
}
