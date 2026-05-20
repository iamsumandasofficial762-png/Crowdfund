<x-header>
</x-header>

<main>
   <section class="blog-detail-hero" style="background-image: url('{{ asset('assets/images/banner/banner-bg.jpg') }}');">
      <div class="container">
         <div class="blog-detail-hero__inner">
            <h1>{{ $selectedCategory ? ($categoryCounts[$selectedCategory]['label'] ?? 'Blogs') : 'Blogs' }}</h1>
         </div>
      </div>
      <div class="blog-detail-hero__crumb">
         <div class="container">
            <div class="blog-detail-breadcrumb">
               <a href="{{ route('home') }}">Home</a>
               <span>/</span>
               <span>Blogs</span>
            </div>
         </div>
      </div>
   </section>

   <section class="blog-list-page blog-area pt-120 pb-120">
      <div class="container">
         <div class="row gutter-40">
            <div class="col-12 col-xl-8">
               <div class="row gutter-40">
                  @forelse ($blogs as $blog)
                     @php($blogDate = $blog->displayDate())
                     <div class="col-12 col-md-6">
                        <div class="blog__single">
                           <div class="blog__single-thumb">
                              <a href="{{ route('blogs.show', $blog->slug) }}">
                                 <img src="{{ $blog->imageUrl() }}" alt="{{ $blog->title }}" loading="lazy" decoding="async" width="416" height="300">
                              </a>
                           </div>
                           <div class="blog__single-content">
                              <div class="time">
                                 <span>{{ $blogDate->format('M') }}</span>
                                 <span>{{ $blogDate->format('d') }}</span>
                              </div>
                              <div class="tag">
                                 <a href="{{ route('blogs.index', ['category' => $blog->category]) }}"><i class="fa-solid fa-tags"></i> {{ $blog->categoryLabel() }}</a>
                              </div>
                              @if ($blog->tagList())
                                 <div class="blog-card-tags">
                                    @foreach ($blog->tagList() as $tag)
                                       <span>{{ $tag }}</span>
                                    @endforeach
                                 </div>
                              @endif
                              <div class="blog__single-title">
                                 <h5><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></h5>
                              </div>
                              <p class="blog__single-excerpt">{{ \Illuminate\Support\Str::limit($blog->short_description ?: strip_tags($blog->full_description), 118) }}</p>
                              <div class="blog__single-cta">
                                 <a href="{{ route('blogs.show', $blog->slug) }}">Read More<i class="fa-solid fa-arrow-right-long"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  @empty
                     <div class="col-12">
                        <div class="blog-empty-state">
                           <h5>No published stories found</h5>
                           <p>Try another category or explore all blog posts.</p>
                        </div>
                     </div>
                  @endforelse
               </div>

               @if ($blogs->hasPages())
                  <div class="mt-5">{{ $blogs->links() }}</div>
               @endif
            </div>

            <div class="col-12 col-xl-4">
               <aside class="blog-detail-sidebar">
                  <div class="blog-detail-widget blog-category-filter">
                     <h4>Categories</h4>
                     <a class="blog-detail-category {{ $selectedCategory === null ? 'is-active' : '' }}" href="{{ route('blogs.index') }}">
                        <span>All Blogs</span><strong>{{ str_pad($allBlogCount, 2, '0', STR_PAD_LEFT) }}</strong>
                     </a>
                     @foreach ($categoryCounts as $categorySlug => $category)
                        <a class="blog-detail-category {{ $selectedCategory === $categorySlug ? 'is-active' : '' }}" href="{{ route('blogs.index', ['category' => $categorySlug]) }}">
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
