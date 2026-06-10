<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CallbackRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public ?string $sourcePage = null,
    ) {
    }

    public function build(): static
    {
        return $this
            ->subject('New Call Back Request')
            ->view('emails.callback-request-submitted');
    }
}
