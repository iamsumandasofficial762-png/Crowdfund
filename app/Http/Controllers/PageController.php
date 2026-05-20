<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Blog;
use App\Models\FundraiserPost;
use App\Support\PublicSiteCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function home()
    {
        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $postIds = Cache::remember(PublicSiteCache::HOME_POSTS, PublicSiteCache::seconds(), function () {
                return FundraiserPost::publiclyVisible()
                    ->latest('approved_at')
                    ->latest()
                    ->take(3)
                    ->pluck('id')
                    ->all();
            });

            $recentFundraiserPosts = FundraiserPost::publiclyVisible()
                ->select(['id', 'fundraiser_id', 'title', 'short_description', 'goal_amount', 'raised_amount', 'category', 'main_image', 'approved_at', 'created_at', 'status'])
                ->with(['fundraiser:id,name,status'])
                ->whereKey($postIds)
                ->addSelect([
                    'actual_raised_amount' => Donation::query()
                        ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0)')
                        ->whereColumn('donations.fundraiser_post_id', 'fundraiser_posts.id')
                        ->where('status', Donation::STATUS_PAID),
                ])
                ->latest('approved_at')
                ->latest()
                ->get();
        }

        $latestBlogs = collect();

        if (Schema::hasTable('blogs')) {
            $blogIds = Cache::remember(PublicSiteCache::HOME_BLOGS, PublicSiteCache::seconds(), function () {
                return Blog::published()
                    ->latest('published_at')
                    ->latest()
                    ->take(3)
                    ->pluck('id')
                    ->all();
            });

            $latestBlogs = Blog::published()
                ->select(['id', 'blog_category_id', 'title', 'slug', 'category', 'short_description', 'featured_image', 'published_at', 'created_at', 'status'])
                ->with('blogCategory:id,name,slug')
                ->whereKey($blogIds)
                ->latest('published_at')
                ->latest()
                ->get();
        }

        return view('index', compact('recentFundraiserPosts', 'latestBlogs'));
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

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function resource()
    {
        return view('pages.resource');
    }

    public function donate(Request $request, ?FundraiserPost $post = null)
    {
        $post?->loadMissing('fundraiser');

        if (
            $post
            && (
                $post->status !== FundraiserPost::STATUS_APPROVED
                || $post->fundraiser?->status !== \App\Models\Fundraiser::STATUS_APPROVED
            )
        ) {
            abort(404);
        }

        $pendingDonationAmount = $this->parseDonationAmount(
            $request->query('amount', session('pending_donation_amount'))
        );
        $shouldOpenDonationModal = (bool) $post && ($request->boolean('donate') || $pendingDonationAmount > 0);

        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $recentFundraiserPosts = FundraiserPost::publiclyVisible()
                ->select(['id', 'fundraiser_id', 'title', 'short_description', 'goal_amount', 'raised_amount', 'category', 'main_image', 'approved_at', 'created_at', 'status'])
                ->with('fundraiser:id,name,status')
                ->addSelect([
                    'actual_raised_amount' => Donation::query()
                        ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0)')
                        ->whereColumn('donations.fundraiser_post_id', 'fundraiser_posts.id')
                        ->where('status', Donation::STATUS_PAID),
                ])
                ->when($post, fn ($query) => $query->whereKeyNot($post->getKey()))
                ->latest('approved_at')
                ->latest()
                ->take(3)
                ->get();
        }

        $topSupporters = collect();
        $supporters = collect();
        $supporterCount = 0;

        if ($post && Schema::hasTable('donations')) {
            $post->loadMissing('fundraiser');

            $supporterCount = $post->paidDonations()->count();
            $donationsRaisedAmount = (float) $post->paidDonations()
                ->selectRaw('SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END) as raised_amount')
                ->value('raised_amount');

            if ($donationsRaisedAmount > 0) {
                $post->raised_amount = $donationsRaisedAmount;
            }

            $topSupporters = $post->paidDonations()
                ->orderByDesc(DB::raw('CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END'))
                ->latest('paid_at')
                ->latest()
                ->take(10)
                ->get();

            $supporters = $post->paidDonations()
                ->latest('paid_at')
                ->latest()
                ->take(20)
                ->get();
        } else {
            $post?->loadMissing('fundraiser');
        }

        if ($post && Schema::hasTable('fundraiser_post_updates')) {
            $post->load(['publishedUpdates' => fn ($query) => $query->orderByDesc('is_pinned')->latest()]);
        }

        return view('pages.donate-us', compact(
            'post',
            'recentFundraiserPosts',
            'topSupporters',
            'supporters',
            'supporterCount',
            'pendingDonationAmount',
            'shouldOpenDonationModal'
        ));
    }

    private function parseDonationAmount(mixed $value): float
    {
        $amount = (float) preg_replace('/[^0-9.]/', '', (string) $value);

        return is_finite($amount) && $amount > 0 ? $amount : 0.0;
    }
}
