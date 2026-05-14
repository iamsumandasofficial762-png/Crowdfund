<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use App\Models\FundraiserReferral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        FundraiserReferral::create([
            ...$validated,
            'fundraiser_post_id' => $post?->id,
            'status' => FundraiserReferral::STATUS_NEW,
        ]);

        return back()->with('status', 'Thank you. Our team will contact you shortly.');
    }
}
