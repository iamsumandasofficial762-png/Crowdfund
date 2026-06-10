<?php

namespace App\Mail;

use App\Models\FundraiserReferral;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FundraiserReferralSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FundraiserReferral $referral,
        public ?string $sourcePage = null,
    ) {
        $this->referral->loadMissing('fundraiserPost');
    }

    public function build(): static
    {
        return $this
            ->subject('New Refer Us Request')
            ->view('emails.fundraiser-referral-submitted');
    }
}
