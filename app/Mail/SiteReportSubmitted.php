<?php

namespace App\Mail;

use App\Models\SiteReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteReportSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SiteReport $siteReport,
        public ?string $sourcePage = null,
    ) {
    }

    public function build(): static
    {
        return $this
            ->subject('New Site Report Submitted')
            ->view('emails.site-report-submitted');
    }
}
