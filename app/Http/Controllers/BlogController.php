<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Donation;
use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = in_array($request->query('category'), Blog::categorySlugs(), true)
            ? $request->query('category')
            : null;

        $blogs = Blog::published()
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
            ->whereKeyNot($blog->getKey())
            ->latest('published_at')
            ->latest()
            ->take(3)
            ->get();

        $recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $recentFundraiserPosts = FundraiserPost::approved()
                ->with('fundraiser')
                ->addSelect([
                    'actual_raised_amount' => Donation::query()
                        ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0)')
                        ->whereColumn('donations.fundraiser_post_id', 'fundraiser_posts.id')
                        ->where('status', Donation::STATUS_PAID),
                ])
                ->latest('approved_at')
                ->latest()
                ->take(3)
                ->get();
        }

        $categoryCounts = $this->categoryCounts();
        $popularTags = $this->popularTags();

        return view('blogs.show', compact('blog', 'recentBlogs', 'recentFundraiserPosts', 'categoryCounts', 'popularTags'));
    }

    private function categoryCounts(): array
    {
        $counts = Blog::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return collect(Blog::categoryOptions())
            ->map(fn (string $label, string $slug) => [
                'label' => $label,
                'count' => (int) ($counts[$slug] ?? 0),
            ])
            ->all();
    }

    private function popularTags(): array
    {
        return Blog::published()
            ->get(['tags'])
            ->flatMap(fn (Blog $blog) => $blog->tagList())
            ->countBy()
            ->sortDesc()
            ->keys()
            ->take(10)
            ->values()
            ->all();
    }
}
