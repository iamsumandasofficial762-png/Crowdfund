<x-header>
</x-header>

<main>
   <section class="event-detail-hero" style="background-image: url('{{ $event->imageUrl() }}');">
      <div class="container">
         <div class="event-detail-hero__content">
            <a href="{{ route('events.index') }}">Events</a>
            <h1>{{ $event->title }}</h1>
         </div>
      </div>
   </section>

   <section class="event-detail-page pt-120 pb-120">
      <div class="container">
         <div class="row gutter-40">
            <div class="col-12 col-xl-8">
               <article class="event-detail-article">
                  <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}">
                  <h2>{{ $event->title }}</h2>
                  @if ($event->short_description)
                     <p class="event-detail-lead">{{ $event->short_description }}</p>
                  @endif
                  <div class="event-detail-content">
                     @forelse (preg_split('/\R{2,}/', trim((string) $event->full_description)) as $paragraph)
                        @if (trim($paragraph) !== '')
                           <p>{!! nl2br(e($paragraph)) !!}</p>
                        @endif
                     @empty
                        <p>More details for this event will be shared soon.</p>
                     @endforelse
                  </div>
               </article>
            </div>
            <div class="col-12 col-xl-4">
               <aside class="event-detail-sidebar">
                  <div class="event-detail-widget event-detail-info">
                     <h3>Event Information</h3>
                     <div><i class="fa-solid fa-layer-group"></i><span><strong>Category</strong>{{ $event->categoryLabel() }}</span></div>
                     <div><i class="fa-solid fa-calendar-days"></i><span><strong>Date</strong>{{ $event->event_date?->format('d M Y') ?? 'To be announced' }}</span></div>
                     <div><i class="fa-solid fa-clock"></i><span><strong>Time</strong>{{ $event->event_time?->format('h:i A') ?? 'To be announced' }}</span></div>
                     <div><i class="fa-solid fa-location-dot"></i><span><strong>Location</strong>{{ $event->location ?: 'To be announced' }}</span></div>
                     @if ($event->organizer_name)
                        <div><i class="fa-solid fa-user"></i><span><strong>Organizer</strong>{{ $event->organizer_name }}</span></div>
                     @endif
                     @if ($event->contact_email)
                        <div><i class="fa-solid fa-envelope"></i><span><strong>Email</strong><a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a></span></div>
                     @endif
                     @if ($event->contact_phone)
                        <div><i class="fa-solid fa-phone"></i><span><strong>Phone</strong><a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a></span></div>
                     @endif
                  </div>
                  <div class="event-detail-widget">
                     <h3>Categories</h3>
                     <div class="event-detail-categories">
                        <a class="event-detail-category" href="{{ route('events.index') }}#event-results">
                           <span>All Events</span>
                           <strong>{{ str_pad(array_sum(array_column($categoryCounts, 'count')), 2, '0', STR_PAD_LEFT) }}</strong>
                        </a>
                        @foreach ($categoryCounts as $categorySlug => $category)
                           <a class="event-detail-category {{ $event->category === $categorySlug ? 'is-active' : '' }}" href="{{ route('events.index', ['category' => $categorySlug]) }}#event-results">
                              <span>{{ $category['label'] }}</span>
                              <strong>{{ str_pad($category['count'], 2, '0', STR_PAD_LEFT) }}</strong>
                           </a>
                        @endforeach
                     </div>
                  </div>
                  <div class="event-detail-widget">
                     <h3>More Events</h3>
                     @forelse ($relatedEvents as $relatedEvent)
                        <a class="event-detail-related" href="{{ route('events.show', $relatedEvent->slug) }}">
                           <img src="{{ $relatedEvent->imageUrl() }}" alt="{{ $relatedEvent->title }}">
                           <span>
                              <small>{{ $relatedEvent->event_date?->format('d M Y') ?? 'Soon' }}</small>
                              <strong>{{ \Illuminate\Support\Str::limit($relatedEvent->title, 58) }}</strong>
                           </span>
                        </a>
                     @empty
                        <p class="mb-0">More published events will appear here soon.</p>
                     @endforelse
                  </div>
               </aside>
            </div>
         </div>
      </div>
   </section>
</main>

<x-footer>
</x-footer>
