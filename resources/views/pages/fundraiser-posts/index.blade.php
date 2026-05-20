<x-header>
</x-header>

<!-- ==== banner section start ==== -->
<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="common-banner__content text-center">
               <h2 class="title-animation">Fundraiser Posts</h2>
            </div>
         </div>
      </div>
   </div>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">
            Fundraiser Posts
         </li>
      </ol>
   </nav>
   <div class="banner-bg">
      <img src="{{ asset('assets/images/banner/banner-bg.jpg') }}" alt="Image">
   </div>
   <div class="sprade" data-aos="zoom-in" data-aos-duration="1000">
      <img src="{{ asset('assets/images/sprade-base.png') }}" alt="Image" class="base-img">
   </div>
   <div class="line">
      <img src="{{ asset('assets/images/line.png') }}" alt="Image">
   </div>
</section>
<!-- ==== / banner section end ==== -->

<!-- ==== fundraiser posts section start ==== -->
<section class="cause pt-120 pb-120">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-12 col-lg-10 col-xl-5">
            <div class="section__header text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
               <span>Approved Campaigns</span>
               <h2 class="title-animation">Support Our Mission and Make a Difference</h2>
               <div class="icon-thumb justify-content-center">
                  <div class="icon-thumb-single">
                     <span></span>
                     <span></span>
                  </div>
                  <i class="icon-donation"></i>
                  <div class="icon-thumb-single">
                     <span></span>
                     <span></span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row gutter-30">
         @forelse ($posts as $post)
            @php
               $goalAmount = max((float) $post->goal_amount, 1);
               $donationRaisedAmount = (float) ($post->actual_raised_amount ?? 0);
               $raisedAmount = $donationRaisedAmount > 0 ? $donationRaisedAmount : max((float) $post->raised_amount, 0);
               $progress = min(100, (int) round(($raisedAmount / $goalAmount) * 100));
               $postImage = $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png');
               $postLink = route('donate-us', $post);
               $animationDelay = ($loop->index % 3) * 200;
            @endphp
         <div class="col-12 col-md-6 col-xl-4">
            <div class="cause__slider-inner" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $animationDelay }}">
               <div class="cause__slider-single van-tilt">
                  <div class="thumb">
                     <a href="{{ $postLink }}">
                     <img src="{{ $postImage }}" alt="{{ $post->title }}" loading="lazy" decoding="async" width="416" height="300">
                     </a>
                     <div class="tag">
                        <a href="{{ route('fundraiser-posts.index') }}">{{ $post->category }}</a>
                     </div>
                  </div>
                  <div class="content">
                     <h6><a href="{{ $postLink }}">{{ $post->title }}</a></h6>
                     <p>{{ \Illuminate\Support\Str::limit($post->short_description, 95) }}</p>
                  </div>
                  <div class="cause__slider-cta">
                     <div class="cause__progress">
                        <div class="cause-progress__intro">
                           <p><span>Donation</span>
                              <span class="percent-value">{{ $progress }}%</span>
                           </p>
                        </div>
                        <div class="cause-progress__bar">
                           <div class="post-progress-bar" aria-hidden="true">
                              <span class="post-progress-bar__fill" style="--progress-width: {{ $progress }}%"></span>
                           </div>
                        </div>
                        <div class="cause-progress__goal">
                           <p>Raised: <span class="raised">Rs. {{ number_format($raisedAmount, 0) }}</span></p>
                           <p>Goal: <span class="goal">Rs. {{ number_format($goalAmount, 0) }}</span></p>
                        </div>
                     </div>
                     <div class="cause__cta">
                        <a href="{{ $postLink }}" aria-label="donate now" title="donate now" class="btn--primary">Donate Now <i
                           class="fa-solid fa-arrow-right-long"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @empty
         <div class="col-12">
            <div class="text-center">
               <h5>No approved fundraiser posts yet.</h5>
               <p>Approved fundraiser campaigns will appear here after admin approval.</p>
               <div class="mt-30">
                  <a href="{{ route('fundraiser-details') }}" class="btn--secondary" data-text="Start a Fundraiser"><span>Start a Fundraiser</span></a>
               </div>
            </div>
         </div>
         @endforelse
      </div>

      @if ($posts->hasPages())
      <div class="row">
         <div class="col-12">
            <div class="pagination-wrapper mt-60" data-aos="fade-up" data-aos-duration="1000">
               <ul class="pagination main-pagination">
                  <li>
                     @if ($posts->onFirstPage())
                        <button type="button" disabled>
                           <i class="fa-solid fa-angles-left"></i>
                        </button>
                     @else
                        <a href="{{ $posts->previousPageUrl() }}" aria-label="Previous page">
                           <i class="fa-solid fa-angles-left"></i>
                        </a>
                     @endif
                  </li>

                  @php
                     $startPage = max(1, $posts->currentPage() - 2);
                     $endPage = min($posts->lastPage(), $posts->currentPage() + 2);
                  @endphp

                  @for ($page = $startPage; $page <= $endPage; $page++)
                     <li>
                        <a href="{{ $posts->url($page) }}" class="{{ $posts->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
                     </li>
                  @endfor

                  <li>
                     @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" aria-label="Next page">
                           <i class="fa-solid fa-angles-right"></i>
                        </a>
                     @else
                        <button type="button" disabled>
                           <i class="fa-solid fa-angles-right"></i>
                        </button>
                     @endif
                  </li>
               </ul>
            </div>
         </div>
      </div>
      @endif
   </div>
   <div class="spade">
      <img src="{{ asset('assets/images/help/spade.png') }}" alt="Image">
   </div>
</section>
<!-- ==== / fundraiser posts section end ==== -->

<x-footer>
</x-footer>
