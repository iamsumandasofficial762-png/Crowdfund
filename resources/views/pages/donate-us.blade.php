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
   $supporters = $supporters ?? collect();
   $supporterCount = $supporterCount ?? 0;
   $topSupporterNames = $topSupporters->pluck('donor_name')->filter()->take(10)->join(', ');
   $storyUpdates = $selectedPost?->publishedUpdates ?? collect();
@endphp

<style>
   :root {
      --donate-navy: #001b3f;
      --donate-ink: #0b2240;
      --donate-muted: #475569;
      --donate-orange: #f59e0b;
      --donate-orange-soft: #fff2d6;
      --donate-brick: #a83220;
      --donate-brick-dark: #8f2619;
      --donate-cream: #fff8ed;
      --donate-line: #d4deea;
      --donate-soft: #f6f8fb;
   }

   .story-tabs {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 34px 0 24px;
      border-bottom: 1px solid #eee0ca;
   }

   .story-tabs__button {
      min-height: 46px;
      border: 0;
      border-bottom: 3px solid transparent;
      padding: 10px 16px;
      color: #62594e;
      background: transparent;
      font-weight: 900;
      cursor: pointer;
   }

   .story-tabs__button.is-active {
      color: #111111;
      border-color: #ffb33f;
   }

   .story-tab-panel {
      display: none;
   }

   .story-tab-panel.is-active {
      display: block;
   }

   .public-updates {
      display: grid;
      gap: 18px;
   }

   .public-update-card {
      border: 1px solid #eee0ca;
      border-radius: 16px;
      padding: clamp(18px, 3vw, 24px);
      background: #ffffff;
      box-shadow: 0 18px 40px rgba(24, 17, 8, 0.07);
   }

   .public-update-card__meta {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 12px;
      color: #7a6f63;
      font-weight: 800;
      font-size: 14px;
   }

   .public-update-card__meta span {
      display: inline-flex;
      align-items: center;
      gap: 7px;
   }

   .public-update-card__pin {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      border-radius: 999px;
      padding: 6px 10px;
      color: #ffffff;
      background: #111111;
      font-size: 12px;
      font-weight: 900;
      text-transform: uppercase;
   }

   .public-update-card h4 {
      margin-bottom: 10px;
      color: #111111;
      font-weight: 900;
   }

   .public-update-card p {
      line-height: 1.75;
   }

   .public-update-card__image {
      width: 100%;
      max-height: 420px;
      object-fit: cover;
      border-radius: 14px;
      margin: 8px 0 18px;
   }

   .public-update-card__share {
      border: 1px solid rgba(255, 179, 63, 0.65);
      border-radius: 999px;
      padding: 8px 14px;
      color: #111111;
      background: #fff8ec;
      font-weight: 900;
   }

   .public-empty-state,
   .public-document-card {
      border: 1px dashed #ead8bd;
      border-radius: 16px;
      padding: 24px;
      background: #fffaf2;
   }

   .campaign-people {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px;
      margin: 28px 0 18px;
   }

   .campaign-person-card {
      min-height: 86px;
      border: 1px solid #e6e2dc;
      border-radius: 6px;
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 16px;
      background: #ffffff;
      box-shadow: 0 8px 22px rgba(24, 17, 8, 0.04);
   }

   .campaign-person-card__avatar {
      width: 50px;
      height: 50px;
      flex: 0 0 auto;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #a32a58;
      background: #ead6de;
      font-weight: 900;
      text-transform: lowercase;
   }

   .campaign-person-card__body {
      min-width: 0;
   }

   .campaign-person-card__eyebrow {
      display: block;
      margin-bottom: 4px;
      color: #6d6871;
      font-size: 13px;
      line-height: 1.25;
   }

   .campaign-person-card__name {
      margin: 0;
      color: #151217;
      font-size: 15px;
      line-height: 1.35;
      font-weight: 800;
   }

   .campaign-person-card__location {
      margin: 2px 0 0;
      color: #9a949d;
      font-size: 14px;
      line-height: 1.35;
   }

   .story-trust-section {
      display: grid;
      gap: 34px;
      margin-top: 54px;
   }

   .story-info-card {
      border: 1px solid #f0ccd6;
      border-radius: 10px;
      padding: clamp(20px, 3vw, 28px);
      background: #fffdfb;
      box-shadow: 0 10px 24px rgba(121, 34, 70, 0.08);
   }

   .story-section-title {
      margin-bottom: 14px;
      color: #a32a58;
      font-weight: 900;
      text-align: center;
   }

   .story-title-rule {
      width: 100%;
      height: 2px;
      margin: 0 0 12px;
      background: #a32a58;
   }

   .cost-breakup__note {
      margin-bottom: 8px;
      color: #615a66;
      text-align: center;
      font-weight: 700;
   }

   .cost-row {
      min-height: 44px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      border: 1px solid #f0ccd6;
      border-radius: 6px;
      padding: 11px 14px;
      color: #45404c;
      background: #ffffff;
      font-weight: 800;
   }

   .cost-row + .cost-row {
      margin-top: 14px;
   }

   .cost-row strong {
      white-space: nowrap;
   }

   .cost-row--available {
      border-color: #2ab9a7;
      background: #eaf9f7;
   }

   .practice-list {
      display: grid;
      gap: 8px;
      margin-top: 20px;
   }

   .practice-item {
      border: 1px solid #f0ccd6;
      border-radius: 6px;
      padding: 10px 12px;
      background: #ffffff;
   }

   .practice-item strong {
      display: block;
      margin-bottom: 4px;
      color: #a32a58;
      font-weight: 900;
   }

   .practice-item p {
      margin: 0;
      color: #15233b;
      line-height: 1.45;
   }

   .practice-link,
   .supporters-link,
   .story-help-link {
      color: #7b0f3b;
      font-weight: 800;
      text-decoration: underline;
   }

   .supporter-toggle {
      border: 0;
      padding: 0;
      background: transparent;
      cursor: pointer;
   }

   .supporters-panel {
      border-radius: 8px;
      padding: clamp(18px, 3vw, 28px);
      background: #fff5f9;
   }

   .supporters-heading {
      text-align: center;
      margin-bottom: 22px;
   }

   .supporters-heading h4 {
      margin-bottom: 14px;
      color: #14111a;
      font-weight: 900;
   }

   .supporters-ornament {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 18px;
      color: #a32a58;
   }

   .supporters-ornament::before,
   .supporters-ornament::after {
      content: "";
      width: min(120px, 24vw);
      height: 1px;
      background: #b8aab1;
   }

   .supporters-ornament span {
      width: 17px;
      height: 17px;
      display: inline-block;
      background: #a32a58;
      transform: rotate(45deg);
   }

   .supporters-help {
      margin: 0 0 18px;
      padding: 12px 18px;
      background: #fff0e9;
      color: #1c1720;
      font-weight: 700;
   }

   .supporter-list {
      display: grid;
      gap: 0;
   }

   .supporter-row {
      display: grid;
      grid-template-columns: 48px minmax(0, 1fr) auto;
      align-items: center;
      gap: 16px;
      padding: 14px 0;
      border-bottom: 1px solid #e9cbd6;
   }

   .supporter-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #a32a58;
      background: #ead6de;
      font-weight: 900;
      text-transform: uppercase;
   }

   .supporter-name {
      margin: 0 0 3px;
      color: #5f5b64;
      font-weight: 800;
   }

   .supporter-amount {
      margin: 0;
      color: #111111;
      font-weight: 900;
   }

   .supporter-date {
      color: #8d858f;
      font-size: 13px;
      font-weight: 700;
      white-space: nowrap;
   }

   .story-simple-card {
      min-height: 112px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border-radius: 14px;
      padding: clamp(22px, 4vw, 28px);
      background: #ffffff;
      box-shadow: 0 10px 28px rgba(24, 17, 8, 0.09);
      text-align: center;
   }

   .story-disclaimer {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 168px;
      border: 1px solid #a32a58;
      border-radius: 10px;
      padding: clamp(18px, 3vw, 24px);
      text-align: center;
      box-shadow: 0 10px 26px rgba(121, 34, 70, 0.08);
   }

   .story-info-card,
   .supporters-panel,
   .story-disclaimer,
   .story-simple-card {
      width: 100%;
      max-width: 100%;
      margin: 0;
   }

   .story-disclaimer h4,
   .story-simple-card h4 {
      margin-bottom: 8px;
      color: #45404c;
      font-weight: 900;
   }

   .story-disclaimer p {
      max-width: 760px;
      margin-inline: auto;
   }

   .story-simple-card .btn--secondary {
      min-width: min(260px, 100%);
      justify-content: center;
      margin-top: 14px;
   }

   .refer-modal {
      position: fixed;
      inset: 0;
      z-index: 300;
      display: grid;
      place-items: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.62);
      backdrop-filter: blur(8px);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.2s ease, visibility 0.2s ease;
   }

   .refer-modal.is-open {
      opacity: 1;
      visibility: visible;
   }

   .refer-modal__dialog {
      width: min(94vw, 860px);
      max-height: none;
      overflow-y: visible;
      overflow-x: hidden;
      border: 1px solid rgba(245, 158, 11, 0.28);
      border-radius: 14px;
      background: #ffffff;
      box-shadow: 0 30px 90px rgba(0, 27, 63, 0.32);
      scrollbar-width: none;
   }

   .refer-modal__dialog::-webkit-scrollbar {
      display: none;
   }

   .refer-modal__head {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 16px;
      padding: 26px 34px 18px;
      border-bottom: 1px solid var(--donate-line);
      background: linear-gradient(90deg, #ffffff, var(--donate-cream));
   }

   .refer-modal__head h3 {
      margin: 0 0 12px;
      color: var(--donate-navy);
      font-size: 24px;
      font-weight: 800;
   }

   .refer-modal__head p {
      margin: 0;
      color: var(--donate-ink);
      font-size: 18px;
      font-weight: 700;
   }

   .refer-modal__close {
      width: 34px;
      height: 34px;
      border: 0;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-brick);
      background: transparent;
      font-size: 22px;
   }

   .refer-form {
      padding: 24px 34px 30px;
   }

   .refer-field {
      margin-bottom: 18px;
   }

   .refer-control,
   .refer-select {
      width: 100%;
      max-width: 100%;
      height: 42px;
      border: 0;
      border-bottom: 1px solid #d8d8d8;
      outline: 0;
      padding: 0 34px 0 0;
      color: var(--donate-ink);
      background: transparent;
      font: inherit;
      font-size: 15px;
      min-width: 0;
      box-sizing: border-box;
   }

   .refer-control {
      padding-right: 0;
   }

   .refer-select {
      appearance: none;
      background-image: linear-gradient(45deg, transparent 50%, #7b8794 50%), linear-gradient(135deg, #7b8794 50%, transparent 50%);
      background-position: calc(100% - 13px) 50%, calc(100% - 8px) 50%;
      background-size: 5px 5px, 5px 5px;
      background-repeat: no-repeat;
      cursor: pointer;
   }

   .refer-control:focus,
   .refer-select:focus {
      border-bottom-color: var(--donate-orange);
   }

   .refer-phone-row {
      display: grid;
      grid-template-columns: minmax(88px, 112px) minmax(0, 1fr);
      gap: 24px;
      align-items: end;
      width: 100%;
      min-width: 0;
   }

   .refer-phone-row .refer-select {
      padding-right: 28px;
   }

   .refer-hint {
      margin: 5px 0 0;
      color: #969696;
      font-size: 12px;
      font-weight: 700;
   }

   .refer-submit {
      width: min(100%, 300px);
      min-height: 52px;
      border: 0;
      border-radius: 999px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 20px auto 0;
      color: #ffffff;
      background: var(--donate-brick);
      font: inherit;
      font-size: 18px;
      font-weight: 900;
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.22);
   }

   .refer-alert {
      margin: 0 0 18px;
      border-radius: 8px;
      padding: 12px 14px;
      border: 1px solid #d9efe1;
      color: #116033;
      background: #edf9f1;
      font-weight: 800;
   }

   .refer-alert--error {
      border-color: #f0c6bd;
      color: #9f321f;
      background: #fff7f5;
   }

   [data-auto-dismiss] {
      transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease;
   }

   [data-auto-dismiss].is-hiding {
      opacity: 0;
      transform: translateY(-8px);
      margin-top: 0 !important;
      margin-bottom: 0 !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      border-width: 0 !important;
      overflow: hidden;
   }

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
      position: sticky;
      top: 92px;
      z-index: 20;
   }

   .donation-sticky {
      align-self: flex-start;
      margin-top: 0;
      position: static;
      z-index: auto;
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
         position: static;
      }

      .donation-sticky {
         position: static;
      }
   }

   @media (max-width: 767px) {
      .campaign-people {
         grid-template-columns: 1fr;
      }

      .story-trust-section {
         gap: 22px;
      }

      .refer-phone-row {
         grid-template-columns: minmax(72px, 88px) minmax(0, 1fr);
         gap: 14px;
      }

      .refer-modal {
         padding: 14px;
      }

      .refer-modal__head,
      .refer-form {
         padding-left: 20px;
         padding-right: 20px;
      }

      .cost-row,
      .supporter-row {
         grid-template-columns: 42px minmax(0, 1fr);
      }

      .cost-row {
         display: block;
      }

      .cost-row strong {
         display: block;
         margin-top: 5px;
      }

      .supporter-date {
         grid-column: 2;
      }
   }

   @media (max-height: 760px) {
      .refer-modal {
         align-items: start;
         overflow-y: auto;
      }

      .refer-modal__dialog {
         margin-block: 18px;
      }
   }

   .donate-us {
      color: var(--donate-ink);
      background:
         radial-gradient(circle at 94% 0%, rgba(168, 50, 32, 0.16), transparent 24%),
         linear-gradient(180deg, #ffffff 0%, #fffaf2 55%, #f7f9fc 100%);
   }

   .donate-us h3,
   .donate-us h4,
   .donate-us h5,
   .donation-sticky-card__title,
   .public-update-card h4,
   .supporters-heading h4,
   .campaign-person-card__name,
   .supporter-amount {
      color: var(--donate-navy);
   }

   .donate-us p,
   .donate-us .cm-group p,
   .public-update-card__meta,
   .campaign-person-card__eyebrow,
   .campaign-person-card__location,
   .supporter-name,
   .supporter-date,
   .donation-sticky-card__method,
   .donation-sticky-card__raised p,
   .donation-sticky-card__raised h5,
   .donation-sticky-card__apps p {
      color: var(--donate-muted);
   }

   .story-tabs {
      border-color: var(--donate-line);
   }

   .story-tabs__button {
      color: var(--donate-muted);
   }

   .story-tabs__button.is-active {
      color: #ffffff;
      border-color: var(--donate-brick);
      background: var(--donate-brick);
   }

   .public-update-card,
   .campaign-person-card,
   .story-info-card,
   .story-simple-card,
   .donation-sticky-card,
   .public-document-card {
      border-color: var(--donate-line);
      background: #ffffff;
      box-shadow: 0 18px 40px rgba(0, 27, 63, 0.08);
   }

   .story-section-title,
   .practice-item strong,
   .practice-link,
   .supporters-link,
   .story-help-link,
   .donation-sticky-card__supporters,
   .donation-sticky-card__raised strong,
   .donation-sticky-card__divider span {
      color: var(--donate-brick);
   }

   .story-title-rule,
   .supporters-ornament span {
      background: var(--donate-brick);
   }

   .supporters-panel {
      background: var(--donate-cream);
   }

   .supporters-help,
   .donate-campaign__meta span,
   .cost-row--available {
      background: var(--donate-orange-soft);
      color: var(--donate-navy);
   }

   .supporter-row,
   .practice-item,
   .cost-row {
      border-color: #efd2c5;
   }

   .campaign-person-card__avatar,
   .supporter-avatar {
      color: var(--donate-brick);
      background: #f4dfd2;
   }

   .donate-campaign__progress {
      background: var(--donate-soft);
   }

   .donate-campaign__numbers span {
      color: var(--donate-orange);
   }

   .donate-campaign__bar {
      background: #e2e8f0;
   }

   .donate-campaign__bar span {
      background: var(--donate-navy);
   }

   .donation-sticky-card {
      border-color: rgba(245, 158, 11, 0.45);
      box-shadow: 0 22px 55px rgba(168, 50, 32, 0.13);
   }

   .donation-sticky-card__title i,
   .donation-sticky-card__supporters,
   .donation-supporter-row strong {
      color: var(--donate-brick);
   }

   .donation-ring {
      color: var(--donate-navy);
      background: conic-gradient(var(--donate-orange) calc(var(--progress) * 1%), #e2e8f0 0);
   }

   .donation-sticky-card__button,
   .donation-sticky-card__button:hover {
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.22);
   }

   .donation-sticky-card__button:hover {
      background: var(--donate-brick-dark);
   }

   .donation-sticky-card__divider::before,
   .donation-sticky-card__divider::after {
      background: rgba(245, 158, 11, 0.35);
   }

   .donation-qr {
      border-color: rgba(245, 158, 11, 0.62);
      background: var(--donate-cream);
   }

   .donation-qr__button {
      border-color: var(--donate-brick);
      color: var(--donate-brick);
   }

   .donation-qr__button:hover {
      color: #ffffff;
      background: var(--donate-brick);
   }

   .donation-sticky-card__apps {
      border-color: rgba(245, 158, 11, 0.28);
      background: #fffaf2;
   }

   .public-update-card__share {
      border-color: rgba(245, 158, 11, 0.65);
      color: var(--donate-navy);
      background: var(--donate-orange-soft);
   }

   .public-update-card__pin,
   .pinned-badge {
      background: var(--donate-navy);
   }

   .donate-us .btn--secondary {
      border-color: var(--donate-brick);
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 16px 32px rgba(168, 50, 32, 0.18);
   }

   .donate-us .btn--secondary::before,
   .donate-us .btn--secondary::after {
      background: var(--donate-brick-dark);
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
                  @if (session('status'))
                     <div class="refer-alert" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                  @endif

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

                     <div class="campaign-people" aria-label="Campaign people">
                        @php
                           $creatorName = $selectedPost->fundraiser?->name ?: 'Fundraiser';
                           $creatorInitial = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::substr($creatorName, 0, 1));
                           $beneficiaryName = $selectedPost->beneficiary_name ?: 'Beneficiary';
                           $beneficiaryInitial = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::substr($beneficiaryName, 0, 2));
                        @endphp

                        <article class="campaign-person-card">
                           <span class="campaign-person-card__avatar">{{ $creatorInitial }}</span>
                           <div class="campaign-person-card__body">
                              <span class="campaign-person-card__eyebrow">Created by</span>
                              <p class="campaign-person-card__name">{{ $creatorName }}</p>
                           </div>
                        </article>

                        <article class="campaign-person-card">
                           <span class="campaign-person-card__avatar">{{ $beneficiaryInitial }}</span>
                           <div class="campaign-person-card__body">
                              <span class="campaign-person-card__eyebrow">This fundraiser will benefit</span>
                              <p class="campaign-person-card__name">{{ $beneficiaryName }}</p>
                              @if ($selectedPost->location)
                                 <p class="campaign-person-card__location">from {{ $selectedPost->location }}</p>
                              @endif
                           </div>
                        </article>
                     </div>

                     <div class="story-tabs" role="tablist" aria-label="Fundraiser story sections">
                        <button class="story-tabs__button is-active" type="button" role="tab" aria-selected="true" data-story-tab="story">Story</button>
                        <button class="story-tabs__button" type="button" role="tab" aria-selected="false" data-story-tab="updates">Updates ({{ $storyUpdates->count() }})</button>
                        <button class="story-tabs__button" type="button" role="tab" aria-selected="false" data-story-tab="documents">Documents</button>
                     </div>

                     <div class="story-tab-panel is-active" data-story-panel="story">
                        <div class="cm-group">
                           <h4>About This Fundraiser</h4>
                           <p>{!! nl2br(e($selectedPost->full_description)) !!}</p>
                        </div>

                        @php
                           $gatewayFees = 0;
                           $availableForBeneficiary = max($raisedAmount - $gatewayFees, 0);
                           $supporterRows = $supporters->isNotEmpty() ? $supporters : $topSupporters;
                           $supporterPreview = $supporterRows->take(4);
                           $hiddenSupporters = $supporterRows->skip(4);
                        @endphp

                        <div class="story-trust-section">
                           <section class="story-info-card" aria-labelledby="cost-breakup-title">
                              <h4 class="story-section-title" id="cost-breakup-title">Cost Breakup</h4>
                              <p class="cost-breakup__note">Karna Kabach is a free platform, no fees charged for fundraising</p>
                              <div class="story-title-rule" aria-hidden="true"></div>

                              <div class="cost-row">
                                 <span>Funds raised (A)</span>
                                 <strong>Rs. {{ number_format($raisedAmount, 2) }}</strong>
                              </div>
                              <div class="cost-row">
                                 <span>Payment gateway fees (B)</span>
                                 <strong>Rs. {{ number_format($gatewayFees, 2) }}</strong>
                              </div>
                              <div class="cost-row cost-row--available">
                                 <span>Available for beneficiary (A - B)</span>
                                 <strong>Rs. {{ number_format($availableForBeneficiary, 2) }}</strong>
                              </div>
                           </section>

                           <section class="supporters-panel" id="supporters" aria-labelledby="supporters-title">
                              <div class="supporters-heading">
                                 <h4 id="supporters-title">Supporters</h4>
                                 <div class="supporters-ornament" aria-hidden="true"><span></span></div>
                              </div>

                              <p class="supporters-help">
                                 <a class="supporters-link" href="{{ route('contact-us') }}">Click here</a>
                                 if you are not able to find your donation listed below.
                              </p>

                              <div class="supporter-list">
                                 @forelse ($supporterPreview as $supporter)
                                    @php
                                       $supporterName = $supporter->donor_name ?: 'Anonymous';
                                       $supporterInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($supporterName, 0, 1));
                                       $supporterDate = optional($supporter->paid_at ?? $supporter->created_at)->format('d M Y');
                                    @endphp
                                    <article class="supporter-row">
                                       <span class="supporter-avatar">{{ $supporterInitial }}</span>
                                       <div>
                                          <p class="supporter-name">{{ $supporterName }}</p>
                                          <p class="supporter-amount">Rs. {{ number_format((float) $supporter->amount, 0) }}</p>
                                       </div>
                                       @if ($supporterDate)
                                          <span class="supporter-date">{{ $supporterDate }}</span>
                                       @endif
                                    </article>
                                 @empty
                                    <div class="public-empty-state">
                                       <h4>No supporters yet</h4>
                                       <p class="mb-0">Be the first supporter for this fundraiser.</p>
                                    </div>
                                 @endforelse

                                 @foreach ($hiddenSupporters as $supporter)
                                    @php
                                       $supporterName = $supporter->donor_name ?: 'Anonymous';
                                       $supporterInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($supporterName, 0, 1));
                                       $supporterDate = optional($supporter->paid_at ?? $supporter->created_at)->format('d M Y');
                                    @endphp
                                    <article class="supporter-row d-none" data-supporter-extra>
                                       <span class="supporter-avatar">{{ $supporterInitial }}</span>
                                       <div>
                                          <p class="supporter-name">{{ $supporterName }}</p>
                                          <p class="supporter-amount">Rs. {{ number_format((float) $supporter->amount, 0) }}</p>
                                       </div>
                                       @if ($supporterDate)
                                          <span class="supporter-date">{{ $supporterDate }}</span>
                                       @endif
                                    </article>
                                 @endforeach
                              </div>

                              @if ($hiddenSupporters->isNotEmpty())
                                 <div class="text-center mt-4">
                                    <button class="supporters-link supporter-toggle" type="button" data-supporter-toggle>View all supporters</button>
                                 </div>
                              @endif
                           </section>

                           <section class="story-disclaimer">
                              <h4>Disclaimer</h4>
                              <p class="mb-0">In alignment with child protection and privacy guidelines, Karna Kabach does not mandate public disclosure of the name or photograph of any individual below 18 years of age on fundraiser pages. Any such disclosures are made voluntarily by the parent or legal guardian.</p>
                           </section>

                           <section class="story-simple-card">
                              <p class="mb-2">Know someone in need of funds?</p>
                              <button type="button" class="btn--secondary" data-text="Refer to us" data-refer-open><span>Refer to us</span></button>
                           </section>

                           <section class="story-simple-card">
                              <p class="mb-2">If something is not right, we will work with you to ensure no misuse occurs.</p>
                              <a class="story-help-link" href="{{ route('contact-us') }}">Report this cause</a>
                           </section>

                           <section class="story-simple-card">
                              <p class="mb-2">Have a question or need assistance?</p>
                              <a class="story-help-link" href="{{ route('contact-us') }}">Contact Us</a>
                           </section>
                        </div>
                     </div>

                     <div class="story-tab-panel" data-story-panel="updates">
                        <div class="public-updates">
                           @forelse ($storyUpdates as $update)
                              <article class="public-update-card">
                                 <div class="public-update-card__meta">
                                    <span><i class="fa-regular fa-calendar"></i>{{ $update->created_at->format('d M Y') }}</span>
                                    <span><i class="fa-regular fa-clock"></i>{{ $update->created_at->diffForHumans() }}</span>
                                    @if ($update->is_pinned)
                                       <span class="public-update-card__pin"><i class="fa-solid fa-thumbtack"></i>Pinned</span>
                                    @endif
                                 </div>
                                 <h4>{{ $update->title ?: 'Campaign update' }}</h4>
                                 <p>{!! nl2br(e($update->update_text)) !!}</p>
                                 @if ($update->update_image)
                                    <img class="public-update-card__image" src="{{ asset('storage/' . $update->update_image) }}" alt="{{ $update->title ?: 'Campaign update image' }}">
                                 @endif
                                 <button class="public-update-card__share" type="button" data-public-share="{{ route('donate-us', $selectedPost) }}">
                                    <i class="fa-solid fa-share-nodes"></i> Share update
                                 </button>
                              </article>
                           @empty
                              <div class="public-empty-state">
                                 <h4>No updates posted yet</h4>
                                 <p class="mb-0">The fundraiser has not shared campaign updates yet. Please check back soon.</p>
                              </div>
                           @endforelse
                        </div>
                     </div>

                     <div class="story-tab-panel" data-story-panel="documents">
                        <div class="public-document-card">
                           <h4>Campaign Documents</h4>
                           @if ($selectedPost->supporting_file)
                              <p>Review the supporting document uploaded for this fundraiser.</p>
                              <a href="{{ asset('storage/' . $selectedPost->supporting_file) }}" target="_blank" rel="noopener" class="btn--secondary" data-text="View Document"><span>View Document</span></a>
                           @else
                              <p class="mb-0">No public supporting document has been uploaded for this fundraiser.</p>
                           @endif
                        </div>
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

