<x-header>
</x-header>

<style>
   .resource-page {
      background:
         radial-gradient(circle at 86% 12%, rgba(147, 42, 25, 0.14), transparent 30%),
         linear-gradient(180deg, #fff7f6 0%, #ffffff 42%, #fffaf8 100%);
   }

   .resource-callback {
      padding: 90px 0 110px;
   }

   .resource-callback__title {
      margin-bottom: 34px;
      color: #071226;
      font-size: clamp(30px, 4vw, 42px);
      font-weight: 900;
      line-height: 1.15;
      text-align: center;
      letter-spacing: 0;
   }

   .resource-callback__card {
      width: min(100%, 1040px);
      display: grid;
      grid-template-columns: 0.9fr 1.1fr;
      margin: 0 auto;
      border: 1px solid rgba(147, 42, 25, 0.12);
      border-radius: 12px;
      overflow: hidden;
      background: #ffffff;
      box-shadow: 0 26px 70px rgba(18, 24, 39, 0.1);
   }

   .resource-help {
      min-height: 670px;
      padding: clamp(32px, 5vw, 48px);
      color: #ffffff;
      background:
         linear-gradient(145deg, rgba(147, 42, 25, 0.96), rgba(111, 31, 19, 0.96)),
         #932a19;
   }

   .resource-help h2 {
      margin: 0 0 18px;
      color: #ffffff;
      font-size: clamp(26px, 3vw, 34px);
      font-weight: 900;
   }

   .resource-help > p {
      max-width: 380px;
      margin: 0 0 34px;
      color: rgba(255, 255, 255, 0.9);
      font-size: 16px;
      line-height: 1.65;
      font-weight: 800;
   }

   .resource-help__list {
      display: grid;
      gap: 24px;
   }

   .resource-help__item {
      display: grid;
      grid-template-columns: 42px 1fr;
      gap: 16px;
      align-items: start;
   }

   .resource-help__icon {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      background: rgba(255, 255, 255, 0.18);
      font-size: 18px;
   }

   .resource-help__item h3 {
      margin: 0 0 4px;
      color: #ffffff;
      font-size: 18px;
      font-weight: 900;
   }

   .resource-help__item p {
      margin: 0;
      color: rgba(255, 255, 255, 0.82);
      font-size: 13px;
      line-height: 1.45;
      font-weight: 800;
   }

   .resource-form-panel {
      padding: clamp(32px, 5vw, 48px) clamp(34px, 5vw, 56px);
      background: #ffffff;
   }

   .resource-form-panel h2 {
      margin: 0 0 26px;
      color: #071226;
      font-size: 24px;
      font-weight: 900;
   }

   .resource-alert {
      margin-bottom: 18px;
      border-radius: 8px;
      padding: 12px 14px;
      border: 1px solid #d9efe1;
      color: #116033;
      background: #edf9f1;
      font-weight: 800;
   }

   .resource-alert--error {
      border-color: #f0c6bd;
      color: #9f321f;
      background: #fff7f5;
   }

   .resource-field {
      margin-bottom: 20px;
   }

   .resource-label {
      display: block;
      margin-bottom: 8px;
      color: #071226;
      font-size: 13px;
      font-weight: 900;
   }

   .resource-input,
   .resource-select,
   .resource-textarea {
      width: 100%;
      max-width: 100%;
      border: 1px solid #d8dde6;
      border-radius: 8px;
      outline: 0;
      padding: 0 14px;
      color: #071226;
      background: #ffffff;
      font: inherit;
      font-weight: 700;
      min-width: 0;
      box-sizing: border-box;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
   }

   .resource-select {
      appearance: none;
      padding-right: 38px;
      background-image: linear-gradient(45deg, transparent 50%, #647083 50%), linear-gradient(135deg, #647083 50%, transparent 50%);
      background-position: calc(100% - 17px) 50%, calc(100% - 12px) 50%;
      background-size: 5px 5px, 5px 5px;
      background-repeat: no-repeat;
      cursor: pointer;
   }

   .resource-input,
   .resource-select {
      height: 46px;
   }

   .resource-textarea {
      min-height: 104px;
      padding-top: 12px;
      resize: vertical;
   }

   .resource-input:focus,
   .resource-select:focus,
   .resource-textarea:focus {
      border-color: #932a19;
      box-shadow: 0 0 0 4px rgba(147, 42, 25, 0.14);
   }

   .resource-form-grid {
      display: grid;
      grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
      gap: 18px;
      align-items: start;
   }

   .resource-phone {
      display: grid;
      grid-template-columns: 76px minmax(0, 1fr);
      gap: 10px;
      align-items: start;
   }

   .resource-phone .resource-select {
      padding-right: 24px;
      background-position: calc(100% - 14px) 50%, calc(100% - 9px) 50%;
   }

   .resource-submit {
      width: min(100%, 220px);
      min-height: 46px;
      border: 0;
      border-radius: 999px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 26px auto 0;
      color: #ffffff;
      background: #932a19;
      font: inherit;
      font-weight: 900;
      box-shadow: 0 16px 28px rgba(147, 42, 25, 0.22);
      transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
   }

   .resource-submit:hover,
   .resource-submit:focus {
      color: #ffffff;
      background: #6f1f13;
      transform: translateY(-1px);
      box-shadow: 0 20px 34px rgba(147, 42, 25, 0.28);
   }

   @media (max-width: 991px) {
      .resource-callback__card {
         grid-template-columns: 1fr;
      }

      .resource-help {
         min-height: auto;
      }
   }

   @media (max-width: 575px) {
      .resource-callback {
         padding: 58px 0 76px;
      }

      .resource-form-grid {
         grid-template-columns: 1fr;
         gap: 0;
      }
   }
</style>

<main class="resource-page">
   <section class="resource-callback" aria-labelledby="resourceCallbackTitle">
      <div class="container">
         <h1 class="resource-callback__title" id="resourceCallbackTitle">Request a Call Back</h1>

         <div class="resource-callback__card">
            <aside class="resource-help">
               <h2>Need Help?</h2>
               <p>Our team is here to assist you in finding the right resources for your healthcare journey.</p>

               <div class="resource-help__list">
                  <article class="resource-help__item">
                     <span class="resource-help__icon"><i class="fa-solid fa-phone"></i></span>
                     <div>
                        <h3>Personal Assistance</h3>
                        <p>Get personalized guidance from our support team</p>
                     </div>
                  </article>
                  <article class="resource-help__item">
                     <span class="resource-help__icon"><i class="fa-regular fa-clock"></i></span>
                     <div>
                        <h3>Flexible Timing</h3>
                        <p>Choose a convenient time for us to reach you</p>
                     </div>
                  </article>
                  <article class="resource-help__item">
                     <span class="resource-help__icon"><i class="fa-regular fa-message"></i></span>
                     <div>
                        <h3>Multi-language Support</h3>
                        <p>Communicate in your preferred language</p>
                     </div>
                  </article>
               </div>
            </aside>

            <section class="resource-form-panel">
               <h2>Request a Call</h2>

               @if (session('status'))
                  <div class="resource-alert" role="status">{{ session('status') }}</div>
               @endif

               @if ($errors->any())
                  <div class="resource-alert resource-alert--error" role="alert">
                     <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
               @endif

               <form action="{{ route('fundraiser-referrals.store') }}" method="post">
                  @csrf

                  <div class="resource-field">
                     <label class="resource-label" for="resource_name">Name *</label>
                     <input class="resource-input" id="resource_name" type="text" name="name" value="{{ old('name') }}" required>
                  </div>

                  <div class="resource-field">
                     <label class="resource-label">Contact Number *</label>
                     <div class="resource-phone">
                        <select class="resource-select" name="country_code" aria-label="Country code">
                           <option value="+91" @selected(old('country_code', '+91') === '+91')>+91</option>
                           <option value="+1" @selected(old('country_code') === '+1')>+1</option>
                           <option value="+44" @selected(old('country_code') === '+44')>+44</option>
                           <option value="+971" @selected(old('country_code') === '+971')>+971</option>
                        </select>
                        <input class="resource-input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter number" required>
                     </div>
                  </div>

                  <div class="resource-form-grid">
                     <div class="resource-field">
                        <label class="resource-label" for="estimated_cost">Estimated cost (Rs) *</label>
                        <select class="resource-select" id="estimated_cost" name="estimated_cost" required>
                           <option value="">Select an estimated cost</option>
                           @foreach (['Below Rs. 50,000', 'Rs. 50,000 - Rs. 1,00,000', 'Rs. 1,00,000 - Rs. 5,00,000', 'Above Rs. 5,00,000', 'Not sure yet'] as $cost)
                              <option value="{{ $cost }}" @selected(old('estimated_cost') === $cost)>{{ $cost }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="resource-field">
                        <label class="resource-label" for="preferred_language">Language Preference</label>
                        <select class="resource-select" id="preferred_language" name="preferred_language" required>
                           <option value="">Select a language</option>
                           @foreach (['English', 'Hindi', 'Bengali', 'Telugu', 'Tamil', 'Kannada', 'Malayalam', 'Marathi', 'Gujarati'] as $language)
                              <option value="{{ $language }}" @selected(old('preferred_language') === $language)>{{ $language }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>

                  <div class="resource-field">
                     <label class="resource-label" for="reason">Reason for fundraising *</label>
                     <select class="resource-select" id="reason" name="reason" required>
                        <option value="">Select a reason</option>
                        @foreach (['Medical treatment', 'Education support', 'Emergency relief', 'Community support', 'Other'] as $reason)
                           <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="resource-field">
                     <label class="resource-label" for="description">Description</label>
                     <textarea class="resource-textarea" id="description" name="description" placeholder="Please provide details about your requirements...">{{ old('description') }}</textarea>
                  </div>

                  <div class="resource-field">
                     <label class="resource-label">Alternate Contact Number</label>
                     <div class="resource-phone">
                        <select class="resource-select" name="alternate_country_code" aria-label="Alternate country code">
                           <option value="+91" @selected(old('alternate_country_code', '+91') === '+91')>+91</option>
                           <option value="+1" @selected(old('alternate_country_code') === '+1')>+1</option>
                           <option value="+44" @selected(old('alternate_country_code') === '+44')>+44</option>
                           <option value="+971" @selected(old('alternate_country_code') === '+971')>+971</option>
                        </select>
                        <input class="resource-input" type="tel" name="alternate_phone" value="{{ old('alternate_phone') }}" placeholder="Enter number">
                     </div>
                  </div>

                  <button class="resource-submit" type="submit">Submit</button>
               </form>
            </section>
         </div>
      </div>
   </section>
</main>

<x-footer>
</x-footer>
