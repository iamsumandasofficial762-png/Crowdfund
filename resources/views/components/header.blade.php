<!DOCTYPE html>
<html lang="en">
   
<!-- Mirrored from webnextpro.com/tf/charitia/{{ route('home') }} by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 May 2026 11:34:44 GMT -->
<head>
      <!-- #required meta -->
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- #favicon -->
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
      <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
      <!-- #title -->
      <title>Karna Kabach</title>
      <!-- #keywords -->
      <meta name="keywords" content="charity, nonprofit, fundraising, donation, html, bootstrap, scss">
      <!-- #description -->
      <meta name="description" content="Nonprofit NGO Fundraising HTML5 Template">
      <!-- google fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com/">
      <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
      <link
         href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;display=swap"
         rel="stylesheet">
      <!-- color themes -->
      <link rel="stylesheet" href="{{ asset('assets/css/default-theme.css') }}" id="switch-color">
      <!-- main css -->
      <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
      <!-- responsive css -->
      <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
      <!-- sticky header css -->
      <link rel="stylesheet" href="{{ asset('assets/css/sticky-header.css') }}">
      <!-- box layout css -->
      <link rel="stylesheet" href="{{ asset('assets/css/box-layout.css') }}">
      <!-- dark mode css -->
      <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}">
      <!-- rtl version css -->
      <link rel="stylesheet" href="{{ asset('assets/css/rtl-version.css') }}">
      <style>
         :root {
            --site-header-height: 70px;
         }

         .header-secondary {
            padding-block: 0;
         }

         .header-secondary .main-header__menu-box,
         .header-secondary .navbar {
            height: var(--site-header-height);
            min-height: var(--site-header-height);
         }

         .header-secondary .main-header__menu-box {
            display: flex;
            align-items: center;
         }

         .header-secondary .navbar {
            width: 100%;
            align-items: stretch;
         }

         .header .navbar-logo,
         .header .navbar-logo a,
         .header .navbar__menu,
         .header .navbar__list,
         .header .navbar__options,
         .header .navbar__mobile-options,
         .header-secondary .navbar__mobile-options .navbar__cta-row {
            height: 100%;
            min-height: var(--site-header-height);
            display: flex;
            align-items: center;
         }

         .header .navbar-logo img {
            width: auto;
            height: auto;
            max-height: 58px;
         }

         .header .navbar__item > a {
            min-height: var(--site-header-height);
            display: flex;
            align-items: center;
            padding-top: 0;
            padding-bottom: 0;
         }

         .header-secondary .navbar__mobile-options .navbar__cta-row .btn--secondary {
            min-height: var(--site-header-height);
            display: inline-flex;
            align-items: center;
         }

         @media only screen and (max-width: 1199.98px) {
            .header-secondary .navbar {
               height: var(--site-header-height);
               min-height: var(--site-header-height);
            }

            .header .navbar-logo img {
               max-height: 58px;
            }
         }
      </style>
   </head>
   <body>
      <!--[if lte IE 9]>
      <p class="browserupgrade">
         You are using an <strong>outdated</strong> browser. Please
         <a href="https://browsehappy.com/">upgrade your browser</a> to improve
         your experience and security.
      </p>
      <![endif]-->
      <div class="page-wrapper">
         <!-- ==== preloader start ==== -->
         <div class="preloader">
            <i class="icon-donation"></i>
            <p>Karna Kabach</p>
         </div>
         <!-- ==== / preloader end ==== -->
         <!-- ==== topbar start ==== -->
         <div class="topbar topbar__secondary d-none d-lg-block">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="topbar__inner">
                        <div class="row align-items-center">
                           <div class="col-12 col-lg-6">
                              <div class="topbar__list-wrapper">
                                 <ul class="topbar__list">
                                    <li><a href="tel:2305-587-3407"><i class="ph ph-phone-call"></i>+2(305)
                                       587-3407</a>
                                    </li>
                                    <li><a href="mailto:support@example.com"><i
                                       class="ph ph-envelope-simple"></i>support@example.com</a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-12 col-lg-6">
                              <div class="topbar__items d-flex align-items-center justify-content-end flex-wrap">
                                 <div class="topbar__items-menu">
                                    <div class="topbar__items-menu__icon">
                                       <i class="ph ph-user"></i>
                                    </div>
                                    <ul class="topbar__items-menu__link">
                                       <li><a href="{{ route('fundraiser.login', ['mode' => 'login']) }}">Sign In</a></li>
                                       <li>/</li>
                                       <li><a href="{{ route('fundraiser.login', ['mode' => 'register']) }}">Register</a></li>
                                    </ul>
                                 </div>
                                 <div class="select-country topbar__select">
                                    <select name="country" class="country-select select">
                                       <option value="english">EN</option>
                                       <option value="french">FR</option>
                                       <option value="italian">IT</option>
                                       <option value="canada">CN</option>
                                    </select>
                                 </div>
                                 <div class="social topbar__social-menu">
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
         <!-- ==== / topbar end ==== -->
         <!-- ==== header start ==== -->
         <header class="header header-secondary">
            <div class="container">
               <div class="row">
                  <div class="col-12">
                     <div class="main-header__menu-box">
                        <nav class="navbar p-0">
                           <div class="navbar-logo">
                              <a href="{{ route('home') }}">
                              <img src="{{ asset('assets/images/logo.png') }}" alt="Image">
                              </a>
                           </div>
                           <div class="navbar__menu d-none d-xl-block">
                              <ul class="navbar__list">
                                 <li class="navbar__item nav-fade">
                                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
                                 </li>
                                 <li class="navbar__item nav-fade">
                                    <a href="{{ route('fundraiser-posts.index', ['menu' => 'donate']) }}" class="{{ request()->routeIs('fundraiser-posts.index') && request('menu') === 'donate' ? 'is-active' : '' }}">Donate</a>
                                 </li>
                                 <li class="navbar__item nav-fade">
                                    <a href="{{ route('coming-soon', ['menu' => 'pricing']) }}" class="{{ request()->routeIs('coming-soon') && request('menu') === 'pricing' ? 'is-active' : '' }}">Pricing</a>
                                 </li>
                                 <li class="navbar__item nav-fade">
                                    <a href="{{ route('coming-soon', ['menu' => 'resource']) }}" class="{{ request()->routeIs('coming-soon') && request('menu') === 'resource' ? 'is-active' : '' }}">Resource</a>
                                 </li>
                                 <!-- <li class="navbar__item nav-fade">
                                    <a href="{{ route('coming-soon', ['menu' => 'code-of-practice']) }}" class="{{ request()->routeIs('coming-soon') && request('menu') === 'code-of-practice' ? 'is-active' : '' }}">Code of practice</a>
                                 </li> -->
                                 <!-- <li class="navbar__item navbar__item--has-children nav-fade">
                                    <a href="#" aria-label="dropdown menu"
                                       class="navbar__dropdown-label dropdown-label-alter">Causes</a>
                                    <ul class="navbar__sub-menu">
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'our-causes']) }}">Our Causes</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'cause-details']) }}">Cause Details</a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li class="navbar__item navbar__item--has-children nav-fade">
                                    <a href="#" aria-label="dropdown menu"
                                       class="navbar__dropdown-label dropdown-label-alter">Shop</a>
                                    <ul class="navbar__sub-menu">
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'shop']) }}">Our Shop</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'product-single']) }}">Product Details</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'cart']) }}">View Cart</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'checkout']) }}">checkout</a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li class="navbar__item navbar__item--has-children nav-fade">
                                    <a href="#" aria-label="dropdown menu"
                                       class="navbar__dropdown-label dropdown-label-alter">Pages</a>
                                    <ul class="navbar__sub-menu">
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'faq']) }}">FAQ</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'donate-us']) }}">Donate Us</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'become-volunteer']) }}">Become Volunteer</a>
                                       </li>
                                       <li class="navbar__item navbar__item--has-children">
                                          <a aria-label="dropdown menu"
                                             class="navbar__dropdown-label navbar__dropdown-label-sub">Events</a>
                                          <ul class="navbar__sub-menu navbar__sub-menu__nested">
                                             <li>
                                                <a href="{{ route('coming-soon', ['menu' => 'events']) }}">Events</a>
                                             </li>
                                             <li>
                                                <a href="{{ route('coming-soon', ['menu' => 'event-details']) }}">Event Details</a>
                                             </li>
                                          </ul>
                                       </li>
                                       <li class="navbar__item navbar__item--has-children">
                                          <a aria-label="dropdown menu"
                                             class="navbar__dropdown-label navbar__dropdown-label-sub">Team</a>
                                          <ul class="navbar__sub-menu navbar__sub-menu__nested">
                                             <li>
                                                <a href="{{ route('coming-soon', ['menu' => 'our-team']) }}">Our Team</a>
                                             </li>
                                             <li>
                                                <a href="{{ route('coming-soon', ['menu' => 'team-details']) }}">Team Details</a>
                                             </li>
                                          </ul>
                                       </li>
                                       <li>
                                          <a href="{{ route('fundraiser.login', ['mode' => 'login']) }}">Sign In</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('fundraiser.login', ['mode' => 'register']) }}">Create Account</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'coming-soon']) }}">Coming Soon</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => '404']) }}">Error</a>
                                       </li>
                                    </ul>
                                 </li>
                                 <li class="navbar__item navbar__item--has-children nav-fade">
                                    <a href="#" aria-label="dropdown menu"
                                       class="navbar__dropdown-label dropdown-label-alter">News</a>
                                    <ul class="navbar__sub-menu">
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'blog-list']) }}">News List View</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'blog-grid']) }}">News Grid View</a>
                                       </li>
                                       <li>
                                          <a href="{{ route('coming-soon', ['menu' => 'blog-details']) }}">News Details</a>
                                       </li>
                                    </ul>
                                 </li> -->
                                 <li class="navbar__item nav-fade">
                                    <a href="{{ route('contact-us') }}" class="{{ request()->routeIs('contact-us') ? 'is-active' : '' }}">Contact Us</a>
                                 </li>
                              </ul>
                           </div>
                           <div class="navbar__options">
                              <div class="navbar__mobile-options ">
                                 <!-- <div class="search-box">
                                    <button class="open-search" aria-label="search products" title="open search box">
                                    <i class="ph ph-magnifying-glass"></i>
                                    </button>
                                 </div>
                                 <span class="divider"></span>
                                 <div class="cart-box">
                                    <button class="open-cart cart" aria-label="cart" title="open cart">
                                    <i class="ph ph-shopping-cart-simple"></i>
                                    <span>02</span>
                                    </button>
                                 </div> -->
                                 <div class="navbar__cta-row d-none d-md-flex">
                                    <a href="{{ route('fundraiser-details') }}" class="btn--secondary" data-text="Start a fundraiser"><span>Start a fundraiser</span></a>
                                    <!-- <span class="navbar__cta-divider"></span>
                                    <a href="{{ route('coming-soon', ['menu' => 'donate-us']) }}" class="btn--secondary" data-text="Donate Now"><span>Donate
                                    Now</span></a> -->
                                 </div>
                              </div>
                              <button class="open-offcanvas-nav d-flex d-xl-none" aria-label="toggle mobile menu"
                                 title="open offcanvas menu">
                              <span class="icon-bar top-bar"></span>
                              <span class="icon-bar middle-bar"></span>
                              <span class="icon-bar bottom-bar"></span>
                              </button>
                           </div>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </header>
