<x-header>
</x-header>

@php
   $pendingAmount = (float) ($pendingAmount ?? 0);
@endphp

<style>
   .donation-select {
      padding: 110px 0;
      background: #f7f8fb;
   }

   .donation-select__head {
      max-width: 760px;
      margin: 0 auto 44px;
      text-align: center;
   }

   .donation-select__head span {
      color: #a83220;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0;
   }

   .donation-select__head h2 {
      margin: 10px 0 12px;
      color: #071226;
      font-weight: 900;
   }

   .donation-select__amount {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      min-height: 42px;
      margin-top: 12px;
      border: 1px solid rgba(168, 50, 32, 0.22);
      border-radius: 999px;
      padding: 8px 16px;
      color: #071226;
      background: #ffffff;
      font-weight: 900;
      box-shadow: 0 12px 28px rgba(18, 24, 39, 0.08);
   }

   .donation-select-card {
      height: 100%;
      overflow: hidden;
      border: 1px solid #dde2ea;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      background: #ffffff;
      box-shadow: 0 16px 38px rgba(18, 24, 39, 0.08);
      transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
   }

   .donation-select-card:hover {
      border-color: rgba(168, 50, 32, 0.5);
      transform: translateY(-4px);
      box-shadow: 0 24px 54px rgba(18, 24, 39, 0.14);
   }

   .donation-select-card__image {
      width: 100%;
      aspect-ratio: 16 / 10;
      object-fit: cover;
      background: #eef1f5;
   }

   .donation-select-card__body {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 22px;
   }

   .donation-select-card__tag {
      width: max-content;
      max-width: 100%;
      margin-bottom: 12px;
      border-radius: 999px;
      padding: 5px 10px;
      color: #a83220;
      background: #fff4f1;
      font-size: 12px;
      font-weight: 900;
      text-transform: uppercase;
   }

   .donation-select-card__body h3 {
      margin: 0 0 10px;
      color: #071226;
      font-size: 21px;
      line-height: 1.25;
      font-weight: 900;
   }

   .donation-select-card__body p {
      color: #647083;
      line-height: 1.6;
   }

   .donation-select-progress {
      margin: auto 0 18px;
   }

   .donation-select-progress__bar {
      height: 9px;
      overflow: hidden;
      border-radius: 999px;
      background: #edf0f5;
   }

   .donation-select-progress__bar span {
      display: block;
      width: var(--progress-width, 0%);
      height: 100%;
      border-radius: inherit;
      background: #a83220;
   }

   .donation-select-progress__meta {
      display: flex;
      justify-content: space-between;
      gap: 14px;
      margin-top: 9px;
      color: #475569;
      font-size: 13px;
      font-weight: 800;
   }

   .donation-select-card__button {
      min-height: 48px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 11px 18px;
      color: #ffffff;
      background: #a83220;
      font-weight: 900;
   }

   .donation-select-card__button:hover,
   .donation-select-card__button:focus {
      color: #ffffff;
      background: #8f2619;
   }

   .donation-select__empty {
      border: 1px dashed #d4deea;
      border-radius: 8px;
      padding: 42px 24px;
      background: #ffffff;
      text-align: center;
   }
</style>

<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="common-banner__content text-center">
               <h2 class="title-animation">Select Campaign</h2>
            </div>
         </div>
      </div>
   </div>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
         <li class="breadcrumb-item active" aria-current="page">Select Campaign</li>
      </ol>
   </nav>
   <div class="banner-bg">
      <img src="{{ asset('assets/images/banner/banner-bg.jpg') }}" alt="Image">
   </div>
</section>

<section class="donation-select">
   <div class="container">
      <div class="donation-select__head">
         <span>Choose where your donation goes</span>
         <h2 class="title-animation">Select an approved fundraiser campaign</h2>
         <p class="mb-0">Pick the campaign you want to support. Your amount will be ready in the donation form.</p>
         @if ($pendingAmount > 0)
            <div class="donation-select__amount">
               <i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i>
               {{ number_format($pendingAmount, 0) }}
            </div>
         @endif
      </div>

      <div class="row gutter-30">
         @forelse ($posts as $post)
            @php
               $goalAmount = max((float) $post->goal_amount, 1);
               $donationRaisedAmount = (float) ($post->actual_raised_amount ?? 0);
               $raisedAmount = $donationRaisedAmount > 0 ? $donationRaisedAmount : max((float) $post->raised_amount, 0);
               $progress = min(100, (int) round(($raisedAmount / $goalAmount) * 100));
               $postImage = $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png');
               $postLink = route('donate-us', ['post' => $post, 'donate' => 1]);
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
               <article class="donation-select-card">
                  <a href="{{ $postLink }}">
                     <img class="donation-select-card__image" src="{{ $postImage }}" alt="{{ $post->title }}">
                  </a>
                  <div class="donation-select-card__body">
                     <span class="donation-select-card__tag">{{ $post->category }}</span>
                     <h3><a href="{{ $postLink }}">{{ $post->title }}</a></h3>
                     <p>{{ \Illuminate\Support\Str::limit($post->short_description, 105) }}</p>
                     <div class="donation-select-progress">
                        <div class="donation-select-progress__bar" aria-hidden="true">
                           <span style="--progress-width: {{ $progress }}%"></span>
                        </div>
                        <div class="donation-select-progress__meta">
                           <span>Raised Rs. {{ number_format($raisedAmount, 0) }}</span>
                           <span>{{ $progress }}%</span>
                        </div>
                     </div>
                     <a class="donation-select-card__button" href="{{ $postLink }}">
                        Donate to this campaign <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                     </a>
                  </div>
               </article>
            </div>
         @empty
            <div class="col-12">
               <div class="donation-select__empty">
                  <h3>No approved campaigns available yet.</h3>
                  <p class="mb-0">Approved fundraiser posts will appear here after admin review.</p>
               </div>
            </div>
         @endforelse
      </div>

      @if ($posts->hasPages())
         <div class="pagination-wrapper mt-60">
            {{ $posts->links() }}
         </div>
      @endif
   </div>
</section>

<x-footer>
</x-footer>
