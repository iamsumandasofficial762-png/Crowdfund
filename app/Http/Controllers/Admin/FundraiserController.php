<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Fundraiser;
use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FundraiserController extends Controller
{
    public function index(): View
    {
        $fundraisers = Fundraiser::query()
            ->with(['posts.paidDonations'])
            ->withCount('posts')
            ->latest()
            ->paginate(20);

        $fundraisers->getCollection()->transform(
            fn (Fundraiser $fundraiser) => $this->attachTotals($fundraiser)
        );

        return view('admin.fundraisers.index', compact('fundraisers'));
    }

    public function show(Fundraiser $fundraiser): View
    {
        $fundraiser->load(['posts' => fn ($query) => $query->with('paidDonations')->latest()]);
        $this->attachTotals($fundraiser);

        $posts = $fundraiser->posts->map(function (FundraiserPost $post) {
            $post->calculated_raised_amount = $this->postRaisedAmount($post);
            $post->calculated_tip_amount = $this->postTipAmount($post);

            return $post;
        });

        $summary = [
            'total_posts' => $posts->count(),
            'pending_posts' => $posts->where('status', FundraiserPost::STATUS_PENDING)->count(),
            'approved_posts' => $posts->where('status', FundraiserPost::STATUS_APPROVED)->count(),
            'rejected_posts' => $posts->where('status', FundraiserPost::STATUS_REJECTED)->count(),
            'total_goal_amount' => $posts->sum(fn (FundraiserPost $post) => (float) $post->goal_amount),
            'total_raised_amount' => $posts->sum(fn (FundraiserPost $post) => (float) $post->calculated_raised_amount),
            'total_tip_amount' => $posts->sum(fn (FundraiserPost $post) => (float) $post->calculated_tip_amount),
        ];

        return view('admin.fundraisers.show', compact('fundraiser', 'posts', 'summary'));
    }

    public function legacySupporters(): RedirectResponse
    {
        return redirect()->route('admin.fundraisers.index');
    }

    private function attachTotals(Fundraiser $fundraiser): Fundraiser
    {
        $fundraiser->total_raised_amount = $fundraiser->posts->sum(
            fn (FundraiserPost $post) => $this->postRaisedAmount($post)
        );
        $fundraiser->total_tip_amount = $fundraiser->posts->sum(
            fn (FundraiserPost $post) => $this->postTipAmount($post)
        );
        $fundraiser->approved_posts_count = $fundraiser->posts->where('status', FundraiserPost::STATUS_APPROVED)->count();

        return $fundraiser;
    }

    private function postRaisedAmount(FundraiserPost $post): float
    {
        if ($post->relationLoaded('paidDonations') && $post->paidDonations->isNotEmpty()) {
            return $post->paidDonations->sum(fn (Donation $donation) => $this->mainDonationAmount($donation));
        }

        return (float) $post->raised_amount;
    }

    private function postTipAmount(FundraiserPost $post): float
    {
        if ($post->relationLoaded('paidDonations')) {
            return $post->paidDonations->sum(fn (Donation $donation) => (float) $donation->tip_amount);
        }

        return 0.0;
    }

    private function mainDonationAmount(Donation $donation): float
    {
        $mainAmount = (float) $donation->main_amount;

        if ($mainAmount > 0) {
            return $mainAmount;
        }

        return max((float) $donation->amount - (float) $donation->tip_amount, 0);
    }
}
