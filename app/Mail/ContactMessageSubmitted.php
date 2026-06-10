<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageSubmitted extends Mailable
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
            ->subject('New Contact Form Submitted')
            ->view('emails.contact-message-submitted');
    }
}
