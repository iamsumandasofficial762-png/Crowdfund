<?php

namespace App\View\Components;

use App\Models\FundraiserPost;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Component;

class footer extends Component
{
    public Collection $recentFundraiserPosts;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->recentFundraiserPosts = collect();

        if (Schema::hasTable('fundraiser_posts')) {
            $this->recentFundraiserPosts = FundraiserPost::approved()
                ->latest('approved_at')
                ->latest()
                ->take(2)
                ->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
