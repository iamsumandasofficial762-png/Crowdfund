<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Fundraiser;
use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundraiserController extends Controller
{
    public function index(Request $request): View
    {
        $statuses = [
            Fundraiser::STATUS_PENDING,
            Fundraiser::STATUS_APPROVED,
            Fundraiser::STATUS_HOLD,
            Fundraiser::STATUS_REJECTED,
        ];
        $status = $request->query('status', 'all');

        if (! in_array($status, [...$statuses, 'all'], true)) {
            $status = 'all';
        }

        $counts = collect($statuses)
            ->mapWithKeys(fn (string $statusKey) => [
                $statusKey => Fundraiser::where('status', $statusKey)->count(),
            ])
            ->all();
        $counts['all'] = Fundraiser::count();

        $fundraisers = Fundraiser::query()
            ->with(['posts.paidDonations'])
            ->withCount('posts')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $fundraisers->getCollection()->transform(
            fn (Fundraiser $fundraiser) => $this->attachTotals($fundraiser)
        );

        return view('admin.fundraisers.index', compact('fundraisers', 'status', 'counts'));
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

    public function approve(Fundraiser $fundraiser): RedirectResponse
    {
        $fundraiser->update([
            'status' => Fundraiser::STATUS_APPROVED,
            'approved_at' => now(),
            'held_at' => null,
            'rejected_at' => null,
            'hold_reason' => null,
            'rejected_reason' => null,
        ]);

        return back()->with('status', 'Fundraiser approved successfully.');
    }

    public function hold(Request $request, Fundraiser $fundraiser): RedirectResponse
    {
        $validated = $request->validate([
            'hold_reason' => ['required', 'string', 'max:5000'],
        ]);

        $fundraiser->update([
            'status' => Fundraiser::STATUS_HOLD,
            'hold_reason' => $validated['hold_reason'],
            'held_at' => now(),
            'approved_at' => null,
            'rejected_at' => null,
            'rejected_reason' => null,
        ]);

        return back()->with('status', 'Fundraiser moved to hold successfully.');
    }

    public function reject(Request $request, Fundraiser $fundraiser): RedirectResponse
    {
        $validated = $request->validate([
            'rejected_reason' => ['required', 'string', 'max:5000'],
        ]);

        $fundraiser->update([
            'status' => Fundraiser::STATUS_REJECTED,
            'rejected_reason' => $validated['rejected_reason'],
            'rejected_at' => now(),
            'approved_at' => null,
            'held_at' => null,
            'hold_reason' => null,
        ]);

        return back()->with('status', 'Fundraiser rejected successfully.');
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
