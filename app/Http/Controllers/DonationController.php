<?php

namespace App\Http\Controllers;

use App\Models\AdminActivity;
use App\Models\Donation;
use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function captureAmount(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:99999999'],
        ], [
            'amount.required' => 'Please enter a donation amount.',
            'amount.numeric' => 'Please enter a valid donation amount.',
            'amount.min' => 'Donation amount must be at least Rs. 1.',
        ]);

        $request->session()->put('pending_donation_amount', (float) $validated['amount']);

        return redirect()->route('donations.campaigns');
    }

    public function campaigns(): View
    {
        $posts = FundraiserPost::publiclyVisible()
            ->with('fundraiser')
            ->addSelect([
                'actual_raised_amount' => Donation::query()
                    ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0)')
                    ->whereColumn('donations.fundraiser_post_id', 'fundraiser_posts.id')
                    ->where('status', Donation::STATUS_PAID),
            ])
            ->latest('approved_at')
            ->latest()
            ->paginate(9);

        $pendingAmount = session('pending_donation_amount');

        return view('pages.donation-campaigns', compact('posts', 'pendingAmount'));
    }

    public function store(Request $request, FundraiserPost $post): RedirectResponse
    {
        $post->loadMissing('fundraiser');
        abort_unless(
            $post->status === FundraiserPost::STATUS_APPROVED
            && $post->fundraiser?->status === \App\Models\Fundraiser::STATUS_APPROVED,
            404
        );

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

        $donation = Donation::create([
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

        AdminActivity::create([
            'title' => 'New Donation Received',
            'message' => $donation->publicDonorName().' donated Rs. '.number_format((float) $donation->amount, 0).' to '.$post->title.'.',
            'type' => 'donation',
            'created_by' => $donation->publicDonorName(),
        ]);

        $request->session()->forget('pending_donation_amount');

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
