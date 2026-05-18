<x-header>
</x-header>

<div class="mobile-menu d-block d-xl-none">
   <nav class="mobile-menu__wrapper">
      <div class="mobile-menu__header nav-fade">
         <div class="logo">
            <a href="{{ route('home') }}" aria-label="home page" title="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
         </div>
         <button aria-label="close mobile menu" class="close-mobile-menu">
         <i class="fa-solid fa-xmark"></i>
         </button>
      </div>
      <div class="mobile-menu__list"></div>
      <div class="mobile-menu__cta nav-fade d-block d-md-none">
         <a href="{{ route('fundraiser-posts.index', ['menu' => 'donate']) }}" class="btn--secondary" data-text="Donate Now"><span>Donate Now</span></a>
      </div>
   </nav>
</div>

<main>
   <section class="blog-detail-hero" style="background-image: url('{{ asset('assets/images/banner/banner-bg.jpg') }}');">
      <div class="container">
         <div class="blog-detail-hero__inner">
            <h1>Blog Details</h1>
         </div>
      </div>
      <div class="blog-detail-hero__crumb">
         <div class="container">
            <div class="blog-detail-breadcrumb">
               <a href="{{ route('home') }}">Home</a>
               <span>/</span>
               <span>Blog Details</span>
            </div>
         </div>
      </div>
   </section>

   <section class="blog-detail-page pt-120 pb-120">
      <div class="container">
         <div class="row gutter-40">
            <div class="col-12 col-xl-8">
               <article class="blog-detail-article">
                  <img class="blog-detail-article__image" src="{{ $blog->imageUrl() }}" alt="{{ $blog->title }}">
                  <div class="blog-detail-article__meta">
                     <span><i class="fa-solid fa-calendar-days"></i>{{ $blog->displayDate()->format('d M Y') }}</span>
                     <span><i class="fa-solid fa-user"></i>Karna Kabach Team</span>
                     <span><i class="fa-solid fa-tags"></i>{{ $blog->categoryLabel() }}</span>
                  </div>
                  <h2>{{ $blog->title }}</h2>
                  @if ($blog->tagList())
                     <div class="blog-detail-tags blog-detail-tags--inline">
                        @foreach ($blog->tagList() as $tag)
                           <span>{{ $tag }}</span>
                        @endforeach
                     </div>
                  @endif
                  @if ($blog->short_description)
                     <p class="blog-detail-article__lead">{{ $blog->short_description }}</p>
                  @endif
                  <div class="blog-detail-article__content">
                     @foreach (preg_split('/\R{2,}/', trim($blog->full_description)) as $paragraph)
                        @if (trim($paragraph) !== '')
                           <p>{!! nl2br(e($paragraph)) !!}</p>
                        @endif
                     @endforeach
                  </div>
                  <blockquote>
                     <p>Every story shared with care can move help closer to the people who need it most.</p>
                     <cite>Karna Kabach</cite>
                  </blockquote>
                  <div class="blog-detail-summary">
                     <h3>Summary</h3>
                     <p>{{ $blog->short_description ?: \Illuminate\Support\Str::limit(strip_tags($blog->full_description), 240) }}</p>
                     <div class="blog-detail-summary__list">
                        <span><i class="fa-solid fa-circle-check"></i>Empower Through Charity</span>
                        <span><i class="fa-solid fa-circle-check"></i>Giving Hope, Changing Lives</span>
                        <span><i class="fa-solid fa-circle-check"></i>Compassion in Action</span>
                        <span><i class="fa-solid fa-circle-check"></i>Every Act Counts</span>
                     </div>
                  </div>
                  <div class="blog-detail-share">
                     <div class="blog-detail-tags">
                        <strong>Tags:</strong>
                        @forelse ($blog->tagList() as $tag)
                           <span>{{ $tag }}</span>
                        @empty
                           <span>{{ $blog->categoryLabel() }}</span>
                        @endforelse
                     </div>
                     <div class="blog-detail-social">
                        <strong>Share:</strong>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" aria-label="share on facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://x.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}" target="_blank" aria-label="share on twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}" target="_blank" aria-label="share on linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                     </div>
                  </div>
               </article>
            </div>
            <div class="col-12 col-xl-4">
               <aside class="blog-detail-sidebar">
                  <div class="blog-detail-widget blog-detail-author">
                     <img src="{{ asset('assets/images/avatar/avatar-user.png') }}" alt="Karna Kabach Team">
                     <h4>Karna Kabach Team</h4>
                     <p>Stories, updates, and field notes from the people helping campaigns reach more supporters.</p>
                     <div class="blog-detail-author__social">
                        <a href="https://www.facebook.com/" target="_blank" aria-label="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://x.com/" target="_blank" aria-label="twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/" target="_blank" aria-label="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                     </div>
                  </div>
                  <div class="blog-detail-widget">
                     <h4>Search Here</h4>
                     <form class="blog-detail-search" action="{{ route('home') }}" method="get">
                        <input type="search" name="search" placeholder="Search Here...">
                        <button type="submit" aria-label="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                     </form>
                  </div>
                  <div class="blog-detail-widget">
                     <h4>Recent Posts</h4>
                     @forelse ($recentBlogs as $recentBlog)
                        <a class="blog-detail-recent" href="{{ route('blogs.show', $recentBlog->slug) }}">
                           <img src="{{ $recentBlog->imageUrl() }}" alt="{{ $recentBlog->title }}">
                           <span>
                              <small><i class="fa-solid fa-calendar-days"></i>{{ $recentBlog->displayDate()->format('F d, Y') }}</small>
                              <strong>{{ \Illuminate\Support\Str::limit($recentBlog->title, 56) }}</strong>
                           </span>
                        </a>
                     @empty
                        <p class="mb-0">More posts will appear here soon.</p>
                     @endforelse
                  </div>
                  <div class="blog-detail-widget">
                     <h4>Categories</h4>
                     @foreach ($categoryCounts as $categorySlug => $category)
                        <a class="blog-detail-category {{ $blog->category === $categorySlug ? 'is-active' : '' }}" href="{{ route('blogs.index', ['category' => $categorySlug]) }}">
                           <span>{{ $category['label'] }}</span><strong>{{ str_pad($category['count'], 2, '0', STR_PAD_LEFT) }}</strong>
                        </a>
                     @endforeach
                  </div>
                  <div class="blog-detail-widget">
                     <h4>Popular Tags</h4>
                     <div class="blog-detail-popular-tags">
                        @forelse ($popularTags as $tag)
                           <span>{{ $tag }}</span>
                        @empty
                           <span>#stories</span>
                        @endforelse
                     </div>
                  </div>
               </aside>
            </div>
         </div>
      </div>
   </section>
</main>

<x-footer>
</x-footer>
