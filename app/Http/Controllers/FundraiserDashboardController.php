<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundraiserDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $fundraiser = $request->attributes->get('fundraiser');

        $recentPosts = $fundraiser->posts()
            ->withSum('paidDonations', 'amount')
            ->withCount('paidDonations')
            ->latest()
            ->take(4)
            ->get();

        $stats = [
            'total_posts' => $fundraiser->posts()->count(),
            'pending_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_PENDING)->count(),
            'approved_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_APPROVED)->count(),
            'rejected_posts' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_REJECTED)->count(),
            'total_raised' => (float) $fundraiser->posts()->withSum('paidDonations', 'amount')->get()->sum('paid_donations_sum_amount'),
            'total_donors' => $fundraiser->posts()->withCount('paidDonations')->get()->sum('paid_donations_count'),
        ];

        return view('fundraiser.dashboard', compact('fundraiser', 'recentPosts', 'stats'));
    }
}
