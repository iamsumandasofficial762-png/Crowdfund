<?php

namespace App\Http\Controllers;

use App\Mail\SiteReportSubmitted;
use App\Models\SiteReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $siteReport = SiteReport::create($validated);

        try {
            Mail::to($this->adminMailRecipient())->send(
                new SiteReportSubmitted($siteReport, $this->sourcePage($request))
            );
        } catch (\Throwable $e) {
            Log::error('Site report email failed', [
                'message' => $e->getMessage(),
                'site_report_id' => $siteReport->id ?? null,
            ]);
        }

        return back()->with('status', 'Your site report has been submitted successfully.');
    }

    private function adminMailRecipient(): ?string
    {
        return config('mail.admin_address') ?: env('MAIL_ADMIN_ADDRESS') ?: config('mail.from.address');
    }

    private function sourcePage(Request $request): string
    {
        return $request->headers->get('referer') ?: $request->fullUrl();
    }
}
