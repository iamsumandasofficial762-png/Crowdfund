<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
use App\Models\ContactMessage;
use App\Models\FundraiserReferral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

            ContactMessage::create([
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

            return back()->with('status', 'Thank you. Our team will contact you shortly.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        ContactMessage::create($validated);

        AdminActivity::create([
            'title' => 'New Contact Form Submitted',
            'message' => $validated['name'].' submitted a contact message.',
            'type' => 'contact',
            'created_by' => $validated['name'],
        ]);

        return back()->with('status', 'Your message has been submitted successfully.');
    }
}
