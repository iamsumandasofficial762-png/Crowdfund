<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Donation;
use App\Models\FundraiserPost;
use App\Support\PublicSiteCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = in_array($request->query('category'), Blog::categorySlugs(), true)
            ? $request->query('category')
            : null;

        $blogs = Blog::published()
            ->select(['id', 'blog_category_id', 'title', 'slug', 'category', 'short_description', 'featured_image', 'published_at', 'created_at', 'status'])
            ->with('blogCategory:id,name,slug')
            ->category($selectedCategory)
            ->latest('published_at')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categoryCounts = $this->categoryCounts();
        $popularTags = $this->popularTags();
        $allBlogCount = Blog::published()->count();

        return view('blogs.index', compact('blogs', 'selectedCategory', 'categoryCounts', 'popularTags', 'allBlogCount'));
    }

    public function show(string $slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentBlogs = Blog::published()
            ->select(['id', 'blog_category_id', 'title', 'slug', 'category', 'short_description', 'featured_image', 'published_at', 'created_at', 'status'])
            ->with('blogCategory:id,name,slug')
            ->whereKeyNot($blog->getKey())
            ->latest('published_at')
            ->latest()
            ->take(3)
            ->get();

        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $postIds = Cache::remember(PublicSiteCache::EVENT_RECENT_FUNDRAISERS, PublicSiteCache::seconds(), function () {
                return FundraiserPost::publiclyVisible()
                    ->latest('approved_at')
                    ->latest()
                    ->take(3)
                    ->pluck('id')
                    ->all();
            });

            $recentFundraiserPosts = FundraiserPost::publiclyVisible()
                ->select(['id', 'fundraiser_id', 'title', 'short_description', 'goal_amount', 'raised_amount', 'category', 'main_image', 'approved_at', 'created_at', 'status'])
                ->with('fundraiser:id,name,status')
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

        $categoryCounts = $this->categoryCounts();
        $popularTags = $this->popularTags();

        return view('blogs.show', compact('blog', 'recentBlogs', 'recentFundraiserPosts', 'categoryCounts', 'popularTags'));
    }

    private function categoryCounts(): array
    {
        $counts = Cache::remember(PublicSiteCache::BLOG_CATEGORY_COUNTS, PublicSiteCache::seconds(), function () {
            return Blog::published()
                ->selectRaw('category, COUNT(*) as total')
                ->groupBy('category')
                ->pluck('total', 'category')
                ->all();
        });

        return collect(Blog::categoryOptions())
            ->map(fn (string $label, string $slug) => [
                'label' => $label,
                'count' => (int) ($counts[$slug] ?? 0),
            ])
            ->all();
    }

    private function popularTags(): array
    {
        return Cache::remember(PublicSiteCache::BLOG_POPULAR_TAGS, PublicSiteCache::seconds(), function () {
            return Blog::published()
                ->get(['tags'])
                ->flatMap(fn (Blog $blog) => $blog->tagList())
                ->countBy()
                ->sortDesc()
                ->keys()
                ->take(10)
                ->values()
                ->all();
        });
    }
}
