@php
   $recentFundraiserPosts = $recentFundraiserPosts ?? collect();
@endphp
<footer class="footer footer-two">
            <style>
               .footer-two {
                  overflow: hidden;
               }

               .footer-two > .container {
                  padding-top: 58px;
               }

               .footer-two .divider {
                  display: none;
               }

               .footer-two .gutter-60 {
                  --bs-gutter-x: 72px;
                  align-items: flex-start;
               }

               .footer-two .footer__brand-widget {
                  margin-top: -6px;
                  max-width: 390px;
               }

               .footer-two .footer__logo {
                  margin-bottom: 28px;
                  text-align: center;
               }

               .footer-two .footer__logo a {
                  display: inline-flex;
               }

               .footer-two .footer__logo img {
                  display: block;
                  width: min(100%, 300px);
                  height: auto;
               }

               .footer-two .footer__brand-widget .footer__widget-content p {
                  max-width: 360px;
                  margin-inline: 0;
                  font-size: 18px;
                  line-height: 1.8;
               }

               .footer-two .footer__widget-intro {
                  margin-bottom: 34px;
               }

               .footer-two .footer__widget-list li {
                  margin-bottom: 23px;
               }

               .footer-two .footer__widget-list a {
                  display: inline-flex;
                  align-items: center;
                  gap: 11px;
                  font-size: 18px;
                  line-height: 1.2;
               }

               .footer-two .footer__widget-list a i {
                  font-size: 17px;
               }

               .footer-two .footer__blog-single {
                  align-items: center;
                  gap: 18px;
                  margin-bottom: 42px;
               }

               .footer-two .footer__blog-single .thumb img {
                  width: 96px;
                  min-width: 96px;
                  height: 96px;
               }

               .footer-two .footer__blog-single h6 {
                  max-width: 260px;
                  margin-bottom: 12px;
                  font-size: 21px;
                  line-height: 1.35;
               }

               .footer-two .footer__blog-single p {
                  font-size: 16px;
               }

               .footer-two .footer__contact-list li {
                  margin-bottom: 28px;
               }

               .footer-two .footer__contact-list li a {
                  align-items: flex-start;
                  gap: 20px;
                  font-size: 18px;
                  line-height: 1.65;
               }

               .footer-two .footer__contact-list li a i {
                  width: 22px;
                  min-width: 22px;
                  margin-top: 7px;
                  text-align: center;
                  font-size: 19px;
               }

               .footer-two .footer__bottom {
                  margin-top: 86px;
               }

               .footer-two .footer__bottom .container {
                  max-width: 100%;
                  padding-inline: 0;
               }

               .footer-two .footer__bottom-inner {
                  width: min(88vw, 1508px);
                  padding: 38px max(10vw, 24px);
                  border-top-right-radius: 54px;
               }

               .footer-two .footer__bottom-inner::after {
                  display: none;
               }

               .footer-two .footer__bottom-list {
                  gap: 30px;
               }

               .footer-two .footer__bottom-list span {
                  width: 1px;
                  height: 18px;
                  background-color: var(--white);
                  margin-bottom: -3px;
               }

               .footer-two .footer__bottom-left p {
                  margin-top: 16px;
                  font-size: 17px;
               }

               .footer-two .footer__bottom-left p a {
                  font-weight: 800;
               }

               .footer-two .social {
                  gap: 12px;
               }

               .footer-two .social a {
                  width: 54px;
                  min-width: 54px;
                  height: 54px;
                  font-size: 19px;
               }

               @media (max-width: 575px) {
                  .footer-two > .container {
                     padding-top: 42px;
                  }

                  .footer-two .footer__brand-widget {
                     margin-top: 0;
                  }

                  .footer-two .footer__logo {
                     margin-bottom: 18px;
                  }

                  .footer-two .footer__logo img {
                     width: min(100%, 300px);
                  }

                  .footer-two .footer__brand-widget .footer__widget-content p,
                  .footer-two .footer__contact-list li a,
                  .footer-two .footer__widget-list a {
                     font-size: 16px;
                  }

                  .footer-two .footer__widget-list {
                     display: grid;
                     grid-template-columns: repeat(2, minmax(0, 1fr));
                     gap: 12px 18px;
                  }

                  .footer-two .footer__widget-list li {
                     margin: 0;
                  }

                  .footer-two .footer__widget-list a {
                     display: inline-flex;
                     align-items: center;
                     gap: 8px;
                     line-height: 1.25;
                  }

                  .footer-two .footer__blog-single {
                     gap: 14px;
                     margin-bottom: 28px;
                  }

                  .footer-two .footer__blog-single .thumb img {
                     width: 76px;
                     min-width: 76px;
                     height: 76px;
                  }

                  .footer-two .footer__blog-single h6 {
                     font-size: 17px;
                  }

                  .footer-two .footer__bottom {
                     margin-top: 50px;
                  }

                  .footer-two .footer__bottom-inner {
                     width: 100%;
                     padding: 30px 18px;
                     border-top-right-radius: 34px;
                  }
               }
            </style>
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <hr class="divider">
                  </div>
               </div>
               <div class="row gutter-60">
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="footer__widget footer__brand-widget" data-aos="fade-up" data-aos-duration="1200">
                        <div class="footer__logo">
                           <a href="{{ route('home') }}">
                           <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kavach">
                           </a>
                        </div>
                        <div class="footer__widget-content">
                           <p>Karna Kavach is dedicated to empowering lives through compassion, education, healthcare, and community support. Together with donors, volunteers, and partners, we strive to create opportunities, inspire hope, and build a brighter future for those in need.
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-2">
                     <div class="footer__widget" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
                        <div class="footer__widget-intro">
                           <h5>Quick Links</h5>
                           <div class="line">
                              <span class="large-line"></span>
                              <span class="small-line"></span>
                              <span class="small-line"></span>
                           </div>
                        </div>
                        <div class="footer__widget-content">
                           <ul class="footer__widget-list">
                              <li>
                                 <a href="{{ route('home') }}"><i class="fa-solid fa-angle-right"></i>Home</a>
                              </li>
                              <li>
                                 <a href="{{ route('fundraiser-posts.index', ['menu' => 'donate']) }}"><i class="fa-solid fa-angle-right"></i>Donate</a>
                              </li>
                              <li>
                                 <a href="{{ route('pricing') }}"><i class="fa-solid fa-angle-right"></i>Pricing</a>
                              </li>
                              <li>
                                 <a href="{{ route('resource') }}"><i class="fa-solid fa-angle-right"></i>Resource</a>
                              </li>
                              <li>
                                 <a href="{{ route('events.index') }}"><i class="fa-solid fa-angle-right"></i>Events</a>
                              </li>
                              <li>
                                 <a href="{{ route('blogs.index') }}"><i class="fa-solid fa-angle-right"></i>Blog</a>
                              </li>
                              <li>
                                 <a href="{{ route('contact-us') }}"><i class="fa-solid fa-angle-right"></i>Contact Us</a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-3">
                     <div class="footer__widget" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="400">
                        <div class="footer__widget-intro">
                           <h5>Top News</h5>
                           <div class="line">
                              <span class="large-line"></span>
                              <span class="small-line"></span>
                              <span class="small-line"></span>
                           </div>
                        </div>
                        <div class="footer__widget-content">
                           @forelse ($recentFundraiserPosts as $post)
                              @php
                                 $postImage = $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png');
                                 $postDate = $post->approved_at ?? $post->created_at;
                                 $postLink = route('donate-us', $post);
                              @endphp
                              <div class="footer__blog-single">
                                 <div class="thumb">
                                    <a href="{{ $postLink }}">
                                    <img src="{{ $postImage }}" alt="{{ $post->title }}" loading="lazy" decoding="async" width="88" height="78">
                                    </a>
                                 </div>
                                 <div class="content">
                                    <h6><a href="{{ $postLink }}">{{ \Illuminate\Support\Str::limit($post->title, 46) }}</a>
                                    </h6>
                                    <p>{{ $postDate?->format('M d, Y') }}</p>
                                 </div>
                              </div>
                           @empty
                              <div class="footer__blog-single">
                                 <div class="thumb">
                                    <a href="{{ route('fundraiser-posts.index') }}">
                                    <img src="{{ asset('assets/images/cause/one.png') }}" alt="Fundraiser posts" loading="lazy" decoding="async" width="88" height="78">
                                    </a>
                                 </div>
                                 <div class="content">
                                    <h6><a href="{{ route('fundraiser-posts.index') }}">Explore Fundraiser Posts</a>
                                    </h6>
                                    <p>New campaigns soon</p>
                                 </div>
                              </div>
                           @endforelse
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-3">
                     <div class="footer__widget" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="600">
                        <div class="footer__widget-intro">
                           <h5>Get In Touch</h5>
                           <div class="line">
                              <span class="large-line"></span>
                              <span class="small-line"></span>
                              <span class="small-line"></span>
                           </div>
                        </div>
                        <div class="footer__widget-content">
                           <ul class="footer__contact-list">
                              <li><a href="tel:+918584037967"><i class="fa-solid fa-phone-flip"></i>+91 85840 37967</a></li>
                              <li><a href="mailto:admin@karnakavach.org"><i class="fa-regular fa-envelope"></i>admin@karnakavach.org</a></li>
                              <li><a
                                 href="https://maps.app.goo.gl/VR5s8LHLYJkszX1Y8"
                                 target="_blank"><i class="fa-solid fa-location-dot"></i>4d 158, Station Road East, New Berrackpore<br>
