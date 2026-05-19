<x-header>
</x-header>

<main>
   <section class="event-page-hero" style="background-image: url('{{ asset('assets/images/banner/banner-two-bg.jpg') }}');">
      <div class="container">
         <div class="event-page-hero__content">
            <span>Events</span>
            <h1>Upcoming Events and Activities</h1>
            <p>Join the programs, outreach days, and community activities creating practical help where it is needed.</p>
         </div>
      </div>
   </section>

   <section class="event-list-page pt-120 pb-120">
      <div class="container">
         <div class="row gutter-40" id="event-results">
            @forelse ($events as $event)
               <div class="col-12 col-md-6 col-xl-4">
                  <article class="event-list-card">
                     <a class="event-list-card__image" href="{{ route('events.show', $event->slug) }}">
                        <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}">
                        <span>{{ $event->event_date?->format('M d') ?? 'Soon' }}</span>
                     </a>
                     <div class="event-list-card__body">
                        <div class="event-list-card__meta">
                           <span><i class="fa-solid fa-layer-group"></i>{{ $event->categoryLabel() }}</span>
                           <span><i class="fa-solid fa-clock"></i>{{ $event->event_time?->format('h:i A') ?? 'Time TBA' }}</span>
                           <span><i class="fa-solid fa-location-dot"></i>{{ $event->location ?: 'Location TBA' }}</span>
                        </div>
                        <h3><a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a></h3>
                        <p>{{ \Illuminate\Support\Str::limit($event->short_description ?: $event->full_description, 130) }}</p>
                        <a class="event-list-card__link" href="{{ route('events.show', $event->slug) }}">View Details<i class="fa-solid fa-arrow-right-long"></i></a>
                     </div>
                  </article>
               </div>
            @empty
               <div class="col-12">
                  <div class="event-empty-state">
                     <h3>No published events yet</h3>
                     <p>Published programs will appear here once they are added by the admin team.</p>
                  </div>
               </div>
            @endforelse
         </div>
         @if ($events->hasPages())
            <div class="mt-5">{{ $events->links() }}</div>
         @endif
      </div>
   </section>
</main>

<x-footer>
</x-footer>
