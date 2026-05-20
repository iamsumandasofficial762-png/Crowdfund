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

        $statusCounts = Fundraiser::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');
        $counts = collect($statuses)
            ->mapWithKeys(fn (string $statusKey) => [$statusKey => (int) ($statusCounts[$statusKey] ?? 0)])
            ->all();
        $counts['all'] = (int) $statusCounts->sum();

        $fundraisers = Fundraiser::query()
            ->withCount('posts')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $fundraiserIds = $fundraisers->getCollection()->pluck('id');
        $totals = Donation::query()
            ->join('fundraiser_posts', 'fundraiser_posts.id', '=', 'donations.fundraiser_post_id')
            ->where('donations.status', Donation::STATUS_PAID)
            ->whereIn('fundraiser_posts.fundraiser_id', $fundraiserIds)
            ->selectRaw('fundraiser_posts.fundraiser_id')
            ->selectRaw('COALESCE(SUM(CASE WHEN donations.main_amount > 0 THEN donations.main_amount WHEN donations.amount > donations.tip_amount THEN donations.amount - donations.tip_amount ELSE 0 END), 0) as total_raised_amount')
            ->selectRaw('COALESCE(SUM(donations.tip_amount), 0) as total_tip_amount')
            ->groupBy('fundraiser_posts.fundraiser_id')
            ->get()
            ->keyBy('fundraiser_id');

        $fundraisers->getCollection()->each(function (Fundraiser $fundraiser) use ($totals) {
            $fundraiserTotals = $totals->get($fundraiser->id);
            $fundraiser->total_raised_amount = (float) ($fundraiserTotals->total_raised_amount ?? 0);
            $fundraiser->total_tip_amount = (float) ($fundraiserTotals->total_tip_amount ?? 0);
        });

        return view('admin.fundraisers.index', compact('fundraisers', 'status', 'counts'));
    }

    public function show(Fundraiser $fundraiser): View
    {
        $fundraiser->load(['posts' => fn ($query) => $query->latest()]);
        $postIds = $fundraiser->posts->pluck('id');
        $donationTotals = Donation::paid()
            ->whereIn('fundraiser_post_id', $postIds)
            ->selectRaw('fundraiser_post_id')
            ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0) as raised_amount')
            ->selectRaw('COALESCE(SUM(tip_amount), 0) as tip_amount')
            ->groupBy('fundraiser_post_id')
            ->get()
            ->keyBy('fundraiser_post_id');

        $posts = $fundraiser->posts->map(function (FundraiserPost $post) use ($donationTotals) {
            $totals = $donationTotals->get($post->id);
            $post->calculated_raised_amount = (float) ($totals->raised_amount ?? $post->raised_amount);
            $post->calculated_tip_amount = (float) ($totals->tip_amount ?? 0);

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

}