@if ($selectedPost)
   <div class="refer-modal {{ $errors->any() ? 'is-open' : '' }}" data-refer-modal aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">
      <section class="refer-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="referModalTitle">
         <div class="refer-modal__head">
            <div>
               <h3 id="referModalTitle">Raise funds online with Karna Kabach</h3>
               <p>Fill in the details and our team will connect shortly</p>
            </div>
            <button class="refer-modal__close" type="button" data-refer-close aria-label="Close referral form">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>

         <form class="refer-form" action="{{ route('fundraiser-referrals.store', $selectedPost) }}" method="post">
            @csrf

            @if ($errors->any())
               <div class="refer-alert refer-alert--error" role="alert">
                  <ul class="mb-0 ps-3">
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
            @endif

            <div class="refer-field">
               <input class="refer-control" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required>
            </div>

            <div class="refer-field">
               <div class="refer-phone-row">
                  <select class="refer-select" name="country_code" aria-label="Country code">
                     <option value="+91" @selected(old('country_code', '+91') === '+91')>+91</option>
                     <option value="+1" @selected(old('country_code') === '+1')>+1</option>
                     <option value="+44" @selected(old('country_code') === '+44')>+44</option>
                     <option value="+971" @selected(old('country_code') === '+971')>+971</option>
                  </select>
                  <input class="refer-control" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required>
               </div>
               <p class="refer-hint">Our team will contact on this number</p>
            </div>

            <div class="refer-field">
               <select class="refer-select" name="reason" required>
                  <option value="">Reason for raising funds</option>
                  @foreach (['Medical treatment', 'Education support', 'Emergency relief', 'Community support', 'Other'] as $reason)
                     <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                  @endforeach
               </select>
            </div>

            <div class="refer-field">
               <select class="refer-select" name="estimated_cost" required>
                  <option value="">Estimated cost</option>
                  @foreach (['Below Rs. 50,000', 'Rs. 50,000 - Rs. 1,00,000', 'Rs. 1,00,000 - Rs. 5,00,000', 'Above Rs. 5,00,000', 'Not sure yet'] as $cost)
                     <option value="{{ $cost }}" @selected(old('estimated_cost') === $cost)>{{ $cost }}</option>
                  @endforeach
               </select>
            </div>

            <div class="refer-field">
               <select class="refer-select" name="preferred_language" required>
                  <option value="">Preferred language</option>
                  @foreach (['English', 'Hindi', 'Bengali', 'Telugu', 'Tamil', 'Kannada', 'Malayalam', 'Marathi', 'Gujarati'] as $language)
                     <option value="{{ $language }}" @selected(old('preferred_language') === $language)>{{ $language }}</option>
                  @endforeach
               </select>
            </div>

            <div class="refer-field">
               <div class="refer-phone-row">
                  <select class="refer-select" name="alternate_country_code" aria-label="Alternate country code">
                     <option value="+91" @selected(old('alternate_country_code', '+91') === '+91')>+91</option>
                     <option value="+1" @selected(old('alternate_country_code') === '+1')>+1</option>
                     <option value="+44" @selected(old('alternate_country_code') === '+44')>+44</option>
                     <option value="+971" @selected(old('alternate_country_code') === '+971')>+971</option>
                  </select>
                  <input class="refer-control" type="tel" name="alternate_phone" value="{{ old('alternate_phone') }}" placeholder="Alternate Phone Number">
               </div>
            </div>

            <button class="refer-submit" type="submit">Submit</button>
         </form>
      </section>
   </div>
