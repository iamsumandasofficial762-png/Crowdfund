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
            $postIds = Cache::remember(PublicSiteCache::FOOTER_POSTS, PublicSiteCache::seconds(), function () {
                return FundraiserPost::publiclyVisible()
                    ->latest('approved_at')
                    ->latest()
                    ->take(2)
                    ->pluck('id')
                    ->all();
            });

            $this->recentFundraiserPosts = FundraiserPost::publiclyVisible()
                ->select(['id', 'fundraiser_id', 'title', 'main_image', 'approved_at', 'created_at', 'status'])
                ->whereKey($postIds)
                ->latest('approved_at')
                ->latest()
                ->get();
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
