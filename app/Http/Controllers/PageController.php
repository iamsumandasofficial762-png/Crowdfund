<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function home()
    {
        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $recentFundraiserPosts = FundraiserPost::approved()
                ->with('fundraiser')
                ->latest('approved_at')
                ->latest()
                ->take(3)
                ->get();
        }

        return view('index', compact('recentFundraiserPosts'));
    }

    public function comingSoon()
    {
        return view('soon');
    }

    public function contact()
    {
        return view('pages.contact-us');
    }

    public function about()
    {
        return view('pages.about-us');
    }

    public function donate(?FundraiserPost $post = null)
    {
        if ($post && $post->status !== FundraiserPost::STATUS_APPROVED) {
            abort(404);
        }

        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $recentFundraiserPosts = FundraiserPost::approved()
                ->with('fundraiser')
                ->when($post, fn ($query) => $query->whereKeyNot($post->getKey()))
                ->latest('approved_at')
                ->latest()
                ->take(3)
                ->get();
        }

        $topSupporters = collect();
        $supporterCount = 0;

        if ($post && Schema::hasTable('donations')) {
            $post->loadMissing('fundraiser');

            $supporterCount = $post->paidDonations()->count();
            $donationsRaisedAmount = (float) $post->paidDonations()->sum('amount');

            if ($donationsRaisedAmount > 0) {
                $post->raised_amount = $donationsRaisedAmount;
            }

            $topSupporters = $post->paidDonations()
                ->orderByDesc('amount')
                ->latest('paid_at')
                ->latest()
                ->take(10)
                ->get();
        } else {
            $post?->loadMissing('fundraiser');
        }

        return view('pages.donate-us', compact('post', 'recentFundraiserPosts', 'topSupporters', 'supporterCount'));
    }
}
