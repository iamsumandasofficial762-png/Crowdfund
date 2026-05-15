<?php

namespace App\Http\Controllers;

use App\Models\SiteReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'page_url' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
            'supporting_document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('supporting_document')) {
            $validated['supporting_document'] = $request->file('supporting_document')->store('site-reports', 'public');
        }

        SiteReport::create($validated);

        return back()->with('status', 'Your site report has been submitted successfully.');
    }
}
