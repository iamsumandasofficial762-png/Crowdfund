<x-header>
</x-header>

<style>
   .soon--simple {
      display: flex;
      align-items: center;
      padding-top: 140px;
      padding-bottom: 140px;
   }

   .soon--simple .soon__inner {
      width: 100%;
   }

   .soon--simple .form-group {
      margin-top: 44px;
   }
</style>

<section class="soon soon--simple">
   <div class="soon-bg">
      <img src="{{ asset('assets/images/coming-soon-bg.jpg') }}" alt="Coming soon background" class="parallax-image">
   </div>

   <div class="container">
      <div class="soon__inner">

         <div class="content mt-40" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <h4 class="title-animation">We Are Coming Soon</h4>
            <p>Our new fundraising experience is almost ready.</p>
            <p>Subscribe and we will let you know when we launch.</p>
         </div>

         <form action="#" method="post" class="form-group" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <input type="email" name="email" id="comingSoonEmail" placeholder="Enter your email" required>
            <button type="submit" class="btn--primary" aria-label="subscribe for launch updates" title="subscribe">
               Notify Me
            </button>
         </form>
      </div>
   </div>
</section>

<x-footer>
</x-footer>
