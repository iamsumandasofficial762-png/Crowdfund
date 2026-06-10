<x-header>
</x-header>

<!-- ==== banner section start ==== -->
         <section class="common-banner">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="common-banner__content text-center">
                        <h2 class="title-animation">About Us</h2>
                     </div>
                  </div>
               </div>
            </div>
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                     About Us
                  </li>
               </ol>
            </nav>
            <div class="banner-bg">
               <img src="assets/images/banner/banner-bg.jpg" alt="Image">
            </div>
            <div class="sprade" data-aos="zoom-in" data-aos-duration="1000">
               <img src="assets/images/sprade-base.png" alt="Image" class="base-img">
            </div>
            <div class="line">
               <img src="assets/images/line.png" alt="Image">
            </div>
         </section>
         <!-- ==== / banner section end ==== -->
         <!-- ==== about section start ==== -->
         <section class="about-area pt-120 pb-120">
            <div class="container">
               <div class="row align-items-center gutter-40">
                  <div class="col-12 col-lg-5 col-xl-6">
                     <div class="about__thumb">
                        <div class="about__thumb-big">
                           <img src="assets/images/difference/thumb-lg-two.jpg" alt="Image" data-aos="fade-right"
                              data-aos-duration="1000">
                           <div class="video-btn-wrapper">
                              <a href="https://www.youtube.com/watch?v=RvreULjnzFo" target="_blank" title="video Player"
                                 class="open-video-popup">
                              <i class="fa-solid fa-play"></i>
                              </a>
                           </div>
                        </div>
                        <div class="about__thumb-sm">
                           <img src="assets/images/difference/thumb-sm-two.jpg" alt="Image" data-aos="fade-left"
                              data-aos-duration="1000" data-aos-delay="100">
                           <!-- <div class="about__thumb-sm__content" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                              <div class="about__thumb-sm__content-counter">
                                 <h2><span class="odometer" data-odometer-final="15"></span><span>+</span></h2>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                       d="M22.6317 12.3421L20.9825 7L19.3684 12.3053H14L18.3509 15.621L16.6667 21L21.0175 17.6842L25.3684 21L23.6491 15.6579L28 12.3421H22.6317Z"
                                       fill="#00C2FF" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                       d="M7.82123 0H34.1788V2.60708H42V11.8752C42 14.3333 41.0235 16.6907 39.2855 18.4288C37.8683 19.8459 36.0395 20.7567 34.0802 21.0448C33.7921 23.0042 32.8814 24.8329 31.4641 26.25C29.7598 27.9543 27.4601 28.9264 25.0541 28.9636V32.7318C25.0541 33.0396 25.1762 33.3347 25.3938 33.5521C25.6115 33.7698 25.9066 33.892 26.2141 33.892C27.6351 33.892 28.9977 34.4564 30.0024 35.4611C31.0072 36.4658 31.5718 37.8287 31.5718 39.2494V42H10.4283V39.2494C10.4283 37.8287 10.9928 36.4658 11.9975 35.4611C13.0022 34.4564 14.3649 33.892 15.7859 33.892C16.0935 33.892 16.3886 33.7698 16.6062 33.5521C16.8238 33.3347 16.946 33.0396 16.946 32.7318V28.9636C14.5398 28.9264 12.2401 27.9543 10.5358 26.25C9.11868 24.8329 8.20789 23.0042 7.9198 21.0448C5.96043 20.7567 4.13168 19.8459 2.71458 18.4288C0.976454 16.6907 0 14.3333 0 11.8752V2.60708H7.82123V0ZM10.7151 2.89384V19.6965C10.7151 21.387 11.3867 23.0083 12.5821 24.2038C13.7775 25.3993 15.3988 26.0708 17.0894 26.0708H19.8398V32.7318C19.8398 33.8069 19.4127 34.8381 18.6525 35.5985C17.8922 36.3587 16.861 36.7859 15.7859 36.7859C15.1325 36.7859 14.5058 37.0453 14.0438 37.5075C13.6156 37.9356 13.3614 38.505 13.3263 39.1062H28.6737C28.6388 38.505 28.3843 37.9356 27.9562 37.5075C27.4942 37.0453 26.8675 36.7859 26.2141 36.7859C25.139 36.7859 24.1078 36.3587 23.3476 35.5985C22.5872 34.8381 22.1602 33.8069 22.1602 32.7318V26.0708H24.9106C26.6011 26.0708 28.2225 25.3993 29.4179 24.2038C30.6134 23.0083 31.285 21.387 31.285 19.6965V2.89384H10.7151ZM7.82123 5.50093H2.89384V11.8752C2.89384 13.5658 3.56543 15.1871 4.76083 16.3826C5.60901 17.2307 6.67161 17.8152 7.82123 18.0832V5.50093ZM34.1788 18.0832V5.50093H39.1062V11.8752C39.1062 13.5658 38.4346 15.1871 37.2391 16.3826C36.391 17.2307 35.3283 17.8152 34.1788 18.0832Z"
                                       fill="#04009A" />
                                 </svg>
                              </div>
                              <p>Years Experience</p>
                           </div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-7 col-xl-6">
                     <div class="about__content">
                        <div class="section__header">
                           <span>Supporting Our Cause Together</span>
                           <h2 class="title-animation">Support Our Mission and Make a Difference</h2>
                           <p>Empowering lives through education, healthcare, and community support initiatives that create lasting social impact. 
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
                                 <h3><span class="odometer" data-odometer-final="99"></span><span>+</span></h3>
                                 <p>Active Reviews</p>
                              </div>
                              <div class="join-users">
                                 <div class="single-user">
                                    <img src="assets/images/avatar/avatar-user.png" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="assets/images/avatar/avatar-user.png" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="assets/images/avatar/avatar-user.png" alt="Image">
                                 </div>
                                 <div class="single-user">
                                    <img src="assets/images/avatar/avatar-user.png" alt="Image">
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / about section end ==== -->
         <!-- ==== counter section start ==== -->
         <!-- <section class="counter pt-120 pb-120">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="counter__inner">
                        <div class="counter__single">
                           <div class="thumb">
                              <i class="icon-support-hand"></i>
                           </div>
                           <div class="counter__content">
                              <h2><span class="odometer" data-odometer-final="400"></span><span
                                 class="prefix">+</span>
                              </h2>
                              <h5>Team member</h5>
                           </div>
                        </div>
                        <div class="divider"></div>
                        <div class="counter__single">
                           <div class="thumb">
                              <i class="icon-review"></i>
                           </div>
                           <div class="counter__content">
                              <h2><span class="odometer" data-odometer-final="80"></span>K<span
                                 class="prefix">+</span>
                              </h2>
                              <h5>Client's review</h5>
                           </div>
                        </div>
                        <div class="divider"></div>
                        <div class="counter__single">
                           <div class="thumb">
                              <i class="icon-documents"></i>
                           </div>
                           <div class="counter__content">
                              <h2><span class="odometer" data-odometer-final="100"></span>K<span
                                 class="prefix">+</span>
                              </h2>
                              <h5>Completed projects</h5>
                           </div>
                        </div>
                        <div class="divider"></div>
                        <div class="counter__single">
                           <div class="thumb">
                              <i class="icon-award"></i>
                           </div>
                           <div class="counter__content">
                              <h2><span class="odometer" data-odometer-final="40"></span>K<span
                                 class="prefix">+</span>
                              </h2>
                              <h5>Winning award</h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="poor">
               <img src="assets/images/banner/banner-three-bg.jpg" alt="Image" class="parallax-image">
            </div>
            <div class="shape-left" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="300">
               <img src="assets/images/shape-left.png" alt="Image" class="base-img">
            </div>
         </section> -->
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
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Arjun Mukherjee</a></h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Ananya Sen
                                          </a>
                                       </h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Suman kumar
                                          </a>
                                       </h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Priya Roy</a></h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Aarav Sharma
                                          </a>
                                       </h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="swiper-slide">
                                 <div class="team__single">
                                    <div class="thumb-wrapper">
                                       <div class="thumb">
                                          <img src="assets/images/team/images.png" alt="Image">
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
                                       <h4><a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Rohan Das
                                          </a>
                                       </h4>
                                       <!-- <p><a href="tel:256-255-6579"><i class="ph ph-phone-call"></i> Call: +256 255
                                          6579</a>
                                       </p> -->
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
                                    <input type="email" name="contact-email" id="contactEmail"
                                       placeholder="your email...">
                                    <i class="fa-solid fa-paper-plane"></i>
                                 </div>
                                 <div class="input-single">
                                    <input type="text" name="contact-number" id="contactNumber"
                                       placeholder="your phone...">
                                    <i class="fa-solid fa-phone"></i>
                                 </div>
                              </div>
                              <div class="input-single">
                                 <input type="text" name="contact-address" id="contactAddress"
                                    placeholder="your address...">
                                 <i class="fa-solid fa-location-dot"></i>
                              </div>
                              <div class="input-single alter-input">
                                 <textarea name="contact-message" id="contactMessage"
                                    placeholder="your message..."></textarea>
                                 <i class="fa-solid fa-envelope"></i>
                              </div>
                              <div class="form-cta">
                                 <button type="submit" aria-label="submit message" title="submit message"
                                    class="btn--secondary" data-text="Get A Quote"><span>Get A
                                 Quote</span></button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="contact-bg">
               <img src="assets/images/contact-bg.jpg" alt="Image" class="parallax-image">
            </div>
            <div class="shape-left" data-aos="fade-down" data-aos-duration="1000" data-aos-delay="300">
               <img src="assets/images/shape-left.png" alt="Image" class="base-img">
            </div>
         </section>
         <!-- ==== / contact section end ==== -->
         <!-- ==== faq section start ==== -->
         <section class="faq pt-120 pb-120">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-12 col-lg-8 col-xl-6">
                     <div class="faq__content">
                        <div class="section__header mb-55" data-aos="fade-up" data-aos-duration="1000">
                           <span>Answers to Common Inquiries</span>
                           <h2 class="title-animation">Frequently Asked Questions</h2>
                        </div>
                        <div class="faq__content-inner cta" data-aos="fade-up" data-aos-duration="1000"
                           data-aos-delay="100">
                           <div class="accordion" id="accordion">
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                       data-bs-target="#collapseOne" aria-expanded="true"
                                       aria-controls="collapseOne">
                                    What kind of causes can I support?
                                    </button>
                                 </h6>
                                 <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          You can support medical treatment, education, food assistance, child care, and other verified community needs.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                       data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                       aria-expanded="false" aria-controls="collapseTwo">
                                    Is my donation secure?
                                    </button>
                                 </h6>
                                 <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          Yes, donations are processed through safe payment methods, and campaign updates help donors stay informed.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                       data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                       aria-expanded="false" aria-controls="collapseThree">
                                    Can I start a fundraiser?
                                    </button>
                                 </h6>
                                 <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          Yes, you can start a fundraiser by sharing the required details, documents, and story behind the cause.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h6 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                       data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                       aria-expanded="false" aria-controls="collapseFour">
                                    How do I know where my donation goes?
                                    </button>
                                 </h6>
                                 <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                       <p>
                                          Campaign pages show goals, raised amounts, and updates so donors can clearly understand the impact of their support.
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
                              <img src="assets/images/faq/thumb-lg.png" alt="Image">
                           </div>
                           <div class="thumb-sm" data-aos="fade-left" data-aos-duration="1000"
                              data-aos-delay="300">
                              <img src="assets/images/faq/thumb-sm.png" alt="Image">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / faq section end ==== -->
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
                                                <img src="assets/images/testimonial/user.png" alt="Image">
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
                                                <p>Karna Kabach made it incredibly easy to support causes that truly matter. The platform is transparent, reliable, and keeps donors informed about the impact of their contributions.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>Community Volunteer</span>
                                                      <h4>Priya Sharma</h4>
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
                                                <img src="assets/images/testimonial/user.png" alt="Image">
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
                                                <p>The dedication and transparency shown by Karna Kabach inspire confidence. It's wonderful to see how collective generosity can transform lives and strengthen communities.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>regular donor</span>
                                                      <h4>Ananya Roy</h4>
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
                                                <img src="assets/images/testimonial/user.png" alt="Image">
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
                                                <p>I was looking for a trusted way to contribute to social causes, and Karna Kabach exceeded my expectations. Every campaign is presented clearly, making it easy to help those in need.
                                                </p>
                                                <div class="testimonial__cta">
                                                   <div class="quote-icon">
                                                      <i class="fa-solid fa-quote-right"></i>
                                                   </div>
                                                   <div class="testimonial__cta-content">
                                                      <span>Social Impact Advocate</span>
                                                      <h4>Rahul Mehta</h4>
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
         <!-- ==== image gallery section start ==== -->
         <div class="gallery">
            <div class="gallery__inner">
               <div class="gallery__slider">
                  <div class="gallery__single">
                     <img src="assets/images/gallery/one.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/two.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/three.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/four.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/five.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/six.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/one.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/two.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/three.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/four.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/five.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
                  <div class="gallery__single">
                     <img src="assets/images/gallery/six.png" alt="Image">
                     <a href="{{ route('coming-soon', ['menu' => 'index']) }}">
                     <i class="fa-brands fa-instagram"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- ==== / image gallery section end ==== -->

<x-footer>
</x-footer>