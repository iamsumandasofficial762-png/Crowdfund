<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationPaymentDetailsSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Donation $donation,
        public ?string $sourcePage = null,
    ) {
        $this->donation->loadMissing('fundraiserPost');
    }

    public function build(): static
    {
        return $this
            ->subject('New Donation Payment Details Submitted')
            ->view('emails.donation-payment-details-submitted');
    }
}
