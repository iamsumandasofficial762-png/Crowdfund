<?php

namespace App\Http\Controllers;

use App\Mail\FundraiserReportSubmitted;
use App\Models\AdminActivity;
use App\Models\FundraiserPost;
use App\Models\FundraiserReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $validated['message'] = trim((string) ($validated['message'] ?? '')) ?: null;
        $validated['fundraiser_post_id'] = $post->id;

        $report = FundraiserReport::create($validated);

        $reporterName = trim((string) ($report->name ?: 'A supporter'));

        AdminActivity::create([
            'title' => 'New Supporter Report Submitted',
            'message' => $reporterName.' reported '.$post->title.'.',
            'type' => 'report',
            'created_by' => $report->name,
        ]);

        try {
            Mail::to($this->adminMailRecipient())->send(
                new FundraiserReportSubmitted($report, $this->sourcePage($request))
            );
        } catch (\Throwable $e) {
            Log::error('Fundraiser report email failed', [
                'message' => $e->getMessage(),
                'fundraiser_report_id' => $report->id ?? null,
            ]);
        }

        return back()->with('status', 'Your report has been submitted successfully.');
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