@endif

<script>
   document.addEventListener('DOMContentLoaded', () => {
      const referModal = document.querySelector('[data-refer-modal]');
      const referOpenButtons = document.querySelectorAll('[data-refer-open]');
      const referCloseButton = document.querySelector('[data-refer-close]');

      const openReferModal = () => {
         if (!referModal) {
            return;
         }

         referModal.classList.add('is-open');
         referModal.setAttribute('aria-hidden', 'false');
         referModal.querySelector('input, select, button')?.focus();
      };

      const closeReferModal = () => {
         if (!referModal) {
            return;
         }

         referModal.classList.remove('is-open');
         referModal.setAttribute('aria-hidden', 'true');
      };

      referOpenButtons.forEach((button) => {
         button.addEventListener('click', openReferModal);
      });

      referCloseButton?.addEventListener('click', closeReferModal);
      referModal?.addEventListener('click', (event) => {
         if (event.target === referModal) {
            closeReferModal();
         }
      });

      document.addEventListener('keydown', (event) => {
         if (event.key === 'Escape' && referModal?.classList.contains('is-open')) {
            closeReferModal();
         }
      });

      document.querySelectorAll('[data-auto-dismiss]').forEach((alert) => {
         const delay = Number(alert.dataset.autoDismiss) || 3500;

         window.setTimeout(() => {
            alert.classList.add('is-hiding');
            window.setTimeout(() => alert.remove(), 400);
         }, delay);
      });

      const tabButtons = document.querySelectorAll('[data-story-tab]');
      const tabPanels = document.querySelectorAll('[data-story-panel]');

      tabButtons.forEach((button) => {
         button.addEventListener('click', () => {
            tabButtons.forEach((item) => {
               item.classList.toggle('is-active', item === button);
               item.setAttribute('aria-selected', item === button ? 'true' : 'false');
            });

            tabPanels.forEach((panel) => {
               panel.classList.toggle('is-active', panel.dataset.storyPanel === button.dataset.storyTab);
            });
         });
      });

      document.querySelectorAll('[data-public-share]').forEach((button) => {
         button.addEventListener('click', async () => {
            const url = button.dataset.publicShare;

            if (navigator.share) {
               await navigator.share({ title: document.title, url });
               return;
            }

            await navigator.clipboard.writeText(url);
            button.textContent = 'Link copied';
         });
      });

      const supporterToggle = document.querySelector('[data-supporter-toggle]');
      supporterToggle?.addEventListener('click', () => {
         document.querySelectorAll('[data-supporter-extra]').forEach((row) => {
            row.classList.remove('d-none');
         });

         supporterToggle.remove();
      });

      const canvas = document.getElementById('donationQrCanvas');
      const button = document.querySelector('.donation-qr__button');

      if (!canvas || !button) {
         return;
      }

      const context = canvas.getContext('2d');
      const cells = 25;
      const cellSize = canvas.width / cells;

      const drawFinder = (x, y) => {
         context.fillStyle = '#001b3f';
         context.fillRect(x * cellSize, y * cellSize, 7 * cellSize, 7 * cellSize);
         context.fillStyle = '#fff8ed';
         context.fillRect((x + 1) * cellSize, (y + 1) * cellSize, 5 * cellSize, 5 * cellSize);
         context.fillStyle = '#001b3f';
         context.fillRect((x + 2) * cellSize, (y + 2) * cellSize, 3 * cellSize, 3 * cellSize);
      };

      const isFinderArea = (x, y) => {
         return (x < 8 && y < 8) || (x > 16 && y < 8) || (x < 8 && y > 16);
      };

      const generateQr = () => {
         context.fillStyle = '#fff8ed';
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
                  context.fillStyle = Math.random() > 0.16 ? '#001b3f' : '#f59e0b';
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