North 24 Parganas, west bengal - 700131
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer__bottom">
               <div class="container">
                  <div class="row">
                     <div class="col-12">
                        <div class="footer__bottom-inner">
                           <div class="row align-items-center gutter-24">
                              <div class="col-12 col-lg-7">
                                 <div class="footer__bottom-left">
                                    <ul class="footer__bottom-list justify-content-center justify-content-lg-start">
                                       <li><a href="{{ route('coming-soon', ['menu' => 'terms-conditions']) }}">Terms & Conditions</a></li>
                                       <li><span></span></li>
                                       <li><a href="{{ route('coming-soon', ['menu' => 'privacy-policy']) }}">Privacy Policy</a></li>
                                    </ul>
                                    <p class="text-center text-lg-start">Copyright &copy; <span id="copyrightYear"></span> <a
                                       href="{{ route('home') }}">Karna Kavach Foundation</a>. All Rights Reserved.
                                    </p>
                                 </div>
                              </div>
                              <div class="col-12 col-lg-5">
                                 <div class="footer__bottom-right">
                                    <div class="social justify-content-center justify-content-lg-end">
                                       <a href="https://www.facebook.com/" target="_blank" aria-label="share us on facebook"
                                          title="facebook">
                                       <i class="fa-brands fa-facebook-f"></i>
                                       </a>
                                       <a href="https://vimeo.com/" target="_blank" aria-label="share us on vimeo" title="vimeo">
                                       <i class="fa-brands fa-vimeo-v"></i>
                                       </a>
                                       <a href="https://x.com/" target="_blank" aria-label="share us on twitter" title="twitter">
                                       <i class="fa-brands fa-twitter"></i>
                                       </a>
                                       <a href="https://www.linkedin.com/" target="_blank" aria-label="share us on linkedin"
                                          title="linkedin">
                                       <i class="fa-brands fa-linkedin-in"></i>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="sprade" data-aos="zoom-in" data-aos-duration="1000">
               <img src="{{ asset('assets/images/sprade.png') }}" alt="Image" class="base-img" loading="lazy" decoding="async">
            </div>
            <div class="sprade-light" data-aos="zoom-in" data-aos-duration="1000">
               <img src="{{ asset('assets/images/sprade-light.png') }}" alt="Image" loading="lazy" decoding="async">
            </div>
            <div class="footer__thumb-right" data-aos="fade-left" data-aos-duration="1000">
               <img src="{{ asset('assets/images/mask/footer-right.png') }}" alt="Image" loading="lazy" decoding="async">
            </div>
         </footer>
         <!-- ==== / footer end ==== -->
         <!-- ==== custom cursor start ==== -->
         <div class="mouseCursor cursor-outer"></div>
         <div class="mouseCursor cursor-inner"></div>
         <!-- ==== / custom cursor end ==== -->
         <!-- ==== scroll to top start ==== -->
         <button class="progress-wrap" aria-label="scroll indicator" title="back to top">
            <span></span>
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
               <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
         </button>
         <!-- ==== / scroll to top end ==== -->
         @include('partials.delete-confirm-modal')
         @include('partials.auto-alerts')
      </div>
      <!-- ==== js dependencies start ==== -->
      <!-- jquery -->
      <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" defer></script>
      <!-- bootstrap five js -->
      <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
      <!-- nice select js -->
      <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}" defer></script>
      <!-- magnific popup js -->
      <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}" defer></script>
      <!-- swiper slider js -->
      <script src="{{ asset('assets/js/swiper-bundle.min.js') }}" defer></script>
      <!-- viewport js -->
      <script src="{{ asset('assets/js/viewport.jquery.js') }}" defer></script>
      <!-- odometer js -->
      <script src="{{ asset('assets/js/odometer.min.js') }}" defer></script>
      <!-- vanilla tilt js -->
      <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}" defer></script>
      <!-- aos js -->
      <script src="{{ asset('assets/js/aos.js') }}" defer></script>
      <!-- phospor icons js -->
      <script src="{{ asset('assets/js/phosphor-icon.js') }}" defer></script>
      <!-- splittext js -->
      <script src="{{ asset('assets/js/SplitText.min.js') }}" defer></script>
      <!-- scrollto js -->
      <script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}" defer></script>
      <!-- scrolltrigger js -->
      <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}" defer></script>
      <!-- gsap js -->
      <script src="{{ asset('assets/js/gsap.min.js') }}" defer></script>
      <!-- ==== / js dependencies end ==== -->
      <!-- main js -->
      @stack('scripts')
      <script src="{{ asset('assets/js/custom.js') }}" defer></script>
   </body>

<!-- Mirrored from webnextpro.com/tf/charitia/{{ route('home') }} by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 May 2026 11:34:59 GMT -->
</html>
