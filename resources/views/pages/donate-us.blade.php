<x-header>
</x-header>

@php
   $selectedPost = $post ?? null;
   $goalAmount = $selectedPost ? max((float) $selectedPost->goal_amount, 1) : 1;
   $raisedAmount = $selectedPost ? max((float) $selectedPost->raised_amount, 0) : 0;
   $progress = $selectedPost ? min(100, (int) round(($raisedAmount / $goalAmount) * 100)) : 0;
   $posterImage = $selectedPost?->main_image ? asset('storage/' . $selectedPost->main_image) : asset('assets/images/event/poster-two.png');
   $pageTitle = $selectedPost?->title ?? 'Donate Us';
   $topSupporters = $topSupporters ?? collect();
   $supporterCount = $supporterCount ?? 0;
   $topSupporterNames = $topSupporters->pluck('donor_name')->filter()->take(10)->join(', ');
@endphp

<style>
   .donate-campaign__meta {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 24px 0;
   }

   .donate-campaign__meta span {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      border-radius: 999px;
      color: #111111;
      background: #fff4df;
      font-weight: 800;
   }

   .donate-campaign__progress {
      padding: 24px;
      border-radius: 16px;
      background: #f5f5f5;
      margin: 30px 0;
   }

   .donate-campaign__numbers {
      display: flex;
      justify-content: space-between;
      gap: 16px;
      margin-top: 14px;
      font-weight: 800;
   }

   .donate-campaign__numbers span {
      color: #ff9f0a;
   }

   .donate-campaign__bar {
      height: 8px;
      border-radius: 999px;
      overflow: hidden;
      background: #ffffff;
   }

   .donate-campaign__bar span {
      display: block;
      height: 100%;
      border-radius: inherit;
      background: #000000;
   }

   .donate-campaign__empty {
      padding: 28px;
      border: 1px dashed rgba(0, 0, 0, 0.18);
      border-radius: 16px;
      background: #fffaf2;
   }

   .donate-campaign__sidebar-post {
      color: inherit;
   }

   .donate-inner > .cta {
      display: none;
   }

   .donate-layout-row {
      align-items: flex-start;
   }

   .donation-sidebar-col {
      align-self: flex-start;
   }

   .donation-sticky {
      align-self: flex-start;
      margin-top: 0;
      position: sticky;
      top: 110px;
      z-index: 5;
   }

   .donation-sticky-card {
      overflow: hidden;
      border-radius: 0;
      color: #1c1712;
      background: #ffffff;
      box-shadow: 0 22px 55px rgba(255, 179, 63, 0.16);
      border: 1px solid rgba(255, 179, 63, 0.55);
      transform: none !important;
   }

   .donation-sticky-card__body {
      padding: 28px 30px 22px;
   }

   .donation-sticky-card__head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 18px;
   }

   .donation-sticky-card__title {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 0;
      font-size: 24px;
      line-height: 1.1;
      color: #1c1712;
   }

   .donation-sticky-card__title i {
      color: #ffb33f;
   }

   .donation-sticky-card__supporters {
      color: #ffb33f;
      font-weight: 800;
      text-decoration: underline;
   }

   .donation-supporters-menu {
      position: relative;
   }

   .donation-supporters-popover {
      position: absolute;
      top: calc(100% + 12px);
      right: 0;
      width: min(260px, 72vw);
      padding: 14px;
      border: 1px solid rgba(255, 179, 63, 0.45);
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 18px 40px rgba(24, 17, 8, 0.14);
      opacity: 0;
      visibility: hidden;
      transform: translateY(8px);
      transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
      z-index: 20;
   }

   .donation-supporters-menu:hover .donation-supporters-popover,
   .donation-supporters-menu:focus-within .donation-supporters-popover {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
   }

   .donation-supporters-popover h6 {
      margin-bottom: 10px;
      font-size: 14px;
      font-weight: 900;
   }

   .donation-supporter-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 8px 0;
      border-top: 1px solid #f2e5d0;
      font-size: 13px;
      font-weight: 800;
   }

   .donation-supporter-row span {
      min-width: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }

   .donation-supporter-row strong {
      flex: 0 0 auto;
      color: #ff9f0a;
   }

   .donation-sticky-card__stats {
      display: grid;
      grid-template-columns: 74px 1fr;
      align-items: center;
      gap: 18px;
      margin-bottom: 22px;
   }

   .donation-ring {
      width: 74px;
      height: 74px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      background: conic-gradient(#ffb33f calc(var(--progress) * 1%), #f0e7d9 0);
      position: relative;
      font-weight: 800;
      color: #4a4238;
   }

   .donation-ring::before {
      content: "";
      position: absolute;
      inset: 8px;
      border-radius: inherit;
      background: #ffffff;
   }

   .donation-ring span {
      position: relative;
      z-index: 1;
   }

   .donation-sticky-card__raised p {
      margin: 0 0 4px;
      color: #d6cec2;
      font-weight: 700;
   }

   .donation-sticky-card__raised h5 {
      margin: 0;
      font-size: 18px;
      color: #cfc5b9;
      font-weight: 700;
   }

   .donation-sticky-card__raised strong {
      color: #ffb33f;
      font-size: 22px;
   }

   .donation-sticky-card__button {
      width: 100%;
      min-height: 56px;
      border: 0;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #000000;
      background: #ffb33f;
      font-size: 20px;
      font-weight: 900;
      box-shadow: 0 14px 28px rgba(255, 179, 63, 0.24);
      transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
   }

   .donation-sticky-card__button:hover {
      color: #000000;
      background: #ffc463;
      transform: translateY(-2px);
      box-shadow: 0 18px 34px rgba(255, 179, 63, 0.32);
   }

   .donation-sticky-card__method {
      margin: 12px 0 18px;
      color: #d6cec2;
      text-align: center;
      font-weight: 700;
   }

   .donation-sticky-card__divider {
      display: flex;
      align-items: center;
      gap: 14px;
      margin: 0 18px 16px;
      color: #b9afa4;
      font-weight: 700;
   }

   .donation-sticky-card__divider::before,
   .donation-sticky-card__divider::after {
      content: "";
      height: 1px;
      flex: 1;
      background: rgba(255, 179, 63, 0.28);
   }

   .donation-sticky-card__divider span {
      color: #ffb33f;
   }

   .donation-qr {
      width: 170px;
      height: 170px;
      margin: 0 auto 14px;
      border: 1px solid rgba(255, 179, 63, 0.62);
      background: #fff8ec;
      position: relative;
      display: grid;
      place-items: center;
   }

   .donation-qr canvas {
      width: 150px;
      height: 150px;
      image-rendering: pixelated;
   }

   .donation-qr__button {
      position: absolute;
      left: 50%;
      bottom: 58px;
      transform: translateX(-50%);
      width: calc(100% - 14px);
      max-width: 164px;
      height: 36px;
      box-sizing: border-box;
      padding: 0 12px;
      border: 1px solid #ffb33f;
      border-radius: 999px;
      color: #000000;
      background: #ffffff;
      font-weight: 800;
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
      transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
   }

   .donation-qr__button:hover {
      color: #000000;
      background: #ffb33f;
      transform: translateX(-50%) translateY(-1px);
   }

   .donation-qr__button.is-hidden {
      display: none;
   }

   .donation-sticky-card__apps {
      padding: 18px 20px 24px;
      border-top: 1px solid rgba(255, 179, 63, 0.28);
      text-align: center;
      background: #fffcf7;
   }

   .donation-sticky-card__apps p {
      margin-bottom: 14px;
      color: #d6cec2;
      font-weight: 700;
   }

   .donation-apps {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      flex-wrap: wrap;
   }

   .donation-apps span {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 3px solid var(--app-color);
      color: var(--app-color);
      background: #ffffff;
      font-size: 12px;
      font-weight: 900;
   }

   @media (max-width: 1199px) {
      .donation-sidebar-col {
         margin-top: 0;
      }

      .donation-sticky {
         position: static;
      }
   }
</style>

<!-- ==== banner section start ==== -->
<section class="common-banner">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <div class="common-banner__content text-center">
               <h2 class="title-animation">{{ $pageTitle }}</h2>
            </div>
         </div>
      </div>
   </div>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Home</a>
         </li>
         <li class="breadcrumb-item">
            <a href="{{ route('fundraiser-posts.index') }}">Fundraiser Posts</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">
            Donate
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

<!-- ==== donate us section start ==== -->
<div class="cm-details donate-us community checkout faq pt-120 pb-120">
   <div class="container">
      <div class="row gutter-60 donate-layout-row">
         <div class="col-12 col-xl-8">
            <div class="cm-details__content">
               <div class="cm-details__poster" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  <img src="{{ $posterImage }}" alt="{{ $pageTitle }}">
               </div>

               <div class="donate-inner" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  @if ($selectedPost)
                     <div class="cm-group">
                        <h3 class="title-animation">{{ $selectedPost->title }}</h3>
                        <p>{{ $selectedPost->short_description }}</p>
                     </div>

                     <div class="donate-campaign__meta">
                        <span><i class="fa-solid fa-hand-holding-heart"></i>{{ $selectedPost->category }}</span>
                        <span><i class="fa-solid fa-user"></i>{{ $selectedPost->beneficiary_name }}</span>
                        <span><i class="fa-solid fa-location-dot"></i>{{ $selectedPost->location }}</span>
                     </div>

                     <div class="donate-campaign__progress">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                           <h5 class="mb-0">Donation Progress</h5>
                           <strong>{{ $progress }}%</strong>
                        </div>
                        <div class="donate-campaign__bar">
                           <span style="width: {{ $progress }}%"></span>
                        </div>
                        <div class="donate-campaign__numbers">
                           <p>Raised: <span>Rs. {{ number_format($raisedAmount, 0) }}</span></p>
                           <p>Goal: <span>Rs. {{ number_format($goalAmount, 0) }}</span></p>
                        </div>
                     </div>

                     <div class="cm-group">
                        <h4>About This Fundraiser</h4>
                        <p>{!! nl2br(e($selectedPost->full_description)) !!}</p>
                     </div>
                  @else
                     <div class="donate-campaign__empty">
                        <h3 class="title-animation">Choose a fundraiser to support</h3>
                        <p>Select an approved fundraiser post to see its full details here before donating.</p>
                        <a href="{{ route('fundraiser-posts.index') }}" class="btn--secondary mt-20" data-text="Explore Fundraisers"><span>Explore Fundraisers</span></a>
                     </div>
                  @endif

                  <div class="cta">
                     <div class="community-donation">
                        <div class="community-donation__inner mt-60">
                           <h5>Support Where It Counts.</h5>
                           
                           <div class="donation-form" data-aos-delay="300">
                              <div class="donation-form__single">
                                 <h5>Your Donation:</h5>
                                 <div class="input-group-icon">
                                    <div class="thumb">
                                       <i class="fa-solid fa-indian-rupee-sign"></i>
                                    </div>
                                    <input type="text" name="donation-amount" id="donationAmount" value="1000">
                                 </div>
                                 <div class="made-amount">
                                    <span class="donation-amount">500</span>
                                    <span class="donation-amount active">1000</span>
                                    <span class="donation-amount">2500</span>
                                    <span class="donation-amount">5000</span>
                                    <span class="donation-amount custom-amount">Custom</span>
                                 </div>
                              </div>
                              <div class="donation-form__single">
                                 <h5>Select Payment Method</h5>
                                 <div class="radio-wrapper">
                                    <div class="radio-single">
                                       <input type="radio" id="testDonation" name="donation-payment" checked>
                                       <label for="testDonation">Test Donation</label>
                                    </div>
                                    <div class="radio-single">
                                       <input type="radio" id="offlineDonation" name="donation-payment">
                                       <label for="offlineDonation">Offline Donation</label>
                                    </div>
                                    <div class="radio-single">
                                       <input type="radio" id="cardDonation" name="donation-payment">
                                       <label for="cardDonation">Credit Card</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="cta">
                                 <a href="{{ route('coming-soon', ['menu' => 'donation-submit']) }}" aria-label="donate us" title="donate us"
                                    class="btn--secondary" data-text="Donate Now"><span>Donate Now</span></a>
                              </div>
                           </div>
                        </div>

                        <hr>

                        <div class="checkout__form">
                           <div class="intro">
                              <h5>Donor Information</h5>
                           </div>
                           <form action="{{ route('coming-soon', ['menu' => 'donor-information']) }}" method="get">
                              @if ($selectedPost)
                                 <input type="hidden" name="fundraiser_post" value="{{ $selectedPost->id }}">
                              @endif
                              <div class="input-group">
                                 <div class="input-single">
                                    <input type="text" name="first_name" id="firstName" placeholder="First Name" required>
                                    <i class="fa-solid fa-user"></i>
                                 </div>
                                 <div class="input-single">
                                    <input type="text" name="last_name" id="lastName" placeholder="Last Name" required>
                                    <i class="fa-solid fa-user"></i>
                                 </div>
                              </div>
                              <div class="input-group">
                                 <div class="input-single">
                                    <input type="email" name="email" id="email" placeholder="Your Email" required>
                                    <i class="fa-solid fa-envelope"></i>
                                 </div>
                                 <div class="input-single">
                                    <input type="text" name="phone" id="phone" placeholder="Your Number" required>
                                    <i class="fa-solid fa-phone"></i>
                                 </div>
                              </div>
                              <div class="input-single">
                                 <input type="text" name="address" id="address" placeholder="Your Address" required>
                                 <i class="fa-solid fa-location-dot"></i>
                              </div>
                              <div class="input-single alter-input">
                                 <textarea name="message" id="message" placeholder="your message..."></textarea>
                                 <i class="fa-solid fa-envelope"></i>
                              </div>
                              <div class="form-cta">
                                 <button type="submit" aria-label="submit message" title="submit message" class="btn--secondary"
                                    data-text="Save Information"><span>Save Information</span></button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-12 col-xl-4 donation-sidebar-col">
            <div class="cm-details__sidebar donation-sticky">
               <div class="donation-sticky-card">
                  <div class="donation-sticky-card__body">
                     <div class="donation-sticky-card__head">
                        <h5 class="donation-sticky-card__title">
                           <i class="fa-solid fa-hand-holding-heart"></i>
                           Donate
                        </h5>
                        <div class="donation-supporters-menu">
                           <a href="#"
                              class="donation-sticky-card__supporters"
                              title="{{ $topSupporterNames ? 'Top supporters: ' . $topSupporterNames : 'No supporters yet' }}">
                              {{ number_format($supporterCount) }} {{ $supporterCount === 1 ? 'supporter' : 'supporters' }}
                           </a>
                           @if ($topSupporters->isNotEmpty())
                              <div class="donation-supporters-popover">
                                 <h6>Top 10 supporters</h6>
                                 @foreach ($topSupporters as $supporter)
                                    <div class="donation-supporter-row">
                                       <span>{{ $supporter->donor_name }}</span>
                                       <strong>Rs. {{ number_format((float) $supporter->amount, 0) }}</strong>
                                    </div>
                                 @endforeach
                              </div>
                           @endif
                        </div>
                     </div>
                     <div class="donation-sticky-card__stats">
                        <div class="donation-ring" style="--progress: {{ $progress }}">
                           <span>{{ $progress }}%</span>
                        </div>
                        <div class="donation-sticky-card__raised">
                           <p>Raised</p>
                           <h5><strong>Rs. {{ number_format($raisedAmount, 0) }}</strong> of Rs. {{ number_format($goalAmount, 0) }}</h5>
                        </div>
                     </div>
                     <a href="{{ route('coming-soon', ['menu' => 'donation-submit']) }}" class="donation-sticky-card__button">Donate now</a>
                     <p class="donation-sticky-card__method">Card, Netbanking, Cheque pickups</p>
                     <div class="donation-sticky-card__divider">Or <span>Donate using</span></div>
                     <div class="donation-qr" aria-label="QR code donation placeholder">
                        <canvas id="donationQrCanvas" width="150" height="150"></canvas>
                        <button type="button" class="donation-qr__button">Generate QR</button>
                     </div>
                  </div>
                  <div class="donation-sticky-card__apps">
                     <p>Scan & donate with any app</p>
                     <div class="donation-apps">
                        <span style="--app-color: #ff8a00">UPI</span>
                        <span style="--app-color: #7582ff">GPay</span>
                        <span style="--app-color: #25c6f0">Paytm</span>
                        <span style="--app-color: #673ab7">Pe</span>
                        <span style="--app-color: #f5b94f">Pay</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- ==== / donate us section end ==== -->

<script>
   document.addEventListener('DOMContentLoaded', () => {
      const canvas = document.getElementById('donationQrCanvas');
      const button = document.querySelector('.donation-qr__button');

      if (!canvas || !button) {
         return;
      }

      const context = canvas.getContext('2d');
      const cells = 25;
      const cellSize = canvas.width / cells;

      const drawFinder = (x, y) => {
         context.fillStyle = '#050505';
         context.fillRect(x * cellSize, y * cellSize, 7 * cellSize, 7 * cellSize);
         context.fillStyle = '#fff8ec';
         context.fillRect((x + 1) * cellSize, (y + 1) * cellSize, 5 * cellSize, 5 * cellSize);
         context.fillStyle = '#050505';
         context.fillRect((x + 2) * cellSize, (y + 2) * cellSize, 3 * cellSize, 3 * cellSize);
      };

      const isFinderArea = (x, y) => {
         return (x < 8 && y < 8) || (x > 16 && y < 8) || (x < 8 && y > 16);
      };

      const generateQr = () => {
         context.fillStyle = '#fff8ec';
         context.fillRect(0, 0, canvas.width, canvas.height);
         drawFinder(1, 1);
         drawFinder(17, 1);
         drawFinder(1, 17);

         for (let y = 0; y < cells; y += 1) {
            for (let x = 0; x < cells; x += 1) {
               if (isFinderArea(x, y)) {
                  continue;
               }

               const shouldFill = Math.random() > 0.58;
               if (shouldFill) {
                  context.fillStyle = Math.random() > 0.16 ? '#050505' : '#ffb33f';
                  context.fillRect(x * cellSize, y * cellSize, cellSize, cellSize);
               }
            }
         }
      };

      button.addEventListener('click', () => {
         generateQr();
         button.classList.add('is-hidden');
      });
      generateQr();
   });
</script>

<x-footer>
</x-footer>
