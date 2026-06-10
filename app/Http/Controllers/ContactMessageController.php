<?php

namespace App\Http\Controllers;

use App\Mail\CallbackRequestSubmitted;
use App\Mail\ContactMessageSubmitted;
use App\Models\AdminActivity;
use App\Models\ContactMessage;
use App\Models\FundraiserReferral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->boolean('resource_callback')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'country_code' => ['required', 'string', 'max:10'],
                'phone' => ['required', 'string', 'max:30'],
                'reason' => ['required', 'string', 'max:120'],
                'estimated_cost' => ['required', 'string', 'max:120'],
                'preferred_language' => ['required', 'string', 'max:80'],
                'description' => ['nullable', 'string', 'max:3000'],
                'alternate_country_code' => ['nullable', 'string', 'max:10'],
                'alternate_phone' => ['nullable', 'string', 'max:30'],
            ]);

            $alternatePhone = trim(($validated['alternate_country_code'] ?? '').' '.($validated['alternate_phone'] ?? ''));

            $contactMessage = ContactMessage::create([
                'name' => $validated['name'],
                'email' => '',
                'phone' => trim($validated['country_code'].' '.$validated['phone']),
                'request_type' => 'Request a Call Back',
                'estimated_cost' => $validated['estimated_cost'],
                'preferred_language' => $validated['preferred_language'],
                'reason' => $validated['reason'],
                'description' => $validated['description'] ?? null,
                'alternate_phone' => $alternatePhone !== '' ? $alternatePhone : null,
                'message' => $validated['description'] ?? null,
            ]);

            FundraiserReferral::create([
                'source' => FundraiserReferral::SOURCE_REQUEST_CALLBACK,
                'name' => $validated['name'],
                'country_code' => $validated['country_code'],
                'phone' => $validated['phone'],
                'reason' => $validated['reason'],
                'estimated_cost' => $validated['estimated_cost'],
                'preferred_language' => $validated['preferred_language'],
                'alternate_country_code' => $validated['alternate_country_code'] ?? null,
                'alternate_phone' => $validated['alternate_phone'] ?? null,
                'status' => FundraiserReferral::STATUS_NEW,
            ]);

            AdminActivity::create([
                'title' => 'New Call Back Request',
                'message' => $validated['name'].' requested a call back for '.$validated['reason'].'.',
                'type' => 'contact',
                'created_by' => $validated['name'],
            ]);

            try {
                Mail::to($this->adminMailRecipient())->send(
                    new CallbackRequestSubmitted($contactMessage, $this->sourcePage($request))
                );
            } catch (\Throwable $e) {
                Log::error('Callback request email failed', [
                    'message' => $e->getMessage(),
                    'contact_message_id' => $contactMessage->id ?? null,
                ]);
            }

            return back()->with('status', 'Thank you. Our team will contact you shortly.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        AdminActivity::create([
            'title' => 'New Contact Form Submitted',
            'message' => $validated['name'].' submitted a contact message.',
            'type' => 'contact',
            'created_by' => $validated['name'],
        ]);

        try {
            Mail::to($this->adminMailRecipient())->send(
                new ContactMessageSubmitted($contactMessage, $this->sourcePage($request))
            );
        } catch (\Throwable $e) {
            Log::error('Contact message email failed', [
                'message' => $e->getMessage(),
                'contact_message_id' => $contactMessage->id ?? null,
            ]);
        }

        return back()->with('status', 'Your message has been submitted successfully.');
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
