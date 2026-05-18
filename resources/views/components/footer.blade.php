<footer class="footer footer-two">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <hr class="divider">
                  </div>
               </div>
               <div class="row gutter-60">
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="footer__widget" data-aos="fade-up" data-aos-duration="1200">
                        <div class="footer__logo">
                           <a href="{{ route('home') }}">
                           <img src="{{ asset('assets/images/logo.png') }}" alt="Image">
                           </a>
                        </div>
                        <div class="footer__widget-content">
                           <p>Lorem ipsum dolor amet consetetur
                              adi pisicing elit sed eiusm tempor in
                              cididunt ut labore dolore magna aliqua
                              enim ad minim venitam
                           </p>
                           <p>Quis nostrud exercita laboris nisi ut
                              aliquip commodo exercita.
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
                                 <a href="{{ route('about-us', ['menu' => 'about-us']) }}"><i class="fa-solid fa-angle-right"></i> About Us</a>
                              </li>
                              <li>
                                 <a href="{{ route('fundraiser-posts.index', ['menu' => 'donate-us']) }}"><i class="fa-solid fa-angle-right"></i>Donate</a>
                              </li>
                              <li>
                                 <a href="{{ route('pricing') }}"><i class="fa-solid fa-angle-right"></i>Pricing</a>
                              </li>
                              <li>
                                 <a href="{{ route('resource') }}"><i class="fa-solid fa-angle-right"></i>Resource</a>
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
                                    <img src="{{ $postImage }}" alt="{{ $post->title }}">
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
                                    <img src="{{ asset('assets/images/cause/one.png') }}" alt="Fundraiser posts">
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
                              <li><a
                                 href="https://maps.app.goo.gl/VR5s8LHLYJkszX1Y8"
                                 target="_blank"><i class="fa-solid fa-location-dot"></i>Shrachi EK Tower, EKT/5/Office-B,
Newtown, Kolkata, West Bengal 700161
                                 </a>
                              </li>
                              <li><a href="tel:2305-587-3407"><i class="fa-solid fa-phone-flip"></i>+2(305)
                                 587-3407</a>
                              </li>
                              <li><a href="mailto:info@example.com"><i class="fa-regular fa-envelope"></i>info@example.com</a></li>
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
                                       href="{{ route('home') }}">Karna Kabach </a>.
                                       All rights
                                       reserved.
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
               <img src="{{ asset('assets/images/sprade.png') }}" alt="Image" class="base-img">
            </div>
            <div class="sprade-light" data-aos="zoom-in" data-aos-duration="1000">
               <img src="{{ asset('assets/images/sprade-light.png') }}" alt="Image">
            </div>
            <div class="footer__thumb-right" data-aos="fade-left" data-aos-duration="1000">
               <img src="{{ asset('assets/images/mask/footer-right.png') }}" alt="Image">
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
      <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
      <!-- bootstrap five js -->
      <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
      <!-- nice select js -->
      <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
      <!-- magnific popup js -->
      <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
      <!-- swiper slider js -->
      <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
      <!-- viewport js -->
      <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
      <!-- odometer js -->
      <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
      <!-- vanilla tilt js -->
      <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
      <!-- aos js -->
      <script src="{{ asset('assets/js/aos.js') }}"></script>
      <!-- phospor icons js -->
      <script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
      <!-- splittext js -->
      <script src="{{ asset('assets/js/SplitText.min.js') }}"></script>
      <!-- scrollto js -->
      <script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}"></script>
      <!-- scrolltrigger js -->
      <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
      <!-- gsap js -->
      <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
      <!-- ==== / js dependencies end ==== -->
      <!-- main js -->
      <script src="{{ asset('assets/js/custom.js') }}"></script>
   </body>

<!-- Mirrored from webnextpro.com/tf/charitia/{{ route('home') }} by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 May 2026 11:34:59 GMT -->
</html>
