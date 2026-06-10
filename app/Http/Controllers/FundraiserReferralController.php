<?php

namespace App\Http\Controllers;

use App\Mail\FundraiserReferralSubmitted;
use App\Models\FundraiserPost;
use App\Models\FundraiserReferral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FundraiserReferralController extends Controller
{
    public function store(Request $request, ?FundraiserPost $post = null): RedirectResponse
    {
        if ($post && $post->status !== FundraiserPost::STATUS_APPROVED) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country_code' => ['required', 'string', 'max:10'],
            'phone' => ['required', 'string', 'max:30'],
            'reason' => ['required', 'string', 'max:120'],
            'estimated_cost' => ['required', 'string', 'max:120'],
            'preferred_language' => ['required', 'string', 'max:80'],
            'alternate_country_code' => ['nullable', 'string', 'max:10'],
            'alternate_phone' => ['nullable', 'string', 'max:30'],
        ]);

        $referral = FundraiserReferral::create([
            ...$validated,
            'fundraiser_post_id' => $post?->id,
            'source' => FundraiserReferral::SOURCE_REFER_US,
            'status' => FundraiserReferral::STATUS_NEW,
        ]);

        try {
            Mail::to($this->adminMailRecipient())->send(
                new FundraiserReferralSubmitted($referral, $this->sourcePage($request))
            );
        } catch (\Throwable $e) {
            Log::error('Fundraiser referral email failed', [
                'message' => $e->getMessage(),
                'fundraiser_referral_id' => $referral->id ?? null,
            ]);
        }

        return back()->with('status', 'Thank you. Our team will contact you shortly.');
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
