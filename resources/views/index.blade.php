<x-header>
</x-header>
         <!-- ==== / header end ==== -->
         <!-- ==== mobile menu start ==== -->
         <div class="mobile-menu d-block d-xl-none">
            <nav class="mobile-menu__wrapper">
               <div class="mobile-menu__header nav-fade">
                  <div class="logo">
                     <a href="{{ route('home') }}" aria-label="home page" title="logo">
                     <img src="{{ asset('assets/images/logo.png') }}" alt="Image">
                     </a>
                  </div>
                  <button aria-label="close mobile menu" class="close-mobile-menu">
                  <i class="fa-solid fa-xmark"></i>
                  </button>
               </div>
               <div class="mobile-menu__list"></div>
               <div class="mobile-menu__cta nav-fade d-block d-md-none">
                  <a href="donate-us.html" class="btn--secondary" data-text="Donate Now"><span>Donate
                  Now</span></a>
               </div>
               <div class="mobile-menu__social social nav-fade">
                  <a href="https://www.facebook.com/" target="_blank" aria-label="share us on facebook" title="facebook">
                  <i class="fa-brands fa-facebook-f"></i>
                  </a>
                  <a href="https://vimeo.com/" target="_blank" aria-label="share us on vimeo" title="vimeo">
                  <i class="fa-brands fa-vimeo-v"></i>
                  </a>
                  <a href="https://x.com/" target="_blank" aria-label="share us on twitter" title="twitter">
                  <i class="fa-brands fa-twitter"></i>
                  </a>
                  <a href="https://www.linkedin.com/" target="_blank" aria-label="share us on linkedin" title="linkedin">
                  <i class="fa-brands fa-linkedin-in"></i>
                  </a>
               </div>
            </nav>
         </div>
         <div class="mobile-menu__backdrop"></div>
         <!-- ==== / mobile menu end ==== -->
         <!-- ==== search popup start ==== -->
         <div class="search-popup">
            <button class="close-search" aria-label="close search box" title="close search box">
            <i class="fa-solid fa-xmark"></i>
            </button>
            <form action="#" method="post">
               <div class="search-popup__group">
                  <input type="text" name="search-field" id="searchField" placeholder="Search...." required>
                  <button type="submit" aria-label="search products" title="search products">
                  <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
               </div>
            </form>
         </div>
         <!-- ==== / search popup end ==== -->
         <!-- ==== sidebar cart start ==== -->
         <div class="sidebar-cart">
            <div class="der">
               <button class="close-cart">
               <span class="close-icon">X</span>
               </button>
               <h2>
                  Shopping Bag
                  <span class="count">2</span>
               </h2>
               <div class="cart-items">
                  <div class="cart-item-single">
                     <div class="cart-item-thumb">
                        <a href="event-details.html">
                        <img src="{{ asset('assets/images/shop/cart-one.png') }}" alt="Image">
                        </a>
                     </div>
                     <div class="cart-item-content">
                        <h6 class="h6 title-anim">
                           <a href="product-single.html">Headset</a>
                        </h6>
                        <p class="price">
                           $
                           <span class="item-price">14.99</span>
                        </p>
                        <div class="measure">
                           <button aria-label="decrease item" class="quantity-decrease">
                           <i class="fa-solid fa-minus"></i>
                           </button>
                           <span class="item-quantity">0</span>
                           <button aria-label="add item" class="quantity-increase">
                           <i class="fa-solid fa-plus"></i>
                           </button>
                        </div>
                     </div>
                     <button aria-label="delete item" class="delete-item">
                     <i class="fa-solid fa-trash"></i>
                     </button>
                  </div>
                  <div class="cart-item-single">
                     <div class="cart-item-thumb">
                        <a href="event-details.html">
                        <img src="{{ asset('assets/images/shop/cart-two.png') }}" alt="Image">
                        </a>
                     </div>
                     <div class="cart-item-content">
                        <h6 class="h6 title-anim">
                           <a href="product-single.html">Headphone</a>
                        </h6>
                        <p class="price">
                           $
                           <span class="item-price">34.99</span>
                        </p>
                        <div class="measure">
                           <button aria-label="decrease item" class="quantity-decrease">
                           <i class="fa-solid fa-minus"></i>
                           </button>
                           <span class="item-quantity">0</span>
                           <button aria-label="add item" class="quantity-increase">
                           <i class="fa-solid fa-plus"></i>
                           </button>
                        </div>
                     </div>
                     <button aria-label="delete item" class="delete-item">
                     <i class="fa-solid fa-trash"></i>
                     </button>
                  </div>
               </div>
               <div class="totals">
                  <div class="subtotal">
                     <span class="label">Subtotal:</span>
                     <span class="amount ">
                     $
                     <span class="total-price">0.00</span>
                     </span>
                  </div>
               </div>
               <div class="action-buttons">
                  <a class="view-cart-button" href="cart.html" aria-label="go to cart">Cart</a>
                  <a class="checkout-button" href="checkout.html" aria-label="go to checkout">
                  Checkout
                  <i class="fa-solid fa-arrow-right-long"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="cart-backdrop"></div>
         <!-- ==== / sidebar cart end ==== -->
         <!-- ==== it will go in header component ==== -->
         <!-- ==== banner section start ==== -->
         <section class="banner-two">
            <div class="banner-two__slider swiper">
               <div class="swiper-wrapper">
                  <div class="swiper-slide">
                     <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg" data-background="{{ asset('assets/images/banner/banner-two-bg.jpg') }}">
                        </div>
                        <div class="container">
                           <div class="row">
                              <div class="col-12 col-md-9 col-lg-7 col-xxl-7">
                                 <div class="banner-two__slider-content">
                                    <span class="sub-title">Start donating poor
                                    people</span>
                                    <h1>Giving help <br>
                                       To Those <span class="bottom-line">peoples</span>
                                       Who Need It.
                                    </h1>
                                    <div class="banner__content-cta mt-40">
                                       <a href="our-causes.html" aria-label="about us" title="about us" class="btn--primary">Start a fundraiser</a>
                                       <!-- <a href="contact-us.html" aria-label="contact us" title="contact us" data-text="Get A Quote"
                                          class="btn--secondary"><span>Get A Quote</span></a> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="swiper-slide">
                     <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg" data-background="{{ asset('assets/images/banner/banner-one-bg.jpg') }}">
                        </div>
                        <div class="container">
                           <div class="row">
                              <div class="col-12 col-md-9  col-lg-7 col-xxl-7">
                                 <div class="banner-two__slider-content">
                                    <span class="sub-title">Start donating poor
                                    people</span>
                                    <h1>Giving help <br>
                                       To Those <span class="bottom-line">peoples</span>
                                       Who Need It.
                                    </h1>
                                    <div class="banner__content-cta mt-40">
                                       <a href="our-causes.html" aria-label="about us" title="about us" class="btn--primary">Start a fundraiser</a>
                                       <!-- <a href="contact-us.html" aria-label="contact us" title="contact us" data-text="Get A Quote"
                                          class="btn--secondary"><span>Get A Quote</span></a> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="swiper-slide">
                     <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg" data-background="{{ asset('assets/images/banner/banner-three-bg.jpg') }}">
                        </div>
                        <div class="container">
                           <div class="row">
                              <div class="col-12 col-md-9 col-lg-7 col-xxl-7">
                                 <div class="banner-two__slider-content">
                                    <span class="sub-title">Start donating poor
                                    people</span>
                                    <h1>Giving help <br>
                                       To Those <span class="bottom-line">peoples</span>
                                       Who Need It.
                                    </h1>
                                    <div class="banner__content-cta mt-40">
                                       <a href="our-causes.html" aria-label="about us" title="about us" class="btn--primary">Start a fundraiser</a>
                                       <!-- <a href="contact-us.html" aria-label="contact us" title="contact us" data-text="Get A Quote"
                                          class="btn--secondary"><span>Get A Quote</span></a> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="swiper-slide">
                     <div class="banner-two__slider-single">
                        <div class="banner-two__slider-bg" data-background="{{ asset('assets/images/banner/banner-four-bg.jpg') }}">
                        </div>
                        <div class="container">
                           <div class="row">
                              <div class="col-12 col-md-9 col-lg-7 col-xxl-7">
                                 <div class="banner-two__slider-content">
                                    <span class="sub-title">Start donating poor
                                    people</span>
                                    <h1>Giving help <br>
                                       To Those <span class="bottom-line">peoples</span>
                                       Who Need It.
                                    </h1>
                                    <div class="banner__content-cta mt-40">
                                       <a href="our-causes.html" aria-label="about us" title="about us" class="btn--primary">Start a fundraiser</a>
                                       <!-- <a href="contact-us.html" aria-label="contact us" title="contact us" data-text="Get A Quote"
                                          class="btn--secondary"><span>Get A Quote</span></a> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="slider-navigation d-none d-md-flex">
               <button type="button" aria-label="prev slide" title="prev slide" class="prev-banner slider-btn">
               <i class="fa-solid fa-arrow-left"></i>
               </button>
               <button type="button" aria-label="next slide" title="next slide" class="next-banner slider-btn slider-btn-next">
               <i class="fa-solid fa-arrow-right"></i>
               </button>
            </div>
            <div class="shape-left" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="300">
               <img src="{{ asset('assets/images/banner/banner-two-shape.png') }}" alt="Image" class="base-img">
            </div>
            <div class="sprade-shape">
               <img src="{{ asset('assets/images/sprade-base.png') }}" alt="Image" class="base-img" data-aos="zoom-in"
                  data-aos-duration="1000">
            </div>
            <div class="unity">
               <img src="{{ asset('assets/images/unity.png') }}" alt="Image">
            </div>
         </section>
         <!-- ==== / banner section end ==== -->
         <!-- ==== partner section start ==== -->
         <div class="partner partner-alt">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="partner__inner">
                        <div class="partner__slider swiper">
                           <div class="swiper-wrapper">
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/one.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/two.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/three.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/four.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/five.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/one.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/two.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/three.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/four.png') }}" alt="Image">
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="partner__slider-single">
                                    <img src="{{ asset('assets/images/sponsor/five.png') }}" alt="Image">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- ==== / partner section end ==== -->
         <!-- ==== about section start ==== -->
         <section class="about-area about-area-alt pt-120 pb-120">
            <div class="container">
               <div class="row align-items-center gutter-40">
                  <div class="col-12 col-lg-5 col-xl-6">
                     <div class="about__thumb">
                        <div class="about__thumb-big">
                           <img src="{{ asset('assets/images/difference/thumb-lg-two.jpg') }}" alt="Image" data-aos="fade-right"
                              data-aos-duration="1000">
                           <div class="video-btn-wrapper">
                              <a href="https://www.youtube.com/watch?v=RvreULjnzFo" target="_blank" title="video Player"
                                 class="open-video-popup">
                              <i class="fa-solid fa-play"></i>
                              </a>
                           </div>
                        </div>
                        <div class="about__thumb-sm">
                           <img src="{{ asset('assets/images/difference/thumb-sm-two.jpg') }}" alt="Image" data-aos="fade-left"
                              data-aos-duration="1000" data-aos-delay="100">
                           <div class="about__thumb-sm__content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                              <div class="about__thumb-sm__content-counter">
                                 <h2><span class="odometer" data-odometer-final="15"></span><span>+</span></h2>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                       d="M22.6317 12.3421L20.9825 7L19.3684 12.3053H14L18.3509 15.621L16.6667 21L21.0175 17.6842L25.3684 21L23.6491 15.6579L28 12.3421H22.6317Z"
                                       fill="#FFB33F" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                       d="M7.82123 0H34.1788V2.60708H42V11.8752C42 14.3333 41.0235 16.6907 39.2855 18.4288C37.8683 19.8459 36.0395 20.7567 34.0802 21.0448C33.7921 23.0042 32.8814 24.8329 31.4641 26.25C29.7598 27.9543 27.4601 28.9264 25.0541 28.9636V32.7318C25.0541 33.0396 25.1762 33.3347 25.3938 33.5521C25.6115 33.7698 25.9066 33.892 26.2141 33.892C27.6351 33.892 28.9977 34.4564 30.0024 35.4611C31.0072 36.4658 31.5718 37.8287 31.5718 39.2494V42H10.4283V39.2494C10.4283 37.8287 10.9928 36.4658 11.9975 35.4611C13.0022 34.4564 14.3649 33.892 15.7859 33.892C16.0935 33.892 16.3886 33.7698 16.6062 33.5521C16.8238 33.3347 16.946 33.0396 16.946 32.7318V28.9636C14.5398 28.9264 12.2401 27.9543 10.5358 26.25C9.11868 24.8329 8.20789 23.0042 7.9198 21.0448C5.96043 20.7567 4.13168 19.8459 2.71458 18.4288C0.976454 16.6907 0 14.3333 0 11.8752V2.60708H7.82123V0ZM10.7151 2.89384V19.6965C10.7151 21.387 11.3867 23.0083 12.5821 24.2038C13.7775 25.3993 15.3988 26.0708 17.0894 26.0708H19.8398V32.7318C19.8398 33.8069 19.4127 34.8381 18.6525 35.5985C17.8922 36.3587 16.861 36.7859 15.7859 36.7859C15.1325 36.7859 14.5058 37.0453 14.0438 37.5075C13.6156 37.9356 13.3614 38.505 13.3263 39.1062H28.6737C28.6388 38.505 28.3843 37.9356 27.9562 37.5075C27.4942 37.0453 26.8675 36.7859 26.2141 36.7859C25.139 36.7859 24.1078 36.3587 23.3476 35.5985C22.5872 34.8381 22.1602 33.8069 22.1602 32.7318V26.0708H24.9106C26.6011 26.0708 28.2225 25.3993 29.4179 24.2038C30.6134 23.0083 31.285 21.387 31.285 19.6965V2.89384H10.7151ZM7.82123 5.50093H2.89384V11.8752C2.89384 13.5658 3.56543 15.1871 4.76083 16.3826C5.60901 17.2307 6.67161 17.8152 7.82123 18.0832V5.50093ZM34.1788 18.0832V5.50093H39.1062V11.8752C39.1062 13.5658 38.4346 15.1871 37.2391 16.3826C36.391 17.2307 35.3283 17.8152 34.1788 18.0832Z"
                                       fill="#000000" />
                                 </svg>
                              </div>
                              <p>Years Experience</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-7 col-xl-6">
                     <div class="about__content">
                        <div class="section__header">
                           <span>Supporting Our Cause Together</span>
                           <h2 class="title-animation">Support Our Mission and Make a Difference</h2>
                           <p>Business tailored it design, management & support services business agency elit, sed
                              do eiusmod tempor.
                           </p>
                        </div>
                        <hr class="divider">
                        <div class="about__content-inner" data-aos="fade-up" data-aos-duration="1000">
                           <div class="help__content-list">
                              <ul>
                                 <li><i class="fa-regular fa-circle-check"></i> Giving Hope, Changing Lives</li>
                                 <li><i class="fa-regular fa-circle-check"></i> Empower Through Charity
                                 </li>
                                 <li><i class="fa-regular fa-circle-check"></i> Together We Can</li>
                                 <li><i class="fa-regular fa-circle-check"></i> Healing Communities</li>
                                 <li><i class="fa-regular fa-circle-check"></i> Every Act Counts</li>
                                 <li><i class="fa-regular fa-circle-check"></i> Compassion in Action</li>
                              </ul>
                           </div>
                           <div class="about__content-review" data-aos="fade-up" data-aos-duration="1000">
                              <div class="about__content-review__counter">
                                 <h3><span class="odometer" data-odometer-final="999"></span><span>+</span></h3>
                                 <p>Active Reviews</p>
                              </div>
                              <div class="join-users">
                                 <div class="single-user">
                                    <img src="{{ asset('assets/images/avatar/avatar-one.png') }}" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="{{ asset('assets/images/avatar/avatar-two.png') }}" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="{{ asset('assets/images/avatar/avatar-three.png') }}" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="{{ asset('assets/images/avatar/avatar-four.png') }}" alt="Image">
                                 </div>
                              </div>
                           </div>
                           <div class="about__content-inner__cta mt-40" data-aos="fade-up" data-aos-duration="1000">
                              <div class="about__content-inner__btn">
                                 <a href="{{ route('about-us') }}" class="btn--secondary" data-text="More About Us"><span>More About
                                 Us</span></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / about section end ==== -->
         <!-- ==== cause slider section start ==== -->
         <section class="cause pt-120 pb-120">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-xl-5">
                     <div class="section__header text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
                        <span>Supporting Our Cause Together</span>
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
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="cause__slider-inner" data-aos="fade-up" data-aos-duration="1000">
                        <div class="cause__slider-single van-tilt">
                           <div class="thumb">
                              <a href="cause-details.html">
                              <img src="{{ asset('assets/images/cause/one.png') }}" alt="Image">
                              </a>
                              <div class="tag">
                                 <a href="our-causes.html">Health</a>
                              </div>
                           </div>
                           <div class="content">
                              <h6><a href="cause-details.html">Children we work with</a></h6>
                              <p>Lorem ipsum dolor sit amet, consete
                                 sadipscing elitr, sed diam nonum
                              </p>
                           </div>
                           <div class="cause__slider-cta">
                              <div class="cause__progress progress-bar-single">
                                 <div class="cause-progress__intro">
                                    <p><span>Donation</span>
                                       <span class="percent-value">85%</span>
                                    </p>
                                 </div>
                                 <div class="cause-progress__bar">
                                    <div class="progress-bar-wrapper" data-percent="85%">
                                       <div class="progress-bar">
                                          <div class="progress-bar-percent">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cause-progress__goal">
                                    <p>Raised: <span class="raised">$8500</span></p>
                                    <p>Goal: <span class="goal">$1,0000</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="cause__cta">
                              <a href="donate-us.html" aria-label="donate now" title="donate now" class="btn--primary">Donate Now <i
                                 class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="cause__slider-inner" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="cause__slider-single van-tilt">
                           <div class="thumb">
                              <a href="cause-details.html">
                              <img src="{{ asset('assets/images/cause/two.png') }}" alt="Image">
                              </a>
                              <div class="tag">
                                 <a href="our-causes.html">Food</a>
                              </div>
                           </div>
                           <div class="content">
                              <h6><a href="cause-details.html">Help For Education</a></h6>
                              <p>Lorem ipsum dolor sit amet, consete
                                 sadipscing elitr, sed diam nonum
                              </p>
                           </div>
                           <div class="cause__slider-cta">
                              <div class="cause__progress progress-bar-single">
                                 <div class="cause-progress__intro">
                                    <p><span>Donation</span>
                                       <span class="percent-value">90%</span>
                                    </p>
                                 </div>
                                 <div class="cause-progress__bar">
                                    <div class="progress-bar-wrapper" data-percent="90%">
                                       <div class="progress-bar">
                                          <div class="progress-bar-percent">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cause-progress__goal">
                                    <p>Raised: <span class="raised">$8500</span></p>
                                    <p>Goal: <span class="goal">$1,0000</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="cause__cta">
                              <a href="donate-us.html" aria-label="donate now" title="donate now" class="btn--primary">Donate Now <i
                                 class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="cause__slider-inner" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <div class="cause__slider-single van-tilt">
                           <div class="thumb">
                              <a href="cause-details.html">
                              <img src="{{ asset('assets/images/cause/three.png') }}" alt="Image">
                              </a>
                              <div class="tag">
                                 <a href="our-causes.html">Health</a>
                              </div>
                           </div>
                           <div class="content">
                              <h6><a href="cause-details.html">Help For Food</a></h6>
                              <p>Lorem ipsum dolor sit amet, consete
                                 sadipscing elitr, sed diam nonum
                              </p>
                           </div>
                           <div class="cause__slider-cta">
                              <div class="cause__progress progress-bar-single">
                                 <div class="cause-progress__intro">
                                    <p><span>Donation</span>
                                       <span class="percent-value">75%</span>
                                    </p>
                                 </div>
                                 <div class="cause-progress__bar">
                                    <div class="progress-bar-wrapper" data-percent="75%">
                                       <div class="progress-bar">
                                          <div class="progress-bar-percent">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cause-progress__goal">
                                    <p>Raised: <span class="raised">$8500</span></p>
                                    <p>Goal: <span class="goal">$1,0000</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="cause__cta">
                              <a href="donate-us.html" aria-label="donate now" title="donate now" class="btn--primary">Donate Now <i
                                 class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-6">
                     <div class="mt-60 text-center">
                        <a href="our-causes.html" data-text="Explore All" class="btn--secondary"><span>Explore All</span></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="spade">
               <img src="{{ asset('assets/images/help/spade.png') }}" alt="Image">
            </div>
         </section>
         <!-- ==== / cause slider section end ==== -->
         <!-- ==== testimonial section start ==== -->
         <section class="testimonial-area pt-120 pb-120">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-xl-5">
                     <div class="section__header text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
                        <span>Supporting Our Cause Together</span>
                        <h2 class="title-animation">Our valueable client's Awesome Feedback</h2>
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
               <div class="row justify-content-center">
                  <div class="col-12 col-xl-12">
                     <div class="testimonial__inner">
                        <div class="testimonial__inner-wrapper">
                           <div class="testimonial__slider swiper">
                              <div class="swiper-wrapper">
                                 <div class="swiper-slide">
                                    <div class="testimonial__slider-single">
                                       <div class="row align-items-center gutter-40">
                                          <div class="col-12 col-lg-4 col-xl-4">
                                             <div class="testimonial__slider-thumb">
                                                <img src="{{ asset('assets/images/testimonial/one.png') }}" alt="Image">
                                             </div>
                                          </div>
                                          <div class="col-12 col-lg-8 col-xl-7">
                                             <div class="testimonial__slider-content">
                                                <div class="review">
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>lorem ipsum dolor sit amet consectetur. ut tellus
                                                   suspendisse
                                                   nulla aliquam. risus rutrum tellus eget ultrices pretium
                                                   nisi amet facilisis.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>Marketing Manager</span>
                                                      <h4>Raven Steel</h4>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="testimonial__slider-single">
                                       <div class="row align-items-center gutter-40">
                                          <div class="col-12 col-lg-4 col-xl-4">
                                             <div class="testimonial__slider-thumb">
                                                <img src="{{ asset('assets/images/testimonial/two.png') }}" alt="Image">
                                             </div>
                                          </div>
                                          <div class="col-12 col-lg-8 col-xl-7">
                                             <div class="testimonial__slider-content">
                                                <div class="review">
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>lorem ipsum dolor sit amet consectetur. ut tellus
                                                   suspendisse
                                                   nulla aliquam. risus rutrum tellus eget ultrices pretium
                                                   nisi amet facilisis.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>Marketing Manager</span>
                                                      <h4>Robina smith</h4>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="testimonial__slider-single">
                                       <div class="row align-items-center gutter-40">
                                          <div class="col-12 col-lg-4 col-xl-4">
                                             <div class="testimonial__slider-thumb">
                                                <img src="{{ asset('assets/images/testimonial/three.png') }}" alt="Image">
                                             </div>
                                          </div>
                                          <div class="col-12 col-lg-8 col-xl-7">
                                             <div class="testimonial__slider-content">
                                                <div class="review">
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                   <i class="fa-solid fa-star"></i>
                                                </div>
                                                <p>lorem ipsum dolor sit amet consectetur. ut tellus
                                                   suspendisse
                                                   nulla aliquam. risus rutrum tellus eget ultrices pretium
                                                   nisi amet facilisis.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>Marketing Manager</span>
                                                      <h4>Robet Michel</h4>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="slider-navigation">
                           <button type="button" aria-label="prev slide" title="prev slide" class="prev-testimonial slider-btn">
                           <i class="fa-solid fa-angle-left"></i>
                           </button>
                           <button type="button" aria-label="next slide" title="next slide"
                              class="next-testimonial slider-btn slider-btn-next">
                           <i class="fa-solid fa-angle-right"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / testimonial section end ==== -->
         <!-- ==== difference two section start ==== -->
         <section class="difference-two pt-120 pb-120">
            <div class="container">
               <div class="row gutter-40 align-items-center">
                  <div class="col-12 col-lg-4 col-xxl-5 d-none d-lg-block">
                     <div class="difference-two__thumb-wrapper">
                        <div class="difference-two__thumb">
                           <div class="thumb-lg" data-aos="fade-right" data-aos-duration="1000">
                              <img src="{{ asset('assets/images/difference/thumb-sm.png') }}" alt="Image">
                              <div class="grid-line">
                                 <img src="{{ asset('assets/images/help/grid.png') }}" alt="Image" class="base-img">
                              </div>
                              <div class="video-btn-wrapper">
                                 <a href="https://www.youtube.com/watch?v=RvreULjnzFo" target="_blank" title="video Player"
                                    class="open-video-popup">
                                 <i class="icon-play"></i>
                                 </a>
                              </div>
                           </div>
                           <div class="thumb-sm" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                              <img src="{{ asset('assets/images/difference/thumb-lg.png') }}" alt="Image">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-8 col-xxl-7">
                     <div class="difference-two__content">
                        <div class="section__header mb-20" data-aos="fade-up" data-aos-duration="1000">
                           <span class="sub-title">Start Donating Poor People</span>
                           <h2 class="title-animation">Donate Support to Make
                              Difference way
                           </h2>
                        </div>
                        <p>Charity is the voluntary act of giving help,
                           typically in the form of money, time, or resources, to those in need. Charitable
                           organizations aim to solve social, environmental, and economic challenges by addressing
                           issues like poverty,
                        </p>
                        <div class="difference-two__inner cta mt-40">
                           <div class="difference-two__inner-content">
                              <div class="difference-two__tab">
                                 <div class="difference-two__tab-btns">
                                    <button class="difference-two__tab-btn active" data-target="#mission" aria-label="mission"
                                       title="mission">Our Mission</button>
                                    <button class="difference-two__tab-btn" data-target="#vision" aria-label="vision"
                                       title="vision">Our Vision</button>
                                    <button class="difference-two__tab-btn" data-target="#excellence" aria-label="excellence"
                                       title="excellence">Excellence</button>
                                 </div>
                                 <div class="difference-two__tab-content">
                                    <div class="difference-two__content-single" id="mission">
                                       <ul>
                                          <li><i class="fa-solid fa-check"></i>We help companies develop
                                             powerful corporate social
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Helped fund 3,265 Project
                                             powerful corporate poor
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Dedicated Tech Services</li>
                                       </ul>
                                    </div>
                                    <div class="difference-two__content-single" id="vision">
                                       <ul>
                                          <li><i class="fa-solid fa-check"></i>We help companies develop
                                             powerful corporate social
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Helped fund 3,265 Project
                                             powerful corporate poor
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Dedicated Tech Services</li>
                                       </ul>
                                    </div>
                                    <div class="difference-two__content-single" id="excellence">
                                       <ul>
                                          <li><i class="fa-solid fa-check"></i>We help companies develop
                                             powerful corporate social
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Helped fund 3,265 Project
                                             powerful corporate poor
                                          </li>
                                          <li><i class="fa-solid fa-check"></i>Dedicated Tech Services</li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="difference-two__progress">
                                 <div class="difference-progress-single">
                                    <div class="progress-bar-single" data-percent="75%">
                                       <div class="circular-progress">
                                          <div class="percent-value">0%</div>
                                          <svg class="progress-circle" viewBox="0 0 36 36">
                                             <path class="circle-bg" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                             <path class="circle-progress" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                          </svg>
                                       </div>
                                    </div>
                                    <div class="content">
                                       <p>Treatment <br>
                                          Helping
                                       </p>
                                    </div>
                                 </div>
                                 <div class="difference-progress-single">
                                    <div class="progress-bar-single" data-percent="92%">
                                       <div class="circular-progress">
                                          <div class="percent-value">0%</div>
                                          <svg class="progress-circle" viewBox="0 0 36 36">
                                             <path class="circle-bg" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                             <path class="circle-progress" d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                          </svg>
                                       </div>
                                    </div>
                                    <div class="content">
                                       <p>Highest <br>
                                          Fund Raised
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="difference-two__card">
                              <div class="card-group">
                                 <div class="thumb">
                                    <i class="icon-donation-card"></i>
                                 </div>
                                 <div class="content">
                                    <h6>Donate Now</h6>
                                    <p>$40,456</p>
                                 </div>
                              </div>
                              <hr>
                              <div class="card-group card-group-alt">
                                 <div class="thumb">
                                    <i class="icon-fund"></i>
                                 </div>
                                 <div class="content">
                                    <h6>Total Fundraised</h6>
                                    <p>$1,540,456</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="spade">
               <img src="{{ asset('assets/images/spade-green-two.png') }}" alt="Image">
            </div>
         </section>
         <!-- ==== / difference two section end ==== -->
         <!-- ==== community section start ==== -->
         <section class="community pt-120">
            <div class="container">
               <div class="row">
                  <div class="col-12 col-md-8 col-xl-7">
                     <div class="section__header mb-55" data-aos="fade-up" data-aos-duration="1000">
                        <span class="sub-title">Start donating poor
                        people</span>
                        <h2 class="title-animation">Join The Community To Give
                           Education For Children
                        </h2>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="community-donation" data-aos="fade-up" data-aos-duration="1000">
                        <div class="community-donation__inner">
                           <h4>Support Where It Counts.</h4>
                           <div class="warning">
                              <div class="line"><i class="fa-solid fa-triangle-exclamation"></i></div>
                              <p><strong>Notice:</strong> Test mode is enabled. While in test mode no live
                                 donations are processed.
                              </p>
                           </div>
                           <div class="donation-form">
                              <div class="donation-form__single">
                                 <h5>Your Donation:</h5>
                                 <div class="input-group-icon">
                                    <div class="thumb">
                                       <i class="fa-solid fa-dollar-sign"></i>
                                    </div>
                                    <input type="text" name="donation-amount" id="donationAmount">
                                 </div>
                                 <div class="made-amount">
                                    <span class="donation-amount">20</span>
                                    <span class="donation-amount">50</span>
                                    <span class="donation-amount active">100</span>
                                    <span class="donation-amount">200</span>
                                    <span class="donation-amount custom-amount">Custom</span>
                                 </div>
                              </div>
                              <div class="donation-form__single">
                                 <h5>Select Payment Method</h5>
                                 <div class="radio-wrapper mt-30">
                                    <div class="radio-single">
                                       <input type="radio" id="testDonation" name="donation-payment" checked>
                                       <label for="testDonation">Test Donation</label>
                                    </div>
                                    <div class="radio-single">
                                       <input type="radio" id="offlineDonation" name="donation-payment" checked>
                                       <label for="offlineDonation">Offline Donation</label>
                                    </div>
                                    <div class="radio-single">
                                       <input type="radio" id="cardDonation" name="donation-payment" checked>
                                       <label for="cardDonation">Credit Card</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="mt-40">
                                 <a href="donate-us.html" aria-label="donate us" title="donate us" data-text="Donate Now"
                                    class="btn--secondary"><span>Donate Now</span></a>
                              </div>
                           </div>
                        </div>
                        <div class="community__thumb d-none d-lg-block" data-aos="fade-left" data-aos-duration="1000">
                           <img src="{{ asset('assets/images/community/thumb.png') }}" alt="Image">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="community-bg">
               <img src="{{ asset('assets/images/banner/banner-one-bg.jpg') }}" alt="Image" class="parallax-image">
            </div>
            <div class="gift" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
               <img src="{{ asset('assets/images/community/gift.png') }}" alt="Image">
            </div>
            <div class="spade">
               <img src="{{ asset('assets/images/community/spade.png') }}" alt="Image" class="base-img">
            </div>
         </section>
         <!-- ==== / community section end ==== -->
         <!-- ==== event section start ==== -->
         <section class="explore-area pt-120 pb-120 explore-alt">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-xl-5">
                     <div class="section__header text-center mb-55" data-aos="fade-up" data-aos-duration="1000">
                        <span>Join Us for Exciting Experiences</span>
                        <h2 class="title-animation">Upcoming Events and Activities</h2>
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
               <div class="row">
                  <div class="col-12">
                     <div class="explore__wrapper">
                        <div class="explore__single" data-aos="fade-up" data-aos-duration="1000">
                           <div class="thumb">
                              <a href="event-details.html">
                              <img src="{{ asset('assets/images/award/one.png') }}" alt="Image">
                              </a>
                           </div>
                           <a href="event-details.html" class="arr">
                           <i class="fa-solid fa-arrow-up"></i>
                           </a>
                           <div class="content">
                              <p>Food & Transport</p>
                              <h5><a href="event-details.html">Child Trouble & Care</a></h5>
                           </div>
                        </div>
                        <div class="explore__single" data-aos="fade-up" data-aos-duration="1000">
                           <div class="thumb">
                              <a href="event-details.html">
                              <img src="{{ asset('assets/images/award/two.png') }}" alt="Image">
                              </a>
                           </div>
                           <a href="event-details.html" class="arr">
                           <i class="fa-solid fa-arrow-up"></i>
                           </a>
                           <div class="content">
                              <p>Health & Food</p>
                              <h5><a href="event-details.html">Health Care Program</a></h5>
                           </div>
                        </div>
                        <div class="explore__single explore__single-tall" data-aos="fade-up" data-aos-duration="1000">
                           <div class="thumb">
                              <a href="event-details.html">
                              <img src="{{ asset('assets/images/award/three.jpg') }}" alt="Image">
                              </a>
                           </div>
                           <a href="event-details.html" class="arr">
                           <i class="fa-solid fa-arrow-up"></i>
                           </a>
                           <div class="content">
                              <p>Education & Food</p>
                              <h5><a href="event-details.html">Education & Safety Program</a></h5>
                           </div>
                        </div>
                        <div class="explore__single explore__single-wide" data-aos="fade-up" data-aos-duration="1000">
                           <div class="thumb">
                              <a href="event-details.html">
                              <img src="{{ asset('assets/images/award/four.jpg') }}" alt="Image">
                              </a>
                           </div>
                           <a href="event-details.html" class="arr">
                           <i class="fa-solid fa-arrow-up"></i>
                           </a>
                           <div class="content">
                              <p>Transport & Food</p>
                              <h5><a href="event-details.html">Transport & Food Program </a></h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row align-items-center gutter-24">
                  <div class="col-12 col-lg-8">
                     <div class="section__header--secondary">
                        <h3 class="title-animation">400+ Winning Awards</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, cumque.</p>
                     </div>
                  </div>
                  <div class="col-12 col-lg-4">
                     <div class="text-start text-lg-end">
                        <a href="events.html" class="btn--secondary" data-text="Explore All"><span>Explore All</span></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="spade">
               <img src="{{ asset('assets/images/sprade-base.png') }}" alt="Image" class="base-img">
            </div>
         </section>
         <!-- ==== / event section end ==== -->
         <!-- ==== counter section start ==== -->
         <section class="counter-area count-alt">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="counter__inner">
                        <div class="row gutter-40">
                           <div class="col-12 col-sm-6 col-lg-3">
                              <div class="counter__single">
                                 <div class="counter__single-icon">
                                    <div class="counter__single-icon__inner">
                                       <i class="icon-support-hand"></i>
                                    </div>
                                 </div>
                                 <div class="service__counter-single-content">
                                    <h3><span class="odometer" data-odometer-final="300"></span><span class="prefix">+</span></h3>
                                    <p>Team Members</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-lg-3">
                              <div class="counter__single">
                                 <div class="counter__single-icon">
                                    <div class="counter__single-icon__inner">
                                       <i class="icon-review"></i>
                                    </div>
                                 </div>
                                 <div class="service__counter-single-content">
                                    <h3><span class="odometer" data-odometer-final="500"></span><span class="prefix">+</span></h3>
                                    <p>Client's Review</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-lg-3">
                              <div class="counter__single">
                                 <div class="counter__single-icon">
                                    <div class="counter__single-icon__inner">
                                       <i class="icon-award"></i>
                                    </div>
                                 </div>
                                 <div class="service__counter-single-content">
                                    <h3><span class="odometer" data-odometer-final="99"></span><span class="prefix">+</span></h3>
                                    <p>Winning Awards</p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-sm-6 col-lg-3">
                              <div class="counter__single">
                                 <div class="counter__single-icon">
                                    <div class="counter__single-icon__inner">
                                       <i class="icon-documents"></i>
                                    </div>
                                 </div>
                                 <div class="service__counter-single-content">
                                    <h3><span class="odometer" data-odometer-final="800"></span><span class="prefix">+</span></h3>
                                    <p>Happy Clients</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / counter section end ==== -->
         <!-- ==== team section start ==== -->
         <section class="team-area pt-120 pb-120">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-xl-5">
                     <div class="section__header text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
                        <span>Supporting Our Cause Together</span>
                        <h2 class="title-animation">Meet Our Dedicated Team Members</h2>
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
               <div class="row">
                  <div class="col-12">
                     <div class="team-two__inner">
                        <div class="team-two-slider swiper">
                           <div class="swiper-wrapper">
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/one.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer</span>
                                       <h4><a href="team-details.html">Andren Willium</a></h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/two.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer</span>
                                       <h4><a href="team-details.html">Cathy Decosta
                                          </a>
                                       </h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/three.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer
                                       </span>
                                       <h4><a href="team-details.html">Thomas Ster
                                          </a>
                                       </h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/one.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer</span>
                                       <h4><a href="team-details.html">Andren Willium</a></h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/two.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer</span>
                                       <h4><a href="team-details.html">Cathy Decosta
                                          </a>
                                       </h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="{{ asset('assets/images/team/three.png') }}" alt="Image">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none">
                                             <circle cx="150" cy="150" r="130" stroke-linecap="round" />
                                          </svg>
                                       </div>
                                       <div class="social">
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
                                    <div class="content">
                                       <span>Volunteer
                                       </span>
                                       <h4><a href="team-details.html">Thomas Ster
                                          </a>
                                       </h4>
                                       <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="slider-navigation">
                           <button type="button" aria-label="prev slide" title="prev slide" class="prev-team slider-btn">
                           <i class="fa-solid fa-arrow-left"></i>
                           </button>
                           <button type="button" aria-label="next slide" title="next slide"
                              class="next-team slider-btn slider-btn-next">
                           <i class="fa-solid fa-arrow-right"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / team section end ==== -->
         <!-- ==== faq section start ==== -->
         <section class="faq pt-120 pb-120 primary-bg">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-12 col-lg-8 col-xl-6">
                     <div class="faq__content">
                        <div class="section__header mb-55" data-aos="fade-up" data-aos-duration="1000">
                           <span>Answers to Common Inquiries</span>
                           <h2 class="title-animation">Frequently Asked Questions</h2>
                        </div>
                        <div class="faq__content-inner cta" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                           <div class="accordion" id="accordion">
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What kind of recipes can I find on your website?
                                    </button>
                                 </h6>
                                 <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          It is a long established fact that a reader will be distracted by
                                          the readable the a content of a page when looking at its layout.
                                          Many desktop publishing packages and web page editors.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Are the recipes suitable for beginners?
                                    </button>
                                 </h6>
                                 <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          It is a long established fact that a reader will be distracted by
                                          the readable the a content of a page when looking at its layout.
                                          Many desktop publishing packages and web page editors.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Do you offer cooking tips and techniques?
                                    </button>
                                 </h6>
                                 <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          It is a long established fact that a reader will be distracted by
                                          the readable the a content of a page when looking at its layout.
                                          Many desktop publishing packages and web page editors.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    How frequently do you update your recipe collection?
                                    </button>
                                 </h6>
                                 <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          It is a long established fact that a reader will be distracted by
                                          the readable the a content of a page when looking at its layout.
                                          Many desktop publishing packages and web page editors.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-4 col-xl-5">
                     <div class="faq__thumb d-none d-lg-block">
                        <div class="faq__thumb-inner">
                           <div class="thumb-lg" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                              <img src="{{ asset('assets/images/faq/thumb-lg.png') }}" alt="Image">
                           </div>
                           <div class="thumb-sm" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                              <img src="{{ asset('assets/images/faq/thumb-sm.png') }}" alt="Image">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / faq section end ==== -->
         <!-- ==== contact section start ==== -->
         <section class="contact-mc">
            <div class="container">
               <div class="row justify-content-end">
                  <div class="col-12 col-md-10 col-xl-7">
                     <div class="contact__content pt-120 pb-120">
                        <div class="section__header mb-55" data-aos="fade-up" data-aos-duration="1000">
                           <span class="sub-title">Get In Touch</span>
                           <h2 class="title-animation">Send Us message
                              For donation!
                           </h2>
                        </div>
                        <div class="contact__form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                           <form action="#" method="post">
                              <div class="input-group">
                                 <div class="input-single">
                                    <input type="email" name="contact-email" id="contactEmail" required placeholder="your email...">
                                    <i class="fa-solid fa-paper-plane"></i>
                                 </div>
                                 <div class="input-single">
                                    <input type="text" name="contact-number" id="contactNumber" required placeholder="your phone...">
                                    <i class="fa-solid fa-phone"></i>
                                 </div>
                              </div>
                              <div class="input-single">
                                 <input type="text" name="contact-address" id="contactAddress" placeholder="your address...">
                                 <i class="fa-solid fa-location-dot"></i>
                              </div>
                              <div class="input-single alter-input">
                                 <textarea name="contact-message" id="contactMessage" placeholder="your message..."></textarea>
                                 <i class="fa-solid fa-envelope"></i>
                              </div>
                              <div class="form-cta">
                                 <button type="submit" aria-label="submit message" title="submit message" class="btn--secondary"
                                    data-text="Get A Quote"><span>Get A Quote</span></button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="contact-bg">
               <img src="{{ asset('assets/images/contact-bg.jpg') }}" alt="Image" class="parallax-image">
            </div>
            <div class="shape-left" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="300">
               <img src="{{ asset('assets/images/shape-left.png') }}" alt="Image" class="base-img">
            </div>
         </section>
         <!-- ==== / contact section end ==== -->
         <!-- ==== blog section start ==== -->
         <section class="blog-area pt-120 pb-120">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-12 col-lg-10 col-xl-5">
                     <div class="section__header text-center mb-60" data-aos="fade-up" data-aos-duration="1000">
                        <span>Discover powerful stories</span>
                        <h2 class="title-animation">Latest Updates and Impactful Stories</h2>
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
               <div class="row gutter-40">
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="blog__single" data-aos="fade-up" data-aos-duration="1000">
                        <div class="blog__single-thumb">
                           <a href="blog-details.html">
                           <img src="{{ asset('assets/images/blog/one.png') }}" alt="Image">
                           </a>
                        </div>
                        <div class="blog__single-content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                           <div class="time">
                              <span>July</span>
                              <span>25</span>
                           </div>
                           <div class="tag">
                              <a href="blog.html"><i class="fa-solid fa-tags"></i>Education</a>
                           </div>
                           <div class="blog__single-title">
                              <h5><a href="blog-details.html">IT Service Case Studies Accelerate Business</a>
                              </h5>
                           </div>
                           <div class="blog__single-cta">
                              <a href="blog-details.html">Read More<i class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="blog__single" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <div class="blog__single-thumb">
                           <a href="blog-details.html">
                           <img src="{{ asset('assets/images/blog/two.png') }}" alt="Image">
                           </a>
                        </div>
                        <div class="blog__single-content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                           <div class="time">
                              <span>July</span>
                              <span>25</span>
                           </div>
                           <div class="tag">
                              <a href="blog.html"><i class="fa-solid fa-tags"></i> Health</a>
                           </div>
                           <div class="blog__single-title">
                              <h5><a href="blog-details.html">IT Service Case Studies Accelerate Business</a>
                              </h5>
                           </div>
                           <div class="blog__single-cta">
                              <a href="blog-details.html">Read More<i class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-md-6 col-xl-4">
                     <div class="blog__single" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                        <div class="blog__single-thumb">
                           <a href="blog-details.html">
                           <img src="{{ asset('assets/images/blog/three.png') }}" alt="Image">
                           </a>
                        </div>
                        <div class="blog__single-content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                           <div class="time">
                              <span>July</span>
                              <span>25</span>
                           </div>
                           <div class="tag">
                              <a href="blog.html"><i class="fa-solid fa-tags"></i> Food</a>
                           </div>
                           <div class="blog__single-title">
                              <h5><a href="blog-details.html">IT Service Case Studies Accelerate Business</a></h5>
                           </div>
                           <div class="blog__single-cta">
                              <a href="blog-details.html">Read More<i class="fa-solid fa-arrow-right-long"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / blog section end ==== -->
         <!-- ==== image gallery section start ==== -->
         <div class="gallery">
            <div class="gallery__inner">
               <div class="gallery__slider">
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/one.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/two.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/three.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/four.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/five.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/six.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/one.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/two.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/three.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/four.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/five.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="{{ asset('assets/images/gallery/six.png') }}" alt="Image">
                     <a href="{{ route('home') }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- ==== / image gallery section end ==== -->
         <!-- ==== footer start ==== -->

        <x-footer>
        </x-footer>
