<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Event;
use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = in_array($request->query('category'), Event::categorySlugs(), true)
            ? $request->query('category')
            : null;

        $events = Event::published()
            ->category($selectedCategory)
            ->orderByRaw('event_date IS NULL')
            ->orderByDesc('event_date')
            ->orderBy('event_time')
            ->paginate(9)
            ->withQueryString();

        $categoryCards = Event::categoryCards();
        $recentFundraiserPosts = $this->recentFundraiserPosts();

        return view('events.index', compact('events', 'categoryCards', 'selectedCategory', 'recentFundraiserPosts'));
    }

    public function show(string $slug)
    {
        $event = Event::published()->where('slug', $slug)->firstOrFail();

        $relatedEvents = Event::published()
            ->whereKeyNot($event->getKey())
            ->orderByRaw('event_date IS NULL')
            ->orderByDesc('event_date')
            ->latest()
            ->take(4)
            ->get();

        $categoryCounts = $this->categoryCounts();
        $recentFundraiserPosts = $this->recentFundraiserPosts();

        return view('events.show', compact('event', 'relatedEvents', 'categoryCounts', 'recentFundraiserPosts'));
    }

    private function categoryCounts(): array
    {
        $counts = Event::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return collect(Event::categoryOptions())
            ->map(fn (string $label, string $slug) => [
                'label' => $label,
                'count' => (int) ($counts[$slug] ?? 0),
            ])
            ->all();
    }

    private function recentFundraiserPosts()
    {
        if (! Schema::hasTable('fundraiser_posts')) {
            return collect();
        }

        return FundraiserPost::approved()
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
}
