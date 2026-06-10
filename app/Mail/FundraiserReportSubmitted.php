<?php

namespace App\Mail;

use App\Models\FundraiserReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FundraiserReportSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FundraiserReport $report,
        public ?string $sourcePage = null,
    ) {
        $this->report->loadMissing('fundraiserPost');
    }

    public function build(): static
    {
        return $this
            ->subject('New Supporter Report Submitted')
            ->view('emails.fundraiser-report-submitted');
    }
}
