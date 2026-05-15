<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function store(Request $request, FundraiserPost $post): RedirectResponse
    {
        abort_unless($post->status === FundraiserPost::STATUS_APPROVED, 404);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'amount' => ['nullable', 'string', 'max:30'],
            'tip_amount' => ['nullable', 'numeric', 'min:0'],
            'tip_percent' => ['nullable', 'string', 'max:10'],
            'total_amount' => ['nullable', 'numeric', 'min:1'],
            'message' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'private' => ['nullable', 'boolean'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $contact = trim((string) $request->input('contact'));
            $hasValidEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
            $hasValidPhone = preg_match('/^\d{7,15}$/', preg_replace('/[\s()+-]/', '', $contact));

            if (!$hasValidEmail && !$hasValidPhone) {
                $validator->errors()->add('contact', 'Please enter a valid email ID or mobile number.');
            }

            if ($this->parseAmount($request->input('total_amount') ?? $request->input('amount')) <= 0) {
                $validator->errors()->add('amount', 'Please enter a valid donation amount.');
            }
        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'donation')
                ->withInput();
        }

        $contact = trim((string) $request->input('contact'));
        $mainAmount = $this->parseAmount($request->input('amount'));
        $tipAmount = $this->parseAmount($request->input('tip_amount'));
        $totalAmount = $this->parseAmount($request->input('total_amount'));
        $amount = $totalAmount > 0 ? $totalAmount : $mainAmount + $tipAmount;

        Donation::create([
            'fundraiser_post_id' => $post->id,
            'donor_name' => $request->input('name'),
            'donor_email' => filter_var($contact, FILTER_VALIDATE_EMAIL) ? $contact : null,
            'donor_phone' => filter_var($contact, FILTER_VALIDATE_EMAIL) ? null : preg_replace('/[\s()+-]/', '', $contact),
            'amount' => $amount,
            'main_amount' => $mainAmount,
            'tip_amount' => $tipAmount,
            'tip_percent' => $this->parseTipPercent($request->input('tip_percent')),
            'message' => $request->input('message'),
            'is_private' => $request->boolean('private'),
            'payment_method' => $request->input('payment_method', 'card'),
            'status' => Donation::STATUS_PAID,
            'paid_at' => now(),
        ]);

        return redirect()
            ->route('donate-us', $post)
            ->with('donation_success', [
                'message' => 'Payment successful',
                'paid_at' => Carbon::now()->format('d M Y, h:i A'),
            ]);
    }

    private function parseAmount(mixed $value): float
    {
        $amount = (float) preg_replace('/[^0-9.]/', '', (string) $value);

        return is_finite($amount) ? $amount : 0.0;
    }

    private function parseTipPercent(mixed $value): int
    {
        if ($value === 'other') {
            return 0;
        }

        return max(0, min(100, (int) $value));
    }
}
