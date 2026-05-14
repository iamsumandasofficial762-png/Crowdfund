<x-header>
</x-header>

@php
   $pageTitle = 'Pricing';
@endphp

<style>
   .pricing-goal-page,
   .pricing-benefits {
      --pricing-navy: #06142f;
      --pricing-muted: #4f6179;
      --pricing-orange: #932a19;
      --pricing-orange-dark: #932a19;
      --pricing-cream: #fff8eb;
      --pricing-border: #d9e1ec;
      --pricing-green: #12966d;
   }

   .pricing-goal-page {
      display: grid;
      place-items: center;
      padding: clamp(76px, 7vw, 112px) 16px;
      background:
         radial-gradient(circle at 82% 0%, rgba(147, 42, 25, 0.22), transparent 28%),
         linear-gradient(135deg, #ffffff 0%, #f7f9fc 48%, var(--pricing-cream) 100%);
   }

   .pricing-goal {
      width: min(100%, 1080px);
      text-align: center;
   }

   .pricing-goal__title {
      margin: 0;
      color: var(--pricing-navy);
      font-size: clamp(32px, 4vw, 44px);
      font-weight: 900;
      line-height: 1.1;
   }

   .pricing-goal__ornament {
      width: min(100%, 360px);
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      gap: 14px;
      margin: 10px auto 8px;
      color: var(--pricing-orange-dark);
   }

   .pricing-goal__ornament::before,
   .pricing-goal__ornament::after {
      content: "";
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--pricing-orange-dark));
   }

   .pricing-goal__ornament::after {
      background: linear-gradient(90deg, var(--pricing-orange-dark), transparent);
   }

   .pricing-goal__subtitle {
      margin: 0 0 24px;
      color: var(--pricing-muted);
      font-size: clamp(16px, 2vw, 21px);
      font-weight: 700;
   }

   .pricing-goal__card {
      margin: 0 auto 18px;
      border: 1px solid var(--pricing-border);
      border-radius: 14px;
      padding: 30px;
      background: #ffffff;
      box-shadow: 0 20px 42px rgba(6, 20, 47, 0.1);
   }

   .pricing-goal__row {
      display: grid;
      grid-template-columns: minmax(260px, 1.2fr) minmax(170px, 0.62fr) minmax(300px, 1.18fr);
      gap: 24px;
      align-items: center;
      text-align: left;
   }

   .pricing-goal__label {
      display: flex;
      align-items: center;
      gap: 18px;
      color: var(--pricing-navy);
      font-size: 19px;
      font-weight: 900;
   }

   .pricing-goal__icon {
      width: 54px;
      height: 54px;
      display: inline-grid;
      place-items: center;
      flex: 0 0 auto;
      border-radius: 12px;
      color: var(--pricing-orange-dark);
      background: #f4dedb;
      font-size: 25px;
   }

   .pricing-goal__currency,
   .pricing-goal__input {
      width: 100%;
      min-height: 54px;
      border: 1px solid var(--pricing-border);
      border-radius: 10px;
      padding: 0 20px;
      color: var(--pricing-navy);
      background: #ffffff;
      font-size: 20px;
      font-weight: 800;
      outline: 0;
   }

   .pricing-goal__currency {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--pricing-muted);
      font-weight: 800;
      background: #fdfefe;
   }

   .pricing-goal__input:focus,
   .pricing-goal__currency:focus-within {
      border-color: var(--pricing-orange-dark);
      box-shadow: 0 0 0 4px rgba(147, 42, 25, 0.22);
   }

   .pricing-goal__range {
      margin: 28px 0 24px;
   }

   .pricing-goal__range input {
      width: 100%;
      height: 8px;
      border-radius: 999px;
      appearance: none;
      background: linear-gradient(90deg, var(--pricing-orange) var(--range-progress, 25%), #e7edf5 0);
      outline: 0;
   }

   .pricing-goal__range input::-webkit-slider-thumb {
      width: 26px;
      height: 26px;
      border: 0;
      border-radius: 50%;
      appearance: none;
      background: var(--pricing-orange-dark);
      box-shadow: 0 8px 18px rgba(147, 42, 25, 0.32);
      cursor: pointer;
   }

   .pricing-goal__range input::-moz-range-thumb {
      width: 26px;
      height: 26px;
      border: 0;
      border-radius: 50%;
      background: var(--pricing-orange-dark);
      box-shadow: 0 8px 18px rgba(147, 42, 25, 0.32);
      cursor: pointer;
   }

   .pricing-goal__presets {
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      gap: 14px;
   }

   .pricing-goal__preset {
      min-height: 44px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid var(--pricing-border);
      border-radius: 8px;
      color: var(--pricing-navy);
      background: #ffffff;
      font-size: 16px;
      font-weight: 800;
      white-space: nowrap;
      transition: border-color 0.2s ease, color 0.2s ease, background 0.2s ease;
   }

   .pricing-goal__preset:hover,
   .pricing-goal__preset.is-active {
      border-color: var(--pricing-orange-dark);
      color: #ffffff;
      background: linear-gradient(135deg, #c6281e, #932a19);
      box-shadow: 0 10px 20px rgba(147, 42, 25, 0.18);
   }

   .pricing-goal__button {
      width: min(100%, 1080px);
      min-height: 66px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 18px;
      border: 0;
      border-radius: 10px;
      color: #ffffff;
      background: linear-gradient(135deg, #b33a24, #932a19);
      font-size: 24px;
      font-weight: 900;
      box-shadow: 0 18px 34px rgba(147, 42, 25, 0.24);
   }

   .pricing-goal__button:hover {
      color: #ffffff;
      transform: translateY(-1px);
   }

   .pricing-goal__button:focus-visible,
   .pricing-benefits__tab:focus-visible,
   .pricing-goal__preset:focus-visible {
      outline: 3px solid rgba(147, 42, 25, 0.4);
      outline-offset: 3px;
   }

   .pricing-goal__result {
      position: relative;
      display: none;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      margin-top: 30px;
      padding: 42px 60px;
      border-radius: 12px;
      overflow: hidden;
      color: #ffffff;
      background: linear-gradient(135deg, #9f2b1c, #b83222);
      text-align: left;
   }

   .pricing-goal__result.is-visible {
      display: grid;
   }

   .pricing-goal__result::before,
   .pricing-goal__result::after {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      width: 220px;
      background: rgba(147, 42, 25, 0.16);
      clip-path: polygon(0 0, 100% 50%, 0 100%);
      pointer-events: none;
   }

   .pricing-goal__result::before {
      left: 30%;
   }

   .pricing-goal__result::after {
      left: 38%;
      background: rgba(91, 24, 12, 0.14);
   }

   .pricing-goal__result-main,
   .pricing-goal__breakup {
      position: relative;
      z-index: 1;
   }

   .pricing-goal__result-main p,
   .pricing-goal__breakup p {
      margin: 0;
      color: #ffffff;
      font-size: 18px;
      font-weight: 800;
   }

   .pricing-goal__total {
      margin: 22px 0 12px;
      color: #ffffff;
      font-size: clamp(34px, 4vw, 46px);
      font-weight: 900;
      line-height: 1;
   }

   .pricing-goal__disclaimer {
      max-width: 360px;
      color: rgba(255, 255, 255, 0.95);
      font-size: 13px;
      font-style: italic;
      font-weight: 800;
      line-height: 1.55;
   }

   .pricing-goal__breakup-title {
      margin-bottom: 26px !important;
      text-align: center;
   }

   .pricing-goal__breakup-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 20px;
      align-items: center;
      margin-top: 24px;
      color: #ffffff;
      font-size: 18px;
      font-weight: 900;
   }

   .pricing-goal__breakup-row span {
      color: rgba(255, 255, 255, 0.92);
   }

   .pricing-goal__breakup-row strong {
      color: #ffffff;
   }

   .pricing-benefits {
      position: relative;
      padding: clamp(72px, 8vw, 110px) 16px;
      overflow: hidden;
      background:
         radial-gradient(circle at 6% 4%, rgba(147, 42, 25, 0.12), transparent 22%),
         radial-gradient(circle at 94% 2%, rgba(147, 42, 25, 0.08), transparent 18%),
         linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
   }

   .pricing-benefits__decor {
      position: absolute;
      color: rgba(147, 42, 25, 0.36);
      pointer-events: none;
   }

   .pricing-benefits__decor--dots-left,
   .pricing-benefits__decor--dots-right {
      width: 64px;
      height: 64px;
      background-image: radial-gradient(currentColor 2px, transparent 2px);
      background-size: 18px 18px;
   }

   .pricing-benefits__decor--dots-left {
      top: 120px;
      left: 7%;
   }

   .pricing-benefits__decor--dots-right {
      top: 175px;
      right: 6%;
   }

   .pricing-benefits__decor--heart {
      top: 132px;
      left: 16%;
      font-size: 30px;
   }

   .pricing-benefits__decor--plane {
      top: 75px;
      right: 12%;
      font-size: 54px;
      transform: rotate(12deg);
   }

   .pricing-benefits__inner {
      position: relative;
      z-index: 1;
      width: min(100%, 1180px);
      margin: 0 auto;
      text-align: center;
   }

   .pricing-benefits__title {
      max-width: 820px;
      margin: 0 auto;
      color: var(--pricing-navy);
      font-size: clamp(34px, 4.4vw, 54px);
      font-weight: 900;
      line-height: 1.18;
   }

   .pricing-benefits__title span {
      color: #b21f17;
   }

   .pricing-benefits__subtitle {
      max-width: 760px;
      margin: 22px auto 36px;
      color: var(--pricing-muted);
      font-size: clamp(17px, 2vw, 22px);
      font-weight: 600;
      line-height: 1.5;
   }

   .pricing-benefits__switch {
      width: min(100%, 760px);
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0;
      margin: 0 auto 50px;
      padding: 6px;
      border-radius: 999px;
      background: #ffffff;
      box-shadow: 0 16px 34px rgba(6, 20, 47, 0.1);
   }

   .pricing-benefits__tab {
      min-height: 66px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      border: 0;
      border-radius: 999px;
      background: transparent;
      color: var(--pricing-navy);
      font-size: clamp(18px, 2vw, 26px);
      font-weight: 900;
      line-height: 1;
      cursor: pointer;
      transition: color 0.25s ease, background 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
   }

   .pricing-benefits__tab i {
      width: 28px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      line-height: 1;
   }

   .pricing-benefits__tab.is-active {
      color: #ffffff;
      background: linear-gradient(135deg, #cf251c, #932a19);
      box-shadow: 0 16px 28px rgba(147, 42, 25, 0.26);
   }

   .pricing-benefits__tab:not(.is-active) i {
      color: #b21f17;
   }

   .pricing-benefits__panel {
      display: none;
      opacity: 0;
      transform: translateY(18px);
   }

   .pricing-benefits__panel.is-active {
      display: block;
      animation: pricingBenefitsIn 0.38s ease forwards;
   }

   .pricing-benefits__panel.is-leaving {
      display: block;
      animation: pricingBenefitsOut 0.24s ease forwards;
   }

   @keyframes pricingBenefitsIn {
      from {
         opacity: 0;
         transform: translateY(22px) scale(0.985);
      }

      to {
         opacity: 1;
         transform: translateY(0) scale(1);
      }
   }

   @keyframes pricingBenefitsOut {
      from {
         opacity: 1;
         transform: translateY(0) scale(1);
      }

      to {
         opacity: 0;
         transform: translateY(-18px) scale(0.985);
      }
   }

   .pricing-benefits__heading {
      display: inline-grid;
      grid-template-columns: auto 1fr auto;
      align-items: center;
      gap: 28px;
      margin-bottom: 36px;
      color: var(--pricing-navy);
      font-size: clamp(24px, 3vw, 34px);
      font-weight: 900;
   }

   .pricing-benefits__heading::before,
   .pricing-benefits__heading::after {
      content: "";
      width: 26px;
      height: 26px;
      border-top: 3px solid #b21f17;
      border-bottom: 3px solid #b21f17;
   }

   .pricing-benefits__heading::before {
      border-left: 0;
      transform: skewY(25deg);
   }

   .pricing-benefits__heading::after {
      transform: skewY(-25deg);
   }

   .pricing-benefits__cards {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 28px;
      align-items: stretch;
   }

   .pricing-benefit-card {
      position: relative;
      min-height: 320px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 36px 58px;
      overflow: hidden;
      border: 1px solid var(--pricing-border);
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 20px 44px rgba(6, 20, 47, 0.07);
   }

   .pricing-benefit-card--impact {
      --benefit-color: #b21f17;
      --benefit-bg: #f7e1df;
      --benefit-soft: #f8dedd;
   }

   .pricing-benefit-card--story {
      --benefit-color: #b21f17;
      --benefit-bg: #f7e1df;
      --benefit-soft: #f8dedd;
   }

   .pricing-benefit-card--trust {
      --benefit-color: #b21f17;
      --benefit-bg: #f7e1df;
      --benefit-soft: #f8dedd;
   }

   .pricing-benefit-card--raise {
      --benefit-color: #b21f17;
      --benefit-bg: #f7e1df;
      --benefit-soft: #f8dedd;
   }

   .pricing-benefit-card::after {
      content: "";
      position: absolute;
      right: -12%;
      bottom: -42px;
      left: -12%;
      height: 100px;
      border-radius: 50% 50% 0 0;
      background: var(--benefit-soft);
   }

   .pricing-benefit-card__icon {
      width: 112px;
      height: 112px;
      display: inline-grid;
      place-items: center;
      flex: 0 0 112px;
      margin: 0 auto 26px;
      border-radius: 50%;
      color: var(--benefit-color);
      background: var(--benefit-bg);
      font-size: 42px;
      line-height: 1;
   }

   .pricing-benefit-card__icon i {
      width: 1em;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      line-height: 1;
   }

   .pricing-benefit-card h3 {
      position: relative;
      z-index: 1;
      min-height: 66px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 0 12px;
      color: var(--pricing-navy);
      font-size: clamp(22px, 2vw, 27px);
      font-weight: 900;
      line-height: 1.22;
      text-align: center;
   }

   .pricing-benefit-card p {
      position: relative;
      z-index: 1;
      max-width: 310px;
      margin: 0 auto;
      color: var(--pricing-muted);
      font-size: 17px;
      font-weight: 600;
      line-height: 1.55;
      text-align: center;
   }

   .pricing-benefit-card__line {
      position: relative;
      z-index: 1;
      display: block;
      width: 58px;
      height: 3px;
      margin-top: auto;
      border-radius: 999px;
      background: var(--benefit-color);
   }

   .pricing-benefits__note {
      width: min(100%, 960px);
      display: flex;
      align-items: center;
      gap: 24px;
      margin: 34px auto 0;
      padding: 22px 36px;
      border: 1px solid var(--pricing-border);
      border-radius: 12px;
      background: #ffffff;
      box-shadow: 0 16px 30px rgba(6, 20, 47, 0.06);
      text-align: left;
   }

   .pricing-benefits__note-icon {
      width: 72px;
      height: 72px;
      display: inline-grid;
      place-items: center;
      flex: 0 0 auto;
      border-radius: 50%;
      color: #b21f17;
      background: #f7e1df;
      font-size: 34px;
      line-height: 1;
   }

   .pricing-benefits__note-icon i {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      line-height: 1;
   }

   .pricing-benefits__note-content {
      min-width: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
   }

   .pricing-benefits__note strong {
      display: block;
      margin-bottom: 2px;
      color: var(--pricing-navy);
      font-size: 23px;
      font-weight: 900;
      line-height: 1.15;
   }

   .pricing-benefits__note p {
      margin: 0;
      color: var(--pricing-muted);
      font-size: 18px;
      font-weight: 600;
      line-height: 1.35;
   }

   @media (max-width: 991px) {
      .pricing-goal-page {
         min-height: auto;
         padding: 70px 16px;
      }

      .pricing-goal__card {
         padding: 24px 20px;
      }

      .pricing-goal__row {
         grid-template-columns: 1fr 1fr;
         gap: 16px;
      }

      .pricing-goal__label {
         grid-column: 1 / -1;
      }

      .pricing-goal__presets {
         grid-template-columns: repeat(2, minmax(0, 1fr));
         gap: 12px;
      }

      .pricing-goal__result {
         grid-template-columns: 1fr;
         gap: 30px;
         padding: 34px 28px;
      }

      .pricing-goal__result::before,
      .pricing-goal__result::after {
         display: none;
      }

      .pricing-goal__breakup-title {
         text-align: left;
      }

      .pricing-benefits__cards {
         grid-template-columns: 1fr;
         gap: 22px;
      }

      .pricing-benefits__decor {
         display: none;
      }
   }

   @media (max-width: 575px) {
      .pricing-goal-page {
         padding: 52px 12px;
      }

      .pricing-goal__title {
         font-size: 28px;
      }

      .pricing-goal__card {
         border-radius: 14px;
         padding: 20px 14px;
      }

      .pricing-goal__label {
         gap: 12px;
         font-size: 17px;
      }

      .pricing-goal__icon {
         width: 48px;
         height: 48px;
         font-size: 22px;
      }

      .pricing-goal__currency,
      .pricing-goal__input {
         min-height: 50px;
         font-size: 17px;
      }

      .pricing-goal__presets {
         grid-template-columns: 1fr;
      }

      .pricing-goal__button {
         min-height: 58px;
         font-size: 20px;
         gap: 12px;
      }

      .pricing-goal__result {
         padding: 28px 18px;
      }

      .pricing-goal__breakup-row {
         grid-template-columns: 1fr;
         gap: 6px;
         margin-top: 18px;
      }

      .pricing-benefits {
         padding: 56px 12px;
      }

      .pricing-benefits__switch {
         grid-template-columns: 1fr;
         border-radius: 24px;
      }

      .pricing-benefits__tab {
         min-height: 56px;
         border-radius: 18px;
         font-size: 18px;
      }

      .pricing-benefits__heading {
         grid-template-columns: 1fr;
         gap: 10px;
      }

      .pricing-benefits__heading::before,
      .pricing-benefits__heading::after {
         display: none;
      }

      .pricing-benefit-card {
         min-height: auto;
         padding: 30px 22px 52px;
      }

      .pricing-benefit-card__icon {
         width: 90px;
         height: 90px;
         margin-bottom: 18px;
         font-size: 38px;
      }

      .pricing-benefit-card p {
         font-size: 16px;
      }

      .pricing-benefits__note {
         flex-direction: column;
         align-items: flex-start;
         padding: 22px;
      }

      .pricing-benefits__note-content {
         width: 100%;
      }

      .pricing-benefits__note p {
         font-size: 16px;
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
         <li class="breadcrumb-item active" aria-current="page">
            Pricing
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

<main class="pricing-goal-page">
   <section class="pricing-goal" data-goal-calculator>
      <h1 class="pricing-goal__title">Fundraiser goal calculator</h1>
      <div class="pricing-goal__ornament" aria-hidden="true">
         <i class="fa-regular fa-heart"></i>
      </div>
      <p class="pricing-goal__subtitle">A simple way to plan and achieve your fundraiser goal</p>

      <div class="pricing-goal__card">
         <div class="pricing-goal__row">
            <div class="pricing-goal__label">
               <span class="pricing-goal__icon"><i class="fa-solid fa-wallet"></i></span>
               <span>I want to raise</span>
            </div>
            <div class="pricing-goal__currency" aria-label="Currency">
               <span>&#8377;</span>
               <span>INR</span>
            </div>
            <input class="pricing-goal__input" type="text" value="1,00,000" inputmode="numeric" aria-label="Fundraiser goal amount" data-goal-input>
         </div>

         <div class="pricing-goal__range">
            <input type="range" min="10000" max="250000" step="1000" value="100000" data-goal-range aria-label="Goal amount range">
         </div>

         <div class="pricing-goal__presets">
            <button class="pricing-goal__preset" type="button" data-goal-preset="10000">&#8377; 10,000</button>
            <button class="pricing-goal__preset" type="button" data-goal-preset="25000">&#8377; 25,000</button>
            <button class="pricing-goal__preset" type="button" data-goal-preset="50000">&#8377; 50,000</button>
            <button class="pricing-goal__preset is-active" type="button" data-goal-preset="100000">&#8377; 1,00,000</button>
            <button class="pricing-goal__preset" type="button" data-goal-preset="250000">&#8377; 2,50,000</button>
         </div>
      </div>

      <button type="button" class="pricing-goal__button" data-goal-calculate>
         <i class="fa-solid fa-calculator"></i>
         <span data-goal-button-text>Calculate Goal</span>
      </button>

      <div class="pricing-goal__result" data-goal-result aria-live="polite">
         <div class="pricing-goal__result-main">
            <p>Consider setting a goal of approx.</p>
            <div class="pricing-goal__total" data-goal-total>&#8377;1,02,322.73</div>
            <div class="pricing-goal__disclaimer">
               Disclaimer: This goal is the approximate amount you should consider setting where we assume that you would receive 70% of the total funds from INR contributions.
            </div>
         </div>
         <div class="pricing-goal__breakup">
            <p class="pricing-goal__breakup-title">See breakup</p>
            <div class="pricing-goal__breakup-row">
               <span>Want to raise (&#8377;) :</span>
               <strong data-goal-want>1,00,000</strong>
            </div>
            <div class="pricing-goal__breakup-row">
               <span>Karna Kabach platform fee (&#8377;) :</span>
               <strong data-goal-platform-fee>0</strong>
            </div>
            <div class="pricing-goal__breakup-row">
               <span>Payment gateway charges (&#8377;) :</span>
               <strong data-goal-gateway-fee>2,322.73</strong>
            </div>
         </div>
      </div>
   </section>
</main>

<script>
   document.addEventListener('DOMContentLoaded', () => {
      const calculators = document.querySelectorAll('[data-goal-calculator]');

      const formatIndianAmount = (value) => {
         const number = Number(String(value).replace(/[^\d]/g, '')) || 0;
         return number.toLocaleString('en-IN');
      };

      calculators.forEach((calculator) => {
         const amountInput = calculator.querySelector('[data-goal-input]');
         const rangeInput = calculator.querySelector('[data-goal-range]');
         const presets = calculator.querySelectorAll('[data-goal-preset]');
         const calculateButton = calculator.querySelector('[data-goal-calculate]');
         const calculateButtonText = calculator.querySelector('[data-goal-button-text]');
         const result = calculator.querySelector('[data-goal-result]');
         const totalOutput = calculator.querySelector('[data-goal-total]');
         const wantOutput = calculator.querySelector('[data-goal-want]');
         const platformFeeOutput = calculator.querySelector('[data-goal-platform-fee]');
         const gatewayFeeOutput = calculator.querySelector('[data-goal-gateway-fee]');
         let lastCalculatedAmount = null;

         if (!amountInput || !rangeInput) {
            return;
         }

         const syncRangeFill = () => {
            const min = Number(rangeInput.min);
            const max = Number(rangeInput.max);
            const value = Number(rangeInput.value);
            const progress = ((value - min) / (max - min)) * 100;
            rangeInput.style.setProperty('--range-progress', `${progress}%`);
         };

         const setAmount = (value) => {
            const amount = Number(String(value).replace(/[^\d]/g, '')) || Number(rangeInput.min);
            const clamped = Math.min(Number(rangeInput.max), Math.max(Number(rangeInput.min), amount));
            amountInput.value = formatIndianAmount(clamped);
            rangeInput.value = clamped;
            syncRangeFill();

            presets.forEach((preset) => {
               preset.classList.toggle('is-active', Number(preset.dataset.goalPreset) === clamped);
            });

            if (result?.classList.contains('is-visible') && lastCalculatedAmount !== null && clamped !== lastCalculatedAmount && calculateButtonText) {
               calculateButtonText.textContent = 'Re-calculate';
            }
         };

         const formatDecimalAmount = (value) => Number(value).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
         });

         const showResult = () => {
            const amount = Number(String(amountInput.value).replace(/[^\d]/g, '')) || Number(rangeInput.min);
            const platformFee = 0;
            const gatewayFee = amount * 0.0232273;
            const total = amount + platformFee + gatewayFee;
            lastCalculatedAmount = amount;

            if (totalOutput) {
               totalOutput.textContent = `\u20b9${formatDecimalAmount(total)}`;
            }

            if (wantOutput) {
               wantOutput.textContent = formatIndianAmount(amount);
            }

            if (platformFeeOutput) {
               platformFeeOutput.textContent = formatIndianAmount(platformFee);
            }

            if (gatewayFeeOutput) {
               gatewayFeeOutput.textContent = formatDecimalAmount(gatewayFee);
            }

            if (result) {
               result.classList.add('is-visible');
               result.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            if (calculateButtonText) {
               calculateButtonText.textContent = 'Calculate Goal';
            }
         };

         rangeInput.addEventListener('input', () => setAmount(rangeInput.value));
         amountInput.addEventListener('input', () => setAmount(amountInput.value));
         calculateButton?.addEventListener('click', showResult);

         presets.forEach((preset) => {
            preset.addEventListener('click', () => setAmount(preset.dataset.goalPreset));
         });

         setAmount(rangeInput.value);
      });

      document.querySelectorAll('.pricing-benefits').forEach((benefits) => {
         const tabs = benefits.querySelectorAll('[data-benefits-tab]');
         const panels = benefits.querySelectorAll('[data-benefits-panel]');
         let isAnimating = false;

         tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
               const targetName = tab.dataset.benefitsTab;
               const activePanel = benefits.querySelector('[data-benefits-panel].is-active');
               const targetPanel = benefits.querySelector(`[data-benefits-panel="${targetName}"]`);

               if (!targetPanel || targetPanel === activePanel || isAnimating) {
                  return;
               }

               isAnimating = true;

               tabs.forEach((item) => {
                  const isActive = item === tab;
                  item.classList.toggle('is-active', isActive);
                  item.setAttribute('aria-pressed', isActive ? 'true' : 'false');
               });

               activePanel?.classList.add('is-leaving');

               window.setTimeout(() => {
                  activePanel?.classList.remove('is-active', 'is-leaving');
                  targetPanel.classList.add('is-active');
               }, 240);

               window.setTimeout(() => {
                  isAnimating = false;
               }, 640);
            });
         });
      });
   });
</script>

<section class="pricing-benefits">
   <span class="pricing-benefits__decor pricing-benefits__decor--dots-left" aria-hidden="true"></span>
   <span class="pricing-benefits__decor pricing-benefits__decor--dots-right" aria-hidden="true"></span>
   <span class="pricing-benefits__decor pricing-benefits__decor--heart" aria-hidden="true"><i class="fa-regular fa-heart"></i></span>
   <span class="pricing-benefits__decor pricing-benefits__decor--plane" aria-hidden="true"><i class="fa-regular fa-paper-plane"></i></span>

   <div class="pricing-benefits__inner">
      <h2 class="pricing-benefits__title">Make a Difference in a Way That <span>Feels Right for You</span></h2>
      <p class="pricing-benefits__subtitle">
         Whether you want to raise funds for a cause close to your heart or contribute to someone else's fundraiser, every action counts.
      </p>

      <div class="pricing-benefits__switch" aria-label="Fundraiser and donate options">
         <button class="pricing-benefits__tab is-active" type="button" data-benefits-tab="fundraiser" aria-pressed="true">
            <i class="fa-solid fa-hand-holding-heart"></i>
            <span>Fundraiser</span>
         </button>
         <button class="pricing-benefits__tab" type="button" data-benefits-tab="donor" aria-pressed="false">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <span>Donate</span>
         </button>
      </div>

      <div class="pricing-benefits__panel is-active" data-benefits-panel="fundraiser">
         <h3 class="pricing-benefits__heading">Benefits as a Fundraiser</h3>

         <div class="pricing-benefits__cards">
            <article class="pricing-benefit-card pricing-benefit-card--impact">
               <span class="pricing-benefit-card__icon"><i class="fa-solid fa-people-group"></i></span>
               <h3>Create Impact</h3>
               <p>Start a fundraiser for a cause you care about and make a real difference in people's lives.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>

            <article class="pricing-benefit-card pricing-benefit-card--story">
               <span class="pricing-benefit-card__icon"><i class="fa-solid fa-bullhorn"></i></span>
               <h3>Share Your Story</h3>
               <p>Raise awareness by sharing your story and inspire others to join and support your mission.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>

            <article class="pricing-benefit-card pricing-benefit-card--raise">
               <span class="pricing-benefit-card__icon"><i class="fa-regular fa-wallet"></i></span>
               <h3>Raise More, Stress Less</h3>
               <p>Enjoy 0% platform fees and keep more of what you raise for the cause that matters most.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>
         </div>

         <div class="pricing-benefits__note">
            <span class="pricing-benefits__note-icon"><i class="fa-solid fa-shield-halved"></i></span>
            <div class="pricing-benefits__note-content">
               <strong>Secure. Simple. Supportive.</strong>
               <p>Our platform is built to help you raise funds securely and reach more people with ease.</p>
            </div>
         </div>
      </div>

      <div class="pricing-benefits__panel" data-benefits-panel="donor">
         <h3 class="pricing-benefits__heading">Benefits as a Donor</h3>

         <div class="pricing-benefits__cards">
            <article class="pricing-benefit-card pricing-benefit-card--impact">
               <span class="pricing-benefit-card__icon"><i class="fa-regular fa-heart"></i></span>
               <h3>Create Real Impact</h3>
               <p>Your contribution helps bring hope and real change to people who need it most.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>

            <article class="pricing-benefit-card pricing-benefit-card--trust">
               <span class="pricing-benefit-card__icon"><i class="fa-solid fa-shield-halved"></i></span>
               <h3>Trust &amp; Transparency</h3>
               <p>We ensure every donation reaches the right cause with complete transparency.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>

            <article class="pricing-benefit-card pricing-benefit-card--raise">
               <span class="pricing-benefit-card__icon"><i class="fa-solid fa-people-group"></i></span>
               <h3>Be Part of Something Bigger</h3>
               <p>Join a community of kind hearts working together to build a better tomorrow.</p>
               <span class="pricing-benefit-card__line"></span>
            </article>
         </div>

         <div class="pricing-benefits__note">
            <span class="pricing-benefits__note-icon"><i class="fa-solid fa-shield-halved"></i></span>
            <div class="pricing-benefits__note-content">
               <strong>Safe. Secure. Meaningful.</strong>
               <p>Your donation is protected and makes a difference where it matters most.</p>
            </div>
         </div>
      </div>
   </div>
</section>

<x-footer>
</x-footer>
