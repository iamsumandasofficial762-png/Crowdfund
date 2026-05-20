<?php

namespace App\View\Components;

use App\Models\FundraiserPost;
use App\Support\PublicSiteCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;

class Footer extends Component
{
    public Collection $recentFundraiserPosts;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $postRows = Cache::remember(PublicSiteCache::FOOTER_POSTS, PublicSiteCache::seconds(), function () {
                return FundraiserPost::publiclyVisible()
                    ->select(['id', 'fundraiser_id', 'title', 'main_image', 'approved_at', 'created_at', 'status'])
                    ->latest('approved_at')
                    ->latest()
                    ->take(2)
                    ->get()
                    ->map(fn (FundraiserPost $post) => $post->getAttributes())
                    ->all();
            });

            $this->recentFundraiserPosts = FundraiserPost::hydrate($postRows);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer', [
            'recentFundraiserPosts' => $this->recentFundraiserPosts,
        ]);
    }
}
