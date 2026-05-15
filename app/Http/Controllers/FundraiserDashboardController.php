<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundraiserDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $fundraiser = $request->attributes->get('fundraiser');
        $postIds = $fundraiser->posts()->pluck('id');
        $mainAmountExpression = 'CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END';

        $recentPosts = $fundraiser->posts()
            ->withCount('paidDonations')
            ->latest()
            ->take(4)
            ->get();
        $recentPostMainTotals = Donation::paid()
            ->whereIn('fundraiser_post_id', $recentPosts->pluck('id'))
            ->selectRaw("fundraiser_post_id, COALESCE(SUM({$mainAmountExpression}), 0) as main_amount_sum")
            ->groupBy('fundraiser_post_id')
            ->pluck('main_amount_sum', 'fundraiser_post_id');

        $recentPosts->each(function (FundraiserPost $post) use ($recentPostMainTotals) {
            $post->setAttribute('paid_donations_main_sum_amount', (float) ($recentPostMainTotals[$post->id] ?? 0));
        });

        $totalRaised = Donation::paid()
            ->whereIn('fundraiser_post_id', $postIds)
            ->selectRaw("COALESCE(SUM({$mainAmountExpression}), 0) as total")
            ->value('total');

        $stats = [
            'total_posts' => $fundraiser->posts()->count(),
            'pending_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_PENDING)->count(),
            'approved_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_APPROVED)->count(),
            'rejected_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_REJECTED)->count(),
            'total_raised' => (float) $totalRaised,
            'total_donors' => $fundraiser->posts()->withCount('paidDonations')->get()->sum('paid_donations_count'),
        ];

        return view('fundraiser.dashboard', compact('fundraiser', 'recentPosts', 'stats'));
    }
}
