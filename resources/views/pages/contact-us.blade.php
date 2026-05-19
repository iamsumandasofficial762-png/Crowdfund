<x-header>
</x-header>

<!-- ==== / header end ==== -->
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
                        <a href="{{ route('coming-soon', ['menu' => 'event-details']) }}">
                        <img src="assets/images/shop/cart-one.png" alt="Image">
                        </a>
                     </div>
                     <div class="cart-item-content">
                        <h6 class="h6 title-anim">
                           <a href="{{ route('coming-soon', ['menu' => 'product-single']) }}">Headset</a>
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
                        <a href="{{ route('coming-soon', ['menu' => 'event-details']) }}">
                        <img src="assets/images/shop/cart-two.png" alt="Image">
                        </a>
                     </div>
                     <div class="cart-item-content">
                        <h6 class="h6 title-anim">
                           <a href="{{ route('coming-soon', ['menu' => 'product-single']) }}">Headphone</a>
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
                  <a class="view-cart-button" href="{{ route('coming-soon', ['menu' => 'cart']) }}" aria-label="go to cart">Cart</a>
                  <a class="checkout-button" href="{{ route('coming-soon', ['menu' => 'checkout']) }}" aria-label="go to checkout">
                  Checkout
                  <i class="fa-solid fa-arrow-right-long"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="cart-backdrop"></div>
         <!-- ==== / sidebar cart end ==== -->
         <!-- ==== banner section start ==== -->
         <section class="common-banner">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="common-banner__content text-center">
                        <h2 class="title-animation">Contact Us</h2>
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
                     Contact Us
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
         <!-- ==== contact map start ==== -->
         <div class="contact-map pt-120">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="map-inner" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14731.466891410182!2d88.44925396382753!3d22.62145157826544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f89fdd81deeb33%3A0x191e034976d7c464!2sEk%20Tower%2C%204B%2C%20Action%20Area%20II%2C%20Action%20Area%20IID%2C%20Newtown%2C%20New%20Town%2C%20West%20Bengal%20700161!5e0!3m2!1sen!2sin!4v1779107838333!5m2!1sen!2sin" 
                           width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- ==== / contact map end ==== -->
         <!-- ==== contact section start ==== -->
         <section class="contact contact-main volunteer pt-120 pb-120">
            <div class="container">
               <div class="row gutter-40">
                  <div class="col-12 col-lg-5 col-xl-4">
                     <div class="contact__content">
                        <div class="section__header mb-55" data-aos="fade-up" data-aos-duration="1000">
                           <span>Get In Touch</span>
                           <h2 class="title-animation">Contact Us</h2>
                           <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                              doloremque laudantium, totam rem aperiam, eaque inventore
                           </p>
                        </div>
                        <div class="topbar__item mt-60">
                           <div class="topbar__item-single" data-aos="fade-up" data-aos-duration="1000">
                              <div class="topbar__item-single__icon">
                                 <i class="fa-solid fa-phone"></i>
                              </div>
                              <div class="topbar__item-single__content">
                                 <span>Call Us:</span>
                                 <p><a href="tel:6231255667">6231255667</a></p>
                              </div>
                           </div>
                           <div class="topbar__item-single" data-aos="fade-up" data-aos-duration="1000"
                              data-aos-delay="200">
                              <div class="topbar__item-single__icon">
                                 <i class="fa-solid fa-envelope"></i>
                              </div>
                              <div class="topbar__item-single__content">
                                 <span>E-Mail us:
                                 </span>
                                 <p><a href="mailto:support@example.com">example@email.com</a></p>
                              </div>
                           </div>
                           <div class="topbar__item-single" data-aos="fade-up" data-aos-duration="1000"
                              data-aos-delay="400">
                              <div class="topbar__item-single__icon">
                                 <i class="fa-solid fa-location-dot"></i>
                              </div>
                              <div class="topbar__item-single__content">
                                 <span>
                                 kolkata, west bengal
                                 </span>
                                 <p><a href="https://maps.app.goo.gl/oyBEwhxRQuHmkTqE6" target="_blank">Shrachi EK Tower, EKT/5/Office-B,
Newtown, Kolkata, West Bengal 700161</a>
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-lg-7 offset-xl-1 col-xl-7">
                     <div class="contact__form volunteer__form checkout__form" data-aos="fade-up"
                        data-aos-duration="1000" data-aos-delay="100">
                        <div class="volunteer__form-content">
                           <h4 class="title-animation">Fill Up The Form</h4>
                           <p>Your email address will not be published. Required fields are marked *</p>
                        </div>
                        @if (session('status'))
                           <div class="alert alert-success mt-4">{{ session('status') }}</div>
                        @endif
                        @if ($errors->any())
                           <div class="alert alert-danger mt-4">
                              <ul class="mb-0 ps-3">
                                 @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
                        @endif
                        <form action="{{ route('contact-messages.store') }}" method="post" class="mt-60">
                           @csrf
                           <div class="input-single">
                              <input type="text" name="name" id="fullName" value="{{ old('name') }}" placeholder="Enter Name" required>
                              <i class="fa-solid fa-user"></i>
                           </div>
                           <div class="input-single">
                              <input type="email" name="email" id="cEmail" value="{{ old('email') }}" placeholder="Enter Email" required>
                              <i class="fa-solid fa-envelope"></i>
                           </div>
                           <div class="input-single">
                              <input type="text" name="phone" id="phoneNumber" value="{{ old('phone') }}" placeholder="Phone Number">
                              <i class="fa-solid fa-phone"></i>
                           </div>
                           <div class="input-single alter-input">
                              <textarea name="message" id="contactMessage"
                                 placeholder="Your Message...">{{ old('message') }}</textarea>
                              <i class="fa-solid fa-comments"></i>
                           </div>
                           <div class="form-cta">
                              <button type="submit" aria-label="submit message" title="submit message"
                                 class="btn--secondary" data-text="Get A Quote"><span>Get A Quote</span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ==== / contact section end ==== -->
         <!-- ==== footer start ==== -->

<x-footer>
</x-footer>
