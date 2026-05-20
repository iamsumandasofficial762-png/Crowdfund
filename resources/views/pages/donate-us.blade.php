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
   $pendingDonationAmount = (float) ($pendingDonationAmount ?? 0);
   $shouldOpenDonationModal = (bool) ($shouldOpenDonationModal ?? false) || $errors->donation->any();
   $donationModalAmount = old('amount', $pendingDonationAmount > 0 ? number_format($pendingDonationAmount, 0) : '2,500');
   $topSupporterNames = $topSupporters->map(fn ($supporter) => $supporter->publicDonorName())->filter()->take(10)->join(', ');
   $storyUpdates = $selectedPost?->publishedUpdates ?? collect();
@endphp

<style>
   :root {
      --donate-navy: #001b3f;
      --donate-ink: #0b2240;
      --donate-muted: #475569;
      --donate-orange: #932a19;
      --donate-orange-soft: #f7e1df;
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
      border-color: #932a19;
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
      border: 1px solid rgba(147, 42, 25, 0.65);
      border-radius: 999px;
      min-height: 40px;
      box-sizing: border-box;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 8px 14px;
      color: #111111;
      background: #fff8ec;
      font: inherit;
      line-height: 1;
      font-weight: 900;
      transform: none !important;
      transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
      will-change: auto;
   }

   .public-update-card__share::before,
   .public-update-card__share::after {
      display: none !important;
      content: none !important;
   }

   .public-update-card__share:hover,
   .public-update-card__share:focus {
      transform: none !important;
      border-color: var(--donate-brick);
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 8px 18px rgba(168, 50, 32, 0.16);
   }

   .public-empty-state,
   .public-document-card {
      border: 1px dashed #ead8bd;
      border-radius: 16px;
      padding: 24px;
      background: #fffaf2;
   }

   .campaign-documents {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 14px;
      margin-top: 18px;
   }

   .campaign-document {
      min-height: 104px;
      border: 1px solid rgba(168, 50, 32, 0.22);
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px;
      color: var(--donate-navy);
      background: linear-gradient(135deg, #fffaf9 0%, #fff4f1 100%);
      box-shadow: 0 10px 22px rgba(168, 50, 32, 0.08);
      text-align: left;
      font: inherit;
      font-weight: 800;
   }

   .campaign-document:hover,
   .campaign-document:focus {
      border-color: var(--donate-brick);
      color: var(--donate-brick);
      transform: none;
   }

   .campaign-document__icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      background: var(--donate-brick);
      flex: 0 0 auto;
   }

   .campaign-document__meta {
      min-width: 0;
   }

   .campaign-document__name {
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }

   .campaign-document__type {
      display: block;
      margin-top: 4px;
      color: var(--donate-muted);
      font-size: 13px;
      font-weight: 700;
   }

   .document-preview-modal {
      position: fixed;
      inset: 0;
      z-index: 360;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.68);
      backdrop-filter: blur(8px);
   }

   .document-preview-modal.is-open {
      display: flex;
   }

   .document-preview-modal__dialog {
      width: min(94vw, 980px);
      height: min(86vh, 760px);
      border-radius: 10px;
      overflow: hidden;
      background: #ffffff;
      box-shadow: 0 34px 95px rgba(0, 0, 0, 0.46);
   }

   .document-preview-modal__head {
      min-height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 14px 18px;
      border-bottom: 1px solid rgba(168, 50, 32, 0.18);
   }

   .document-preview-modal__head h3 {
      margin: 0;
      color: var(--donate-navy);
      font-size: 18px;
      font-weight: 900;
   }

   .document-preview-modal__close {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-brick);
      background: #fff4f1;
      font-size: 18px;
   }

   .document-preview-modal__body {
      height: calc(100% - 62px);
      background: #f8fafc;
   }

   .document-preview-modal__frame,
   .document-preview-modal__image {
      width: 100%;
      height: 100%;
      border: 0;
      display: block;
   }

   .document-preview-modal__image {
      object-fit: contain;
      padding: 18px;
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
      text-transform: uppercase;
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
      border-color: rgba(168, 50, 32, 0.28);
      background: linear-gradient(135deg, #fff7f5 0%, #f4dfd2 100%);
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

   .supporters-modal {
      position: fixed;
      inset: 0;
      z-index: 340;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.68);
      backdrop-filter: blur(4px);
   }

   .supporters-modal.is-open {
      display: flex;
   }

   .supporters-modal__dialog {
      width: min(94vw, 730px);
      max-height: min(86vh, 720px);
      display: grid;
      grid-template-rows: auto minmax(0, 1fr) auto;
      overflow: hidden;
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 34px 95px rgba(0, 0, 0, 0.38);
   }

   .supporters-modal__head {
      min-height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 18px 24px;
      border-bottom: 1px solid #e5e7eb;
   }

   .supporters-modal__title {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin: 0;
      color: #222831;
      font-size: 21px;
      font-weight: 800;
   }

   .supporters-modal__title i {
      color: var(--donate-brick);
   }

   .supporters-modal__close {
      width: 36px;
      height: 36px;
      border: 0;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-brick);
      background: transparent;
      font-size: 22px;
      cursor: pointer;
   }

   .supporters-modal__body {
      overflow-y: auto;
      padding: 20px 32px 0;
   }

   .supporters-modal__body .supporters-help {
      margin-bottom: 10px;
   }

   .supporters-modal__footer {
      padding: 20px 24px 18px;
      border-top: 1px solid #e5e7eb;
      background: #ffffff;
      text-align: center;
   }

   .supporters-modal__donate {
      width: min(100%, 300px);
      min-height: 52px;
      border: 0;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 16px 32px rgba(168, 50, 32, 0.2);
      font: inherit;
      font-size: 17px;
      font-weight: 900;
      cursor: pointer;
   }

   .supporters-modal__donate:hover {
      color: #ffffff;
      background: var(--donate-brick-dark);
   }

   .payment-details-modal {
      position: fixed;
      inset: 0;
      z-index: 350;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.62);
      backdrop-filter: blur(4px);
   }

   .payment-details-modal.is-open {
      display: flex;
   }

   .payment-details-modal__dialog {
      width: min(94vw, 500px);
      max-height: min(88vh, 640px);
      overflow-y: auto;
      border: 1px solid rgba(168, 50, 32, 0.18);
      border-radius: 10px;
      background: linear-gradient(135deg, #fffaf9 0%, #fff4f1 100%);
      box-shadow: 0 34px 95px rgba(0, 27, 63, 0.28);
      position: relative;
   }

   .payment-details-modal__close {
      width: 36px;
      height: 36px;
      border: 0;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      top: 16px;
      right: 16px;
      color: var(--donate-brick);
      background: #ffffff;
      font-size: 18px;
      cursor: pointer;
      box-shadow: 0 8px 18px rgba(168, 50, 32, 0.12);
   }

   .payment-details-form {
      padding: 34px;
   }

   .payment-details-form h3 {
      display: block;
      margin: 0 46px 12px 0;
      padding-bottom: 14px;
      border-bottom: 2px solid var(--donate-brick);
      color: var(--donate-navy);
      font-size: 22px;
      font-weight: 900;
   }

   .payment-details-form__note {
      margin: 0 0 26px;
      padding: 14px 16px;
      border: 1px solid rgba(168, 50, 32, 0.14);
      border-radius: 6px;
      color: var(--donate-muted);
      background: rgba(255, 255, 255, 0.72);
      line-height: 1.6;
      font-weight: 700;
   }

   .payment-details-form__field {
      display: grid;
      gap: 8px;
      margin-bottom: 22px;
   }

   .payment-details-form__field label {
      color: var(--donate-navy);
      font-size: 14px;
      font-weight: 800;
   }

   .payment-details-form__field input,
   .payment-details-form__field select {
      width: 100%;
      height: 42px;
      border: 1px solid rgba(168, 50, 32, 0.22);
      border-radius: 6px;
      outline: 0;
      padding: 0 12px;
      color: var(--donate-ink);
      background: #ffffff;
      font: inherit;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
   }

   .payment-details-form__field input:focus,
   .payment-details-form__field select:focus {
      border-color: var(--donate-brick);
      box-shadow: 0 0 0 4px rgba(168, 50, 32, 0.12);
   }

   .payment-details-form__amount {
      display: grid;
      grid-template-columns: 44px minmax(0, 1fr);
   }

   .payment-details-form__amount span {
      min-height: 42px;
      border: 1px solid rgba(168, 50, 32, 0.22);
      border-right: 0;
      border-radius: 6px 0 0 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: var(--donate-cream);
      color: var(--donate-brick);
      font-weight: 900;
   }

   .payment-details-form__amount input {
      border-left: 0;
      border-radius: 0 6px 6px 0;
   }

   .payment-details-form__submit {
      width: 100%;
      min-height: 44px;
      border: 0;
      border-radius: 999px;
      justify-content: center;
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.22);
      font: inherit;
      font-size: 16px;
      font-weight: 900;
      cursor: pointer;
   }

   .payment-details-form__submit:hover {
      color: #ffffff;
      background: var(--donate-brick-dark);
   }

   .report-modal {
      position: fixed;
      inset: 0;
      z-index: 350;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.64);
      backdrop-filter: blur(5px);
   }

   .report-modal.is-open {
      display: flex;
   }

   .report-modal__dialog {
      width: min(94vw, 640px);
      max-height: min(90vh, 720px);
      overflow-y: auto;
      border: 1px solid rgba(168, 50, 32, 0.18);
      border-radius: 10px;
      background: linear-gradient(135deg, #fffaf9 0%, #fff4f1 100%);
      box-shadow: 0 34px 95px rgba(0, 27, 63, 0.3);
   }

   .report-modal__head {
      min-height: 68px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      padding: 18px 24px;
      border-bottom: 1px solid rgba(168, 50, 32, 0.18);
      background: #ffffff;
   }

   .report-modal__head h3 {
      margin: 0;
      color: var(--donate-navy);
      font-size: 22px;
      font-weight: 900;
   }

   .report-modal__close {
      width: 36px;
      height: 36px;
      border: 0;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-brick);
      background: #fff4f1;
      font-size: 18px;
      cursor: pointer;
   }

   .report-form {
      display: grid;
      gap: 18px;
      padding: 26px 24px 28px;
   }

   .report-form__field {
      display: grid;
      gap: 6px;
   }

   .report-form__control {
      width: 100%;
      min-height: 42px;
      border: 0;
      border-bottom: 1px solid rgba(168, 50, 32, 0.28);
      outline: 0;
      padding: 8px 0;
      color: var(--donate-navy);
      background: transparent;
      font: inherit;
      font-weight: 700;
   }

   .report-form__control:focus {
      border-bottom-color: var(--donate-brick);
   }

   textarea.report-form__control {
      min-height: 118px;
      border: 1px solid rgba(168, 50, 32, 0.28);
      border-radius: 8px;
      padding: 12px 14px;
      background: #ffffff;
      resize: vertical;
      line-height: 1.5;
   }

   textarea.report-form__control:focus {
      border-color: var(--donate-brick);
      box-shadow: 0 0 0 3px rgba(168, 50, 32, 0.1);
   }

   .report-form__phone {
      display: grid;
      grid-template-columns: 88px minmax(0, 1fr);
      gap: 12px;
      align-items: end;
   }

   .report-form__hint {
      margin: 0;
      color: var(--donate-muted);
      font-size: 13px;
      line-height: 1.45;
      font-weight: 700;
   }

   .report-form__upload {
      min-height: 44px;
      border: 1px solid var(--donate-brick);
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      justify-self: center;
      min-width: 170px;
      padding: 0 22px;
      color: var(--donate-brick);
      background: #ffffff;
      font-weight: 900;
      cursor: pointer;
      box-shadow: 0 10px 22px rgba(168, 50, 32, 0.12);
   }

   .report-form__upload input {
      position: absolute;
      width: 1px;
      height: 1px;
      overflow: hidden;
      opacity: 0;
   }

   .report-form__file-name {
      display: block;
      margin-top: 10px;
      color: var(--donate-brick);
      font-size: 13px;
      line-height: 1.35;
      font-weight: 800;
      text-align: center;
      word-break: break-word;
   }

   .report-form__submit {
      width: min(100%, 300px);
      min-height: 50px;
      border: 0;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      justify-self: center;
      margin-top: 4px;
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 16px 32px rgba(168, 50, 32, 0.22);
      font: inherit;
      font-size: 17px;
      font-weight: 900;
      cursor: pointer;
   }

   .report-form__submit:hover {
      color: #ffffff;
      background: var(--donate-brick-dark);
   }

   .supporters-panel {
      border: 1px solid rgba(168, 50, 32, 0.18);
      border-radius: 8px;
      padding: clamp(18px, 3vw, 28px);
      background: linear-gradient(135deg, #fffaf9 0%, #fff4f1 100%);
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
      border: 1px solid rgba(168, 50, 32, 0.12);
      background: linear-gradient(135deg, #fff7f5 0%, #f4dfd2 100%);
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
      border-bottom: 1px solid rgba(168, 50, 32, 0.18);
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

   .donation-modal {
      position: fixed;
      inset: 0;
      z-index: 320;
      display: grid;
      align-items: center;
      justify-items: center;
      padding: 24px;
      background: rgba(0, 0, 0, 0.66);
      backdrop-filter: blur(8px);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.22s ease, visibility 0.22s ease;
   }

   .donation-modal.is-open {
      opacity: 1;
      visibility: visible;
   }

   .donation-modal__dialog {
      width: min(94vw, 620px);
      max-height: calc(100vh - 48px);
      overflow-y: auto;
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 28px 86px rgba(14, 17, 23, 0.35);
      position: relative;
   }

   .donation-modal__head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      padding: 20px 24px;
      border-bottom: 1px solid #e5e7eb;
   }

   .donation-modal__head h3 {
      margin: 0;
      color: var(--donate-navy);
      font-size: 21px;
      font-weight: 800;
   }

   .donation-modal__close {
      width: 32px;
      height: 32px;
      border: 0;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-brick);
      background: transparent;
      font-size: 23px;
      line-height: 1;
      cursor: pointer;
   }

   .donation-modal__form {
      padding: 16px 24px 24px;
   }

   .donation-modal__amount {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
      gap: 18px;
      align-items: end;
      padding: 16px 18px;
      border-radius: 4px;
      color: #ffffff;
      background: var(--donate-brick);
   }

   .donation-modal__label {
      display: block;
      margin-bottom: 4px;
      font-size: 12px;
      line-height: 1.2;
      font-weight: 700;
      color: rgba(255, 255, 255, 0.86);
   }

   .donation-modal__amount strong {
      display: block;
      color: #ffffff;
      font-size: 16px;
      line-height: 1.3;
      font-weight: 900;
   }

   .donation-modal__amount input {
      width: 100%;
      border: 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.72);
      outline: 0;
      color: #ffffff;
      background: transparent;
      font: inherit;
      font-size: 16px;
      font-weight: 800;
   }

   .donation-modal__amount input::placeholder {
      color: rgba(255, 255, 255, 0.82);
   }

   .donation-modal__note {
      margin: 14px 0 0;
      color: var(--donate-muted);
      font-size: 14px;
      line-height: 1.55;
   }

   .donation-modal__tip {
      display: grid;
      grid-template-columns: minmax(0, 1fr) minmax(180px, 260px);
      align-items: center;
      gap: 14px;
      margin-top: 12px;
      padding: 10px 16px;
      border: 1px solid rgba(245, 158, 11, 0.24);
      background: var(--donate-cream);
      color: var(--donate-ink);
      font-weight: 700;
   }

   .donation-modal__tip-select {
      width: 100%;
      height: 38px;
      border: 0;
      outline: 0;
      color: var(--donate-brick);
      background:
         linear-gradient(45deg, transparent 50%, var(--donate-brick) 50%),
         linear-gradient(135deg, var(--donate-brick) 50%, transparent 50%);
      background-position: calc(100% - 13px) 52%, calc(100% - 8px) 52%;
      background-size: 5px 5px, 5px 5px;
      background-repeat: no-repeat;
      font: inherit;
      font-weight: 900;
      appearance: none;
      cursor: pointer;
   }

   .donation-modal__tip .nice-select.donation-modal__tip-select {
      display: flex;
      align-items: center;
      padding-left: 28px;
      padding-top: 3px;
      line-height: 1.2;
   }

   .donation-modal__tip .nice-select.donation-modal__tip-select .current {
      display: inline-block;
      transform: translateY(1px);
   }

   .donation-modal__section-title {
      margin: 18px 0 12px;
      color: var(--donate-navy);
      font-size: 16px;
      font-weight: 800;
   }

   .donation-modal__methods {
      display: grid;
      gap: 12px;
   }

   .donation-modal__method {
      width: 100%;
      min-height: 44px;
      border: 1px solid #f0dce4;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      color: var(--donate-muted);
      background: #ffffff;
      box-shadow: 0 8px 18px rgba(168, 50, 32, 0.08);
      text-align: left;
      font: inherit;
      font-weight: 700;
      cursor: pointer;
      transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
   }

   .donation-modal__method i {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--donate-orange);
      background: transparent;
      font-size: 14px;
   }

   .donation-modal__method.is-active {
      border-color: var(--donate-brick);
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 12px 24px rgba(168, 50, 32, 0.18);
   }

   .donation-modal__method.is-active i {
      color: var(--donate-brick);
      background: #ffffff;
   }

   .donation-modal__fields {
      display: grid;
      gap: 14px;
      margin-top: 18px;
   }

   .donation-modal__field {
      width: 100%;
      height: 42px;
      border: 0;
      border-bottom: 1px solid #d9d9d9;
      outline: 0;
      color: var(--donate-ink);
      background: transparent;
      font: inherit;
      font-size: 15px;
   }

   .donation-modal__field:focus {
      border-bottom-color: var(--donate-brick);
   }

   .donation-modal__error {
      margin-top: 4px;
      color: #b42318;
      font-size: 13px;
      font-weight: 700;
   }

   .donation-modal__privacy {
      display: inline-flex;
      align-items: center;
      gap: 14px;
      margin-top: 18px;
      color: var(--donate-ink);
      font-weight: 700;
   }

   .donation-modal__privacy input {
      position: absolute;
      opacity: 0;
   }

   .donation-modal__switch {
      width: 38px;
      height: 20px;
      border-radius: 999px;
      background: #9ca3af;
      position: relative;
      flex: 0 0 auto;
      cursor: pointer;
      transition: background 0.2s ease;
   }

   .donation-modal__switch::before {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      left: 0;
      top: 0;
      border-radius: 50%;
      background: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.24);
      transition: transform 0.2s ease;
   }

   .donation-modal__privacy input:checked + .donation-modal__switch {
      background: var(--donate-brick);
   }

   .donation-modal__privacy input:checked + .donation-modal__switch::before {
      transform: translateX(18px);
   }

   .donation-modal__summary {
      display: grid;
      gap: 0;
      margin-top: 20px;
      overflow: hidden;
      border: 1px solid rgba(245, 158, 11, 0.34);
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 12px 26px rgba(0, 27, 63, 0.06);
   }

   .donation-modal__summary-row {
      min-height: 44px;
      display: grid;
      grid-template-columns: minmax(0, 1fr) auto;
      align-items: center;
      gap: 16px;
      padding: 10px 14px;
      color: #637083;
      font-size: 14px;
      line-height: 1.25;
      font-weight: 700;
   }

   .donation-modal__summary-row + .donation-modal__summary-row {
      border-top: 1px solid #edf0f4;
   }

   .donation-modal__summary-row strong {
      color: var(--donate-navy);
      font-size: 15px;
      font-weight: 900;
      text-align: right;
      white-space: nowrap;
   }

   .donation-modal__summary-row--total {
      min-height: 50px;
      color: var(--donate-navy);
      background: var(--donate-cream);
      font-size: 16px;
      font-weight: 900;
   }

   .donation-modal__summary-row--total strong {
      color: var(--donate-brick);
      font-size: 18px;
   }

   .donation-modal__submit {
      width: min(100%, 330px);
      min-height: 52px;
      border: 0;
      border-radius: 999px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 26px auto 0;
      color: #ffffff;
      background: var(--donate-brick);
      font: inherit;
      font-size: 17px;
      font-weight: 900;
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.22);
      cursor: pointer;
   }

   .donation-modal__submit:hover {
      color: #ffffff;
      background: var(--donate-brick-dark);
   }

   .donation-modal__method:hover {
      border: 1px solid var(--donate-brick);
   }

   .donation-modal__method.is-active:hover {
      border: 1px solid var(--donate-brick);
      color: #ffffff;
      background: var(--donate-brick-dark);
   }

   button.btn--secondary[data-donation-open] {
      border: 0;
   }

   .donation-exit {
      position: absolute;
      inset: 0;
      z-index: 2;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 0;
      background: rgba(12, 15, 20, 0.38);
      backdrop-filter: blur(2px);
   }

   .donation-exit.is-open {
      display: flex;
   }

   .donation-exit__card {
      width: 100%;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.82);
      border-radius: 8px;
      background: #ffffff;
      box-shadow: 0 34px 95px rgba(0, 0, 0, 0.46), 0 0 0 1px rgba(168, 50, 32, 0.12);
   }

   .donation-exit__head {
      padding: 20px 24px;
      border-bottom: 1px solid #e5e7eb;
   }

   .donation-exit__head h3 {
      margin: 0;
      color: var(--donate-navy);
      font-size: 21px;
      font-weight: 800;
   }

   .donation-exit__body {
      padding: 44px 24px;
      text-align: center;
   }

   .donation-exit__icon {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 26px;
      color: var(--donate-brick);
      background: #f4e8ed;
      font-size: 42px;
   }

   .donation-exit__body h4 {
      margin: 0 0 18px;
      color: #222831;
      font-size: 20px;
      font-weight: 800;
   }

   .donation-exit__body p {
      margin: 0;
      color: var(--donate-muted);
      font-size: 16px;
      font-weight: 700;
   }

   .donation-exit__actions {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 22px;
      margin-top: 32px;
   }

   .donation-exit__button {
      min-height: 52px;
      border: 1px solid var(--donate-brick);
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 18px;
      background: #ffffff;
      color: var(--donate-brick);
      font: inherit;
      font-size: 16px;
      font-weight: 900;
      cursor: pointer;
      box-shadow: none;
      transform: none;
      transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
   }

   .donation-exit__button--primary {
      color: #ffffff;
      background: var(--donate-brick);
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.18);
   }

   .donation-exit__button:hover,
   .donation-exit__button:focus {
      border-color: var(--donate-brick-dark);
      color: #ffffff;
      background: var(--donate-brick-dark);
      box-shadow: 0 12px 24px rgba(168, 50, 32, 0.18);
      transform: none;
   }

   .donation-exit__button--primary:hover,
   .donation-exit__button--primary:focus {
      border-color: var(--donate-brick-dark);
      color: #ffffff;
      background: var(--donate-brick-dark);
      box-shadow: 0 16px 30px rgba(168, 50, 32, 0.24);
   }

   .donation-exit__secure {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 20px 24px;
      color: var(--donate-muted);
      background: #f6f6f6;
      font-weight: 700;
   }

   .donation-exit__secure i {
      color: var(--donate-brick);
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
      color: var(--donate-navy);
      background: linear-gradient(135deg, #fff7f5 0%, #f4dfd2 100%);
      font-weight: 800;
   }

   .donate-campaign__progress {
      padding: 24px;
      border-radius: 16px;
      background: linear-gradient(135deg, #fff7f5 0%, #f6f8fb 100%);
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
      color: var(--donate-brick);
   }

   .donate-campaign__bar {
      height: 8px;
      border-radius: 999px;
      overflow: hidden;
      background: #eadbd8;
   }

   .donate-campaign__bar span {
      display: block;
      width: 0;
      height: 100%;
      border-radius: inherit;
      background: linear-gradient(90deg, var(--donate-brick) 0%, var(--donate-brick-dark) 100%);
      box-shadow: 0 0 14px rgba(255, 31, 31, 0.75);
      overflow: hidden;
      position: relative;
      animation: donationProgressFill 1.35s 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
   }

   .donate-campaign__bar span::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, transparent 0%, rgba(255, 38, 38, 0.95) 48%, transparent 100%);
      transform: translateX(-100%);
      animation: donationProgressGlow 1.8s ease-in-out infinite;
   }

   @keyframes donationProgressGlow {
      to {
         transform: translateX(100%);
      }
   }

   @keyframes donationProgressFill {
      from {
         width: 0;
      }

      to {
         width: var(--progress-width, 0%);
      }
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
      overflow: visible;
   }

   .donate-us,
   .donate-us .container {
      overflow: visible;
   }

   .donation-sidebar-col {
      align-self: stretch;
      display: flex;
      align-items: flex-start;
      position: relative;
      z-index: 20;
   }

   .donation-sticky {
      align-self: flex-start;
      width: 100%;
      height: max-content;
      margin-top: 0;
      position: sticky !important;
      top: 92px;
      z-index: 30;
      transform: none !important;
      will-change: auto !important;
   }

   .donation-sticky.is-fixed {
      position: fixed !important;
      top: var(--donation-sticky-top, 92px);
      left: var(--donation-sticky-left, auto);
      width: var(--donation-sticky-width, auto);
      z-index: 90;
   }

   .donation-sticky.is-bottom {
      position: absolute !important;
      top: auto;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 30;
   }

   .donation-sticky-card {
      overflow: hidden;
      border-radius: 0;
      color: #1c1712;
      background: #ffffff;
      box-shadow: 0 22px 55px rgba(168, 50, 32, 0.16);
      border: 1px solid rgba(168, 50, 32, 0.36);
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
      color: var(--donate-brick);
   }

   .donation-sticky-card__supporters {
      color: var(--donate-brick);
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
      border: 1px solid rgba(168, 50, 32, 0.28);
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
      border-top: 1px solid #f4ded9;
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
      color: var(--donate-brick);
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
      background: conic-gradient(var(--donate-brick) calc(var(--progress) * 1%), #f1e4e1 0);
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
      color: var(--donate-brick);
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
      color: #ffffff;
      background: var(--donate-brick);
      font-size: 20px;
      font-weight: 900;
      box-shadow: 0 14px 28px rgba(168, 50, 32, 0.24);
      transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
   }

   .donation-sticky-card__button:hover {
      color: #ffffff;
      background: var(--donate-brick-dark);
      transform: translateY(-2px);
      box-shadow: 0 18px 34px rgba(168, 50, 32, 0.32);
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
      background: rgba(168, 50, 32, 0.24);
   }

   .donation-sticky-card__divider span {
      color: var(--donate-brick);
   }

   .donation-qr {
      width: 170px;
      height: 170px;
      margin: 0 auto 14px;
      border: 1px solid rgba(168, 50, 32, 0.42);
      background: #fff7f5;
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
      border: 1px solid var(--donate-brick);
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: var(--donate-brick);
      background: #ffffff;
      font-weight: 800;
      box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
      transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
   }

   .donation-qr__button:hover {
      color: #ffffff;
      background: var(--donate-brick);
      transform: translateX(-50%) translateY(-1px);
   }

   .donation-qr__button.is-hidden {
      display: none;
   }

   .donation-sticky-card__apps {
      padding: 18px 20px 24px;
      border-top: 1px solid rgba(168, 50, 32, 0.22);
      text-align: center;
      background: linear-gradient(180deg, #fffaf9 0%, #fff4f1 100%);
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
         display: block;
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
      .refer-form,
      .donation-modal__head,
      .donation-modal__form {
         padding-left: 20px;
         padding-right: 20px;
      }

      .donation-modal__amount,
      .donation-modal__tip {
         grid-template-columns: 1fr;
         gap: 10px;
      }

      .donation-modal__tip i {
         display: none;
      }

      .donation-exit__body {
         padding: 34px 20px;
      }

      .donation-exit__actions {
         grid-template-columns: 1fr;
         gap: 12px;
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

      .refer-modal__dialog,
      .donation-modal__dialog {
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
      background: linear-gradient(135deg, #fffaf9 0%, #fff4f1 100%);
   }

   .supporters-help,
   .donate-campaign__meta span,
   .cost-row--available {
      background: linear-gradient(135deg, #fff7f5 0%, #f4dfd2 100%);
      color: var(--donate-navy);
   }

   .supporter-row,
   .practice-item,
   .cost-row {
      border-color: rgba(168, 50, 32, 0.22);
   }

   .campaign-person-card__avatar,
   .supporter-avatar {
      color: var(--donate-brick);
      background: #f4dfd2;
   }

   .donate-campaign__progress {
      background: linear-gradient(135deg, #fff7f5 0%, var(--donate-soft) 100%);
   }

   .donate-campaign__numbers span {
      color: var(--donate-brick);
   }

   .donate-campaign__bar {
      background: #eadbd8;
   }

   .donate-campaign__bar span {
      background: linear-gradient(90deg, var(--donate-brick) 0%, var(--donate-brick-dark) 100%);
   }

   .donation-sticky-card {
      border-color: rgba(168, 50, 32, 0.34);
      box-shadow: 0 22px 55px rgba(168, 50, 32, 0.13);
   }

   .donation-sticky-card__title i,
   .donation-sticky-card__supporters,
   .donation-supporter-row strong {
      color: var(--donate-brick);
   }

   .donation-ring {
      color: var(--donate-navy);
      background: conic-gradient(var(--donate-brick) calc(var(--progress) * 1%), #e2e8f0 0);
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
      background: rgba(168, 50, 32, 0.28);
   }

   .donation-qr {
      border-color: rgba(168, 50, 32, 0.42);
      background: #fff7f5;
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
      border-color: rgba(168, 50, 32, 0.22);
      background: linear-gradient(180deg, #fffaf9 0%, #fff4f1 100%);
   }

   .public-update-card__share {
      border-color: rgba(168, 50, 32, 0.32);
      color: var(--donate-navy);
      background: linear-gradient(135deg, #fff7f5 0%, #f4dfd2 100%);
      transform: none !important;
   }

   .public-update-card__share:hover,
   .public-update-card__share:focus {
      border-color: var(--donate-brick);
      color: #ffffff;
      background: var(--donate-brick);
      transform: none !important;
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

   .donation-success-overlay {
      position: fixed;
      inset: 0;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      color: #ffffff;
      background: #2e7d32;
      opacity: 0;
      visibility: hidden;
      transform: scale(1.02);
      transition: opacity 0.28s ease, visibility 0.28s ease, transform 0.28s ease;
   }

   .donation-success-overlay.is-active {
      opacity: 1;
      visibility: visible;
      transform: scale(1);
   }

   .donation-success-card {
      width: min(100%, 420px);
      text-align: center;
      transform: translateY(18px) scale(0.96);
      animation: donationSuccessCard 0.45s ease forwards;
   }

   .donation-success-icon {
      width: 112px;
      height: 112px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 24px;
      color: #2e7d32;
      background: #ffffff;
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.18);
      transform: scale(0.75);
      animation: donationSuccessIcon 0.5s 0.12s cubic-bezier(0.2, 1.3, 0.4, 1) forwards;
   }

   .donation-success-icon i {
      font-size: 54px;
      opacity: 0;
      transform: scale(0.55);
      animation: donationSuccessCheck 0.38s 0.36s ease forwards;
   }

   .donation-success-card h2 {
      margin: 0 0 10px;
      color: #ffffff;
      font-size: clamp(28px, 7vw, 42px);
      line-height: 1.1;
      font-weight: 900;
   }

   .donation-success-card p {
      margin: 0;
      color: rgba(255, 255, 255, 0.88);
      font-size: 16px;
      font-weight: 700;
   }

   body.donation-success-active {
      overflow: hidden;
   }

   @keyframes donationSuccessCard {
      to {
         transform: translateY(0) scale(1);
      }
   }

   @keyframes donationSuccessIcon {
      to {
         transform: scale(1);
      }
   }

   @keyframes donationSuccessCheck {
      to {
         opacity: 1;
         transform: scale(1);
      }
   }
</style>
@include('partials.upload-ui')

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
                           <span data-progress-bar style="--progress-width: {{ $progress }}%"></span>
                        </div>
                        <div class="donate-campaign__numbers">
                           <p>Raised: <span>Rs. {{ number_format($raisedAmount, 0) }}</span></p>
                           <p>Goal: <span>Rs. {{ number_format($goalAmount, 0) }}</span></p>
                        </div>
                     </div>

                     <div class="campaign-people" aria-label="Campaign people">
                        @php
                           $creatorName = $selectedPost->fundraiser?->name ?: 'Fundraiser';
                           $creatorInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($creatorName, 0, 1));
                           $beneficiaryName = $selectedPost->beneficiary_name ?: 'Beneficiary';
                           $beneficiaryInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($beneficiaryName, 0, 2));
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
                                 <button class="supporters-link supporter-toggle" type="button" data-payment-details-open>Click here</button>
                                 if you are not able to find your donation listed below.
                              </p>

                              <div class="supporter-list">
                                 @forelse ($supporterPreview as $supporter)
                                    @php
                                       $supporterName = $supporter->publicDonorName();
                                       $supporterAmount = (float) ($supporter->main_amount ?: $supporter->amount);
                                       $supporterInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($supporterName, 0, 1));
                                       $supporterDate = optional($supporter->paid_at ?? $supporter->created_at)->format('d M Y');
                                    @endphp
                                    <article class="supporter-row">
                                       <span class="supporter-avatar">{{ $supporterInitial }}</span>
                                       <div>
                                          <p class="supporter-name">{{ $supporterName }}</p>
                                          <p class="supporter-amount">Rs. {{ number_format($supporterAmount, 0) }}</p>
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

                              </div>

                              @if ($hiddenSupporters->isNotEmpty())
                                 <div class="text-center mt-4">
                                    <button class="supporters-link supporter-toggle" type="button" data-supporters-open>View all supporters</button>
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
                              <button class="story-help-link supporter-toggle" type="button" data-report-open>Report this cause</button>
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
                                    <img class="public-update-card__image" src="{{ asset('storage/' . $update->update_image) }}" alt="{{ $update->title ?: 'Campaign update image' }}" loading="lazy" decoding="async">
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
                              @php
                                 $rawDocuments = $selectedPost->supporting_file;
                                 $decodedDocuments = json_decode($rawDocuments, true);
                                 $documentPaths = is_array($decodedDocuments)
                                    ? $decodedDocuments
                                    : preg_split('/\s*[,|]\s*/', $rawDocuments, -1, PREG_SPLIT_NO_EMPTY);
                              @endphp
                              <p>Click a supporting document to preview it.</p>
                              <div class="campaign-documents">
                                 @foreach ($documentPaths as $index => $documentPath)
                                    @php
                                       $documentPath = is_array($documentPath) ? ($documentPath['path'] ?? '') : $documentPath;
                                       $documentUrl = asset('storage/' . ltrim($documentPath, '/'));
                                       $documentName = basename($documentPath);
                                       $documentExtension = \Illuminate\Support\Str::lower(pathinfo($documentName, PATHINFO_EXTENSION));
                                       $isImageDocument = in_array($documentExtension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                                    @endphp

                                    @if ($documentPath)
                                       <button
                                          class="campaign-document"
                                          type="button"
                                          data-document-open
                                          data-document-url="{{ $documentUrl }}"
                                          data-document-title="{{ $documentName ?: 'Document ' . ($index + 1) }}"
                                          data-document-type="{{ $isImageDocument ? 'image' : 'frame' }}">
                                          <span class="campaign-document__icon">
                                             <i class="fa-solid {{ $isImageDocument ? 'fa-image' : 'fa-file-lines' }}" aria-hidden="true"></i>
                                          </span>
                                          <span class="campaign-document__meta">
                                             <span class="campaign-document__name">{{ $documentName ?: 'Document ' . ($index + 1) }}</span>
                                             <span class="campaign-document__type">{{ $documentExtension ? strtoupper($documentExtension) : 'Document' }}</span>
                                          </span>
                                       </button>
                                    @endif
                                 @endforeach
                              </div>
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
                                 <button type="button" aria-label="donate us" title="donate us"
                                    class="btn--secondary" data-text="Donate Now" data-donation-open><span>Donate Now</span></button>
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
                                    @php
                                       $supporterAmount = (float) ($supporter->main_amount ?: $supporter->amount);
                                    @endphp
                                    <div class="donation-supporter-row">
                                       <span>{{ $supporter->publicDonorName() }}</span>
                                       <strong>Rs. {{ number_format($supporterAmount, 0) }}</strong>
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
                     <button type="button" class="donation-sticky-card__button" data-donation-open>Donate now</button>
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
   <div class="donation-modal {{ $shouldOpenDonationModal ? 'is-open' : '' }}" data-donation-modal aria-hidden="{{ $shouldOpenDonationModal ? 'false' : 'true' }}">
      <section class="donation-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="donationModalTitle">
         <div class="donation-modal__head">
            <h3 id="donationModalTitle">Make a secure donation</h3>
            <button class="donation-modal__close" type="button" data-donation-close aria-label="Close donation form">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>

         <form class="donation-modal__form" action="{{ route('donations.store', $selectedPost) }}" method="post" data-donation-form>
            @csrf
            <input type="hidden" name="tip_amount" value="400" data-donation-tip-amount>
            <input type="hidden" name="total_amount" value="2900" data-donation-total-amount>
            <input type="hidden" name="payment_method" value="card" data-donation-payment-method>

            <div class="donation-modal__amount">
               <div>
                  <span class="donation-modal__label">Currency</span>
                  <strong>Rs INR</strong>
               </div>
               <label>
                  <span class="donation-modal__label">Amount</span>
                  <input type="text" name="amount" value="{{ $donationModalAmount }}" inputmode="numeric" aria-label="Donation amount" data-donation-amount>
               </label>
            </div>

            <p class="donation-modal__note">
               Karna Kabach charges NO fees. We rely on donors like you to cover for our expenses. Kindly consider a tip. Thank you.
            </p>

            <div class="donation-modal__tip">
               <label for="donationTipPercent">Include a tip of</label>
               <select class="donation-modal__tip-select" id="donationTipPercent" name="tip_percent" data-donation-tip>
                  <option value="10">10% (Rs 250.00)</option>
                  <option value="12">12% (Rs 300.00)</option>
                  <option value="14">14% (Rs 350.00)</option>
                  <option value="16" selected>16% (Rs 400.00)</option>
                  <option value="0">No tip</option>
                  <option value="other">Other</option>
               </select>
            </div>

            <h4 class="donation-modal__section-title">Donate using</h4>
            <div class="donation-modal__methods" role="tablist" aria-label="Donation payment method">
               <button class="donation-modal__method is-active" type="button" role="tab" aria-selected="true" data-donation-method="card">
                  <i class="fa-solid fa-check" aria-hidden="true"></i>
                  <span>Netbanking, Credit/Debit Cards & more</span>
               </button>

               <button class="donation-modal__method" type="button" role="tab" aria-selected="false" data-donation-method="qr">
                  <i class="fa-solid fa-qrcode" aria-hidden="true"></i>
                  <span>Scan and pay via QR code</span>
               </button>
            </div>

            <div class="donation-modal__fields">
               <div>
                  <input class="donation-modal__field" type="text" name="name" value="{{ old('name') }}" placeholder="Name" aria-label="Name" required data-donation-name>
                  @error('name', 'donation')
                     <p class="donation-modal__error">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <input class="donation-modal__field" type="text" name="contact" value="{{ old('contact') }}" placeholder="Mobile number/Email ID" aria-label="Mobile number or email ID" required data-donation-contact>
                  @error('contact', 'donation')
                     <p class="donation-modal__error">{{ $message }}</p>
                  @enderror
                  @error('amount', 'donation')
                     <p class="donation-modal__error">{{ $message }}</p>
                  @enderror
               </div>
            </div>

            <label class="donation-modal__privacy">
               <span>Keep my details private</span>
               <input type="checkbox" name="private" value="1" @checked(old('private'))>
               <span class="donation-modal__switch" aria-hidden="true"></span>
            </label>

            <div class="donation-modal__summary" aria-label="Donation total summary">
               <div class="donation-modal__summary-row">
                  <span>Main amount</span>
                  <strong data-donation-summary-amount>Rs 2,500</strong>
               </div>
               <div class="donation-modal__summary-row">
                  <span>Tip amount</span>
                  <strong data-donation-summary-tip>16% (Rs 400)</strong>
               </div>
               <div class="donation-modal__summary-row donation-modal__summary-row--total">
                  <span>Total amount</span>
                  <strong data-donation-summary-total>Rs 2,900</strong>
               </div>
            </div>

            <button class="donation-modal__submit" type="submit" data-donation-total>Continue to pay Rs 2,900</button>
         </form>

         <div class="donation-exit" data-donation-exit aria-hidden="true">
            <section class="donation-exit__card" role="dialog" aria-modal="true" aria-labelledby="donationExitTitle">
               <div class="donation-exit__head">
                  <h3>Make a secure donation</h3>
               </div>
               <div class="donation-exit__body">
                  <div class="donation-exit__icon" aria-hidden="true">
                     <i class="fa-solid fa-hand-holding-heart"></i>
                  </div>
                  <h4 id="donationExitTitle">Are you sure you want to leave?</h4>
                  <p>Your contribution can make a real difference.</p>
                  <div class="donation-exit__actions">
                     <button class="donation-exit__button donation-exit__button--primary" type="button" data-donation-continue>
                        Continue Donation
                     </button>
                     <button class="donation-exit__button" type="button" data-donation-confirm-close>
                        Maybe Later
                     </button>
                  </div>
               </div>
               <div class="donation-exit__secure">
                  <i class="fa-solid fa-shield-heart" aria-hidden="true"></i>
                  <span>Your donation is secure with Karna Kabach</span>
               </div>
            </section>
         </div>
      </section>
   </div>

   @if ($supporterRows->isNotEmpty())
      <div class="supporters-modal" data-supporters-modal aria-hidden="true">
         <section class="supporters-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="supportersModalTitle">
            <div class="supporters-modal__head">
               <h3 class="supporters-modal__title" id="supportersModalTitle">
                  <i class="fa-solid fa-hand-holding-heart" aria-hidden="true"></i>
                  {{ number_format($supporterCount) }} {{ $supporterCount === 1 ? 'supporter' : 'supporters' }}
               </h3>
               <button class="supporters-modal__close" type="button" data-supporters-close aria-label="Close supporters list">
                  <i class="fa-solid fa-xmark"></i>
               </button>
            </div>

            <div class="supporters-modal__body">
               <p class="supporters-help">
                  <button class="supporters-link supporter-toggle" type="button" data-payment-details-open>Click here</button>
                  if you are not able to find your donation listed below.
               </p>

               <div class="supporter-list">
                  @foreach ($supporterRows as $supporter)
                     @php
                        $supporterName = $supporter->publicDonorName();
                        $supporterAmount = (float) ($supporter->main_amount ?: $supporter->amount);
                        $supporterInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($supporterName, 0, 1));
                        $supporterDate = optional($supporter->paid_at ?? $supporter->created_at)->format('d M Y');
                     @endphp
                     <article class="supporter-row">
                        <span class="supporter-avatar">{{ $supporterInitial }}</span>
                        <div>
                           <p class="supporter-name">{{ $supporterName }}</p>
                           <p class="supporter-amount">Rs. {{ number_format($supporterAmount, 0) }}</p>
                        </div>
                        @if ($supporterDate)
                           <span class="supporter-date">{{ $supporterDate }}</span>
                        @endif
                     </article>
                  @endforeach
               </div>
            </div>

            <div class="supporters-modal__footer">
               <button class="supporters-modal__donate" type="button" data-supporters-donate>Donate now</button>
            </div>
         </section>
      </div>
   @endif

   <div class="payment-details-modal" data-payment-details-modal aria-hidden="true">
      <section class="payment-details-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="paymentDetailsTitle">
         <button class="payment-details-modal__close" type="button" data-payment-details-close aria-label="Close payment details">
            <i class="fa-solid fa-xmark"></i>
         </button>

         <form class="payment-details-form" action="{{ route('coming-soon', ['menu' => 'payment-details']) }}" method="get">
            <h3 id="paymentDetailsTitle">Payment details</h3>
            <p class="payment-details-form__note">
               If you have paid via UPI, PayTM QR code/button or bank transfer, please provide the details to receive payment acknowledgement, and updates on the campaign
            </p>

            <div class="payment-details-form__field">
               <label for="paymentMode">Payment mode</label>
               <select id="paymentMode" name="payment_mode">
                  <option value="qr_code">QR code</option>
                  <option value="upi">UPI</option>
                  <option value="paytm">PayTM</option>
                  <option value="bank_transfer">Bank transfer</option>
               </select>
            </div>

            <div class="payment-details-form__field">
               <label for="walletTransactionId">Wallet transaction ID</label>
               <input id="walletTransactionId" type="text" name="transaction_id">
            </div>

            <div class="payment-details-form__field">
               <label for="paymentDonationAmount">Donation amount</label>
               <div class="payment-details-form__amount">
                  <span>Rs.</span>
                  <input id="paymentDonationAmount" type="text" name="donation_amount" inputmode="numeric" placeholder="Enter amount">
               </div>
            </div>

            <button class="payment-details-form__submit" type="submit">Confirm</button>
         </form>
      </section>
   </div>

   <div class="report-modal" data-report-modal aria-hidden="true">
      <section class="report-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="reportModalTitle">
         <div class="report-modal__head">
            <h3 id="reportModalTitle">Report fundraiser</h3>
            <button class="report-modal__close" type="button" data-report-close aria-label="Close report form">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>

         <form class="report-form" action="{{ route('fundraiser-reports.store', $selectedPost) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="report-form__field">
               <input class="report-form__control" type="text" name="name" value="{{ old('name') }}" placeholder="Name" aria-label="Name">
            </div>

            <div class="report-form__field">
               <input class="report-form__control" type="email" name="email" value="{{ old('email') }}" placeholder="Email id" aria-label="Email id">
            </div>

            <div class="report-form__field">
               <div class="report-form__phone">
                  <select class="report-form__control" name="country_code" aria-label="Country code">
                     <option value="+91" @selected(old('country_code', '+91') === '+91')>+91</option>
                     <option value="+1" @selected(old('country_code') === '+1')>+1</option>
                     <option value="+44" @selected(old('country_code') === '+44')>+44</option>
                     <option value="+971" @selected(old('country_code') === '+971')>+971</option>
                  </select>
                  <input class="report-form__control" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone number" aria-label="Phone number">
               </div>
               <p class="report-form__hint">Our team will verify your claim via this number; please ensure it is correct.</p>
            </div>

            <div class="report-form__field">
               <textarea class="report-form__control" name="message" rows="5" placeholder="Write your report message..." aria-label="Message">{{ old('message') }}</textarea>
            </div>

            <div class="report-form__field">
               <span class="report-form__hint">Supporting Documents</span>
               <label class="upload-box" for="supporting_document">
                  <input id="supporting_document" type="file" name="supporting_document" accept=".pdf,.jpg,.jpeg,.png,.webp" data-report-file>
                  <span class="upload-icon"><i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i></span>
                  <span class="upload-title">Upload documents</span>
                  <span class="upload-help">PDF, JPG, PNG, or WEBP</span>
                  <span class="upload-selected" data-file-label data-report-file-name>No file chosen</span>
               </label>
            </div>

            <button class="report-form__submit" type="submit">Send</button>
         </form>
      </section>
   </div>

   @if (session('donation_success'))
      <div class="donation-success-overlay is-active" data-donation-success data-redirect-url="{{ route('donate-us', $selectedPost) }}" role="status" aria-live="polite">
         <div class="donation-success-card">
            <div class="donation-success-icon" aria-hidden="true">
               <i class="fa-solid fa-check"></i>
            </div>
            <h2>{{ session('donation_success.message', 'Payment successful') }}</h2>
            <p data-donation-success-time>{{ session('donation_success.paid_at') }}</p>
         </div>
      </div>
   @endif

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

<div class="document-preview-modal" data-document-modal aria-hidden="true">
   <section class="document-preview-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="documentPreviewTitle">
      <div class="document-preview-modal__head">
         <h3 id="documentPreviewTitle" data-document-title>Campaign Document</h3>
         <button class="document-preview-modal__close" type="button" data-document-close aria-label="Close document preview">
            <i class="fa-solid fa-xmark"></i>
         </button>
      </div>
      <div class="document-preview-modal__body" data-document-body></div>
   </section>
</div>

<script>
   document.addEventListener('DOMContentLoaded', () => {
      const referModal = document.querySelector('[data-refer-modal]');
      const referOpenButtons = document.querySelectorAll('[data-refer-open]');
      const referCloseButton = document.querySelector('[data-refer-close]');
      const supportersModal = document.querySelector('[data-supporters-modal]');
      const supportersOpenButton = document.querySelector('[data-supporters-open]');
      const supportersCloseButton = document.querySelector('[data-supporters-close]');
      const supportersDonateButton = document.querySelector('[data-supporters-donate]');
      const paymentDetailsModal = document.querySelector('[data-payment-details-modal]');
      const paymentDetailsOpenButtons = document.querySelectorAll('[data-payment-details-open]');
      const paymentDetailsCloseButton = document.querySelector('[data-payment-details-close]');
      const reportModal = document.querySelector('[data-report-modal]');
      const reportOpenButton = document.querySelector('[data-report-open]');
      const reportCloseButton = document.querySelector('[data-report-close]');
      const reportFileInput = document.querySelector('[data-report-file]');
      const reportFileName = document.querySelector('[data-report-file-name]');
      const donationModal = document.querySelector('[data-donation-modal]');
      const donationOpenButtons = document.querySelectorAll('[data-donation-open]');
      const donationCloseButton = document.querySelector('[data-donation-close]');
      const donationExit = document.querySelector('[data-donation-exit]');
      const donationContinueButton = document.querySelector('[data-donation-continue]');
      const donationConfirmCloseButton = document.querySelector('[data-donation-confirm-close]');
      const donationForm = document.querySelector('[data-donation-form]');
      const donationNameInput = document.querySelector('[data-donation-name]');
      const donationContactInput = document.querySelector('[data-donation-contact]');
      const donationSuccessOverlay = document.querySelector('[data-donation-success]');
      const donationSuccessTime = document.querySelector('[data-donation-success-time]');
      const donationAmountInput = document.querySelector('[data-donation-amount]');
      const donationTipSelect = document.querySelector('[data-donation-tip]');
      const donationTotalButton = document.querySelector('[data-donation-total]');
      const donationTipAmountInput = document.querySelector('[data-donation-tip-amount]');
      const donationTotalAmountInput = document.querySelector('[data-donation-total-amount]');
      const donationSummaryAmount = document.querySelector('[data-donation-summary-amount]');
      const donationSummaryTip = document.querySelector('[data-donation-summary-tip]');
      const donationSummaryTotal = document.querySelector('[data-donation-summary-total]');
      const donationPaymentMethodInput = document.querySelector('[data-donation-payment-method]');
      const donationMethodButtons = document.querySelectorAll('[data-donation-method]');
      const donationSticky = document.querySelector('.donation-sticky');
      const donationSidebarColumn = document.querySelector('.donation-sidebar-col');
      const donationLayoutRow = document.querySelector('.donate-layout-row');
      const documentModal = document.querySelector('[data-document-modal]');
      const documentTitle = document.querySelector('[data-document-title]');
      const documentBody = document.querySelector('[data-document-body]');
      const documentCloseButton = document.querySelector('[data-document-close]');
      let retainedReportFile = null;
      let selectedDonationTipPercent = null;

      const formatDonationAmount = (amount, decimals = 0) => {
         return new Intl.NumberFormat('en-IN', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
         }).format(amount);
      };

      const formatDonationTipLabelAmount = (amount) => {
         const hasDecimals = Math.abs(amount % 1) > 0.001;

         return new Intl.NumberFormat('en-IN', {
            minimumFractionDigits: hasDecimals ? 2 : 0,
            maximumFractionDigits: hasDecimals ? 2 : 0,
         }).format(amount);
      };

      const getDonationTipPercents = (amount) => {
         return [10, 12, 14, 16];
      };

      const getDefaultDonationTipPercent = (amount) => {
         return 16;
      };

      if (donationModal?.classList.contains('is-open') || donationSuccessOverlay) {
         document.body.style.overflow = 'hidden';
      }

      if (donationSuccessOverlay) {
         document.body.classList.add('donation-success-active');
         donationSuccessTime && (donationSuccessTime.textContent = new Intl.DateTimeFormat('en-IN', {
            dateStyle: 'medium',
            timeStyle: 'short',
         }).format(new Date()));

         window.setTimeout(() => {
            const redirectUrl = donationSuccessOverlay.dataset.redirectUrl || window.location.href;
            window.location.href = redirectUrl;
         }, 2800);
      }

      const isValidDonationEmail = (value) => {
         return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
      };

      const isValidDonationPhone = (value) => {
         const phone = value.replace(/[\s()+-]/g, '');
         return /^\d{7,15}$/.test(phone);
      };

      const validateDonationIdentity = () => {
         if (!donationNameInput || !donationContactInput) {
            return true;
         }

         const name = donationNameInput.value.trim();
         const contact = donationContactInput.value.trim();

         donationNameInput.setCustomValidity(name ? '' : 'Please enter your name.');

         if (!contact) {
            donationContactInput.setCustomValidity('Please enter your mobile number or email ID.');
         } else if (!isValidDonationEmail(contact) && !isValidDonationPhone(contact)) {
            donationContactInput.setCustomValidity('Please enter a valid email ID or mobile number.');
         } else {
            donationContactInput.setCustomValidity('');
         }

         return donationNameInput.checkValidity() && donationContactInput.checkValidity();
      };

      const syncDonationSticky = () => {
         if (!donationSticky || !donationSidebarColumn || !donationLayoutRow) {
            return;
         }

         if (window.innerWidth < 1200) {
            donationSticky.classList.remove('is-fixed', 'is-bottom');
            donationSticky.style.removeProperty('--donation-sticky-top');
            donationSticky.style.removeProperty('--donation-sticky-left');
            donationSticky.style.removeProperty('--donation-sticky-width');
            return;
         }

         donationSticky.classList.remove('is-fixed', 'is-bottom');

         const topOffset = 82;
         const scrollY = window.scrollY || window.pageYOffset;
         const columnRect = donationSidebarColumn.getBoundingClientRect();
         const stickyRect = donationSticky.getBoundingClientRect();
         const rowRect = donationLayoutRow.getBoundingClientRect();
         const columnTop = scrollY + columnRect.top;
         const rowBottom = scrollY + rowRect.bottom;
         const stickyHeight = donationSticky.offsetHeight;
         const stickyWidth = stickyRect.width;
         const fixedLeft = stickyRect.left;

         donationSticky.style.setProperty('--donation-sticky-top', `${topOffset}px`);
         donationSticky.style.setProperty('--donation-sticky-left', `${fixedLeft}px`);
         donationSticky.style.setProperty('--donation-sticky-width', `${stickyWidth}px`);

         if (scrollY + topOffset <= columnTop) {
            return;
         }

         if (scrollY + topOffset + stickyHeight >= rowBottom) {
            donationSticky.classList.add('is-bottom');
            return;
         }

         donationSticky.classList.add('is-fixed');
      };

      const parseDonationAmount = (value) => {
         const amount = Number(String(value).replace(/[^0-9.]/g, ''));
         return Number.isFinite(amount) ? amount : 0;
      };

      const refreshDonationTipDropdown = () => {
         if (window.jQuery && window.jQuery.fn?.niceSelect && donationTipSelect) {
            window.jQuery(donationTipSelect).niceSelect('update');
         }
      };

      const formatDonationAmountField = () => {
         if (!donationAmountInput) {
            return;
         }

         const amount = parseDonationAmount(donationAmountInput.value);
         donationAmountInput.value = amount > 0 ? formatDonationAmount(amount) : '';
      };

      const updateDonationTotal = () => {
         if (!donationAmountInput || !donationTipSelect || !donationTotalButton) {
            return;
         }

         const amount = parseDonationAmount(donationAmountInput.value);
         const tipPercents = getDonationTipPercents(amount);
         const currentTipPercent = selectedDonationTipPercent ?? getDefaultDonationTipPercent(amount);
         const selectedTipPercent = currentTipPercent === 0 || tipPercents.includes(currentTipPercent)
            ? currentTipPercent
            : getDefaultDonationTipPercent(amount);

         donationTipSelect.innerHTML = '';

         tipPercents.forEach((percent) => {
            const option = document.createElement('option');
            option.value = String(percent);
            option.textContent = `${percent}% (\u20B9${formatDonationTipLabelAmount(amount * (percent / 100))})`;
            option.selected = percent === selectedTipPercent;
            donationTipSelect.appendChild(option);
         });

         const noTipOption = document.createElement('option');
         noTipOption.value = '0';
         noTipOption.textContent = 'No tip';
         noTipOption.selected = selectedTipPercent === 0;
         donationTipSelect.appendChild(noTipOption);

         const otherTipOption = document.createElement('option');
         otherTipOption.value = 'other';
         otherTipOption.textContent = 'Other';
         donationTipSelect.appendChild(otherTipOption);

         selectedDonationTipPercent = selectedTipPercent;
         const tipPercent = Number(donationTipSelect.value) || 0;
         const tipAmount = amount * (tipPercent / 100);
         const totalAmount = amount + tipAmount;

         donationTipAmountInput && (donationTipAmountInput.value = tipAmount.toFixed(2));
         donationTotalAmountInput && (donationTotalAmountInput.value = totalAmount.toFixed(2));
         donationSummaryAmount && (donationSummaryAmount.textContent = `Rs ${formatDonationAmount(amount)}`);
         donationSummaryTip && (donationSummaryTip.textContent = `${tipPercent}% (Rs ${formatDonationAmount(tipAmount)})`);
         donationSummaryTotal && (donationSummaryTotal.textContent = `Rs ${formatDonationAmount(totalAmount)}`);
         donationTotalButton.textContent = `Continue to pay Rs ${formatDonationAmount(totalAmount)}`;
         refreshDonationTipDropdown();
      };

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

      const openSupportersModal = () => {
         if (!supportersModal) {
            return;
         }

         supportersModal.classList.add('is-open');
         supportersModal.setAttribute('aria-hidden', 'false');
         document.body.style.overflow = 'hidden';
         supportersCloseButton?.focus();
      };

      const closeSupportersModal = () => {
         if (!supportersModal) {
            return;
         }

         supportersModal.classList.remove('is-open');
         supportersModal.setAttribute('aria-hidden', 'true');
         document.body.style.overflow = donationModal?.classList.contains('is-open') ? 'hidden' : '';
      };

      const openPaymentDetailsModal = () => {
         if (!paymentDetailsModal) {
            return;
         }

         paymentDetailsModal.classList.add('is-open');
         paymentDetailsModal.setAttribute('aria-hidden', 'false');
         document.body.style.overflow = 'hidden';
         paymentDetailsModal.querySelector('select, input, button')?.focus();
      };

      const closePaymentDetailsModal = () => {
         if (!paymentDetailsModal) {
            return;
         }

         paymentDetailsModal.classList.remove('is-open');
         paymentDetailsModal.setAttribute('aria-hidden', 'true');
         document.body.style.overflow = supportersModal?.classList.contains('is-open') || donationModal?.classList.contains('is-open') ? 'hidden' : '';
      };

      const openReportModal = () => {
         if (!reportModal) {
            return;
         }

         reportModal.classList.add('is-open');
         reportModal.setAttribute('aria-hidden', 'false');
         document.body.style.overflow = 'hidden';
         reportModal.querySelector('input, select, textarea, button')?.focus();
      };

      const closeReportModal = () => {
         if (!reportModal) {
            return;
         }

         reportModal.classList.remove('is-open');
         reportModal.setAttribute('aria-hidden', 'true');
         document.body.style.overflow = donationModal?.classList.contains('is-open') ? 'hidden' : '';
      };

      const openDocumentPreview = (button) => {
         if (!documentModal || !documentBody || !documentTitle) {
            return;
         }

         const url = button.dataset.documentUrl;
         const title = button.dataset.documentTitle || 'Campaign Document';
         const type = button.dataset.documentType || 'frame';

         documentTitle.textContent = title;
         documentBody.innerHTML = type === 'image'
            ? `<img class="document-preview-modal__image" src="${url}" alt="${title}">`
            : `<iframe class="document-preview-modal__frame" src="${url}" title="${title}"></iframe>`;
         documentModal.classList.add('is-open');
         documentModal.setAttribute('aria-hidden', 'false');
         document.body.style.overflow = 'hidden';
         documentCloseButton?.focus();
      };

      const closeDocumentPreview = () => {
         if (!documentModal || !documentBody) {
            return;
         }

         documentModal.classList.remove('is-open');
         documentModal.setAttribute('aria-hidden', 'true');
         documentBody.innerHTML = '';
         document.body.style.overflow = '';
      };

      const setDonationMethod = (method = 'card') => {
         donationMethodButtons.forEach((item) => {
            const isActive = item.dataset.donationMethod === method;
            item.classList.toggle('is-active', isActive);
            item.setAttribute('aria-selected', isActive ? 'true' : 'false');
         });

         if (donationPaymentMethodInput) {
            donationPaymentMethodInput.value = method;
         }
      };

      const openDonationModal = (method = null) => {
         if (!donationModal) {
            return;
         }

         hideDonationExitConfirm();
         if (method) {
            setDonationMethod(method);
         }
         updateDonationTotal();
         donationModal.classList.add('is-open');
         donationModal.setAttribute('aria-hidden', 'false');
         document.body.style.overflow = 'hidden';
         donationModal.querySelector('input:not([type="hidden"]), button')?.focus();
      };

      const showDonationExitConfirm = () => {
         if (!donationExit) {
            closeDonationModal(true);
            return;
         }

         donationExit.classList.add('is-open');
         donationExit.setAttribute('aria-hidden', 'false');
         donationExit.querySelector('button')?.focus();
      };

      function hideDonationExitConfirm() {
         if (!donationExit) {
            return;
         }

         donationExit.classList.remove('is-open');
         donationExit.setAttribute('aria-hidden', 'true');
      }

      function closeDonationModal(force = false) {
         if (!donationModal) {
            return;
         }

         if (!force) {
            showDonationExitConfirm();
            return;
         }

         hideDonationExitConfirm();
         donationModal.classList.remove('is-open');
         donationModal.setAttribute('aria-hidden', 'true');
         document.body.style.overflow = '';
      }

      referOpenButtons.forEach((button) => {
         button.addEventListener('click', openReferModal);
      });

      supportersOpenButton?.addEventListener('click', openSupportersModal);
      supportersCloseButton?.addEventListener('click', closeSupportersModal);
      supportersDonateButton?.addEventListener('click', () => {
         closeSupportersModal();
         openDonationModal();
      });
      supportersModal?.addEventListener('click', (event) => {
         if (event.target === supportersModal) {
            closeSupportersModal();
         }
      });
      paymentDetailsOpenButtons.forEach((button) => {
         button.addEventListener('click', openPaymentDetailsModal);
      });
      paymentDetailsCloseButton?.addEventListener('click', closePaymentDetailsModal);
      paymentDetailsModal?.addEventListener('click', (event) => {
         if (event.target === paymentDetailsModal) {
            closePaymentDetailsModal();
         }
      });
      reportOpenButton?.addEventListener('click', openReportModal);
      reportCloseButton?.addEventListener('click', closeReportModal);
      reportModal?.addEventListener('click', (event) => {
         if (event.target === reportModal) {
            closeReportModal();
         }
      });
      reportFileInput?.addEventListener('change', () => {
         const file = reportFileInput.files?.[0];

         if (file) {
            retainedReportFile = file;
            reportFileName && (reportFileName.textContent = `Selected: ${file.name}`);
            return;
         }

         if (retainedReportFile) {
            try {
               const retainedFiles = new DataTransfer();
               retainedFiles.items.add(retainedReportFile);
               reportFileInput.files = retainedFiles.files;
            } catch (error) {
               // Some older browsers do not allow restoring file inputs.
            }

            reportFileName && (reportFileName.textContent = `Selected: ${retainedReportFile.name}`);
            return;
         }

         return;
      });

      donationOpenButtons.forEach((button) => {
         button.addEventListener('click', () => openDonationModal());
      });

      donationMethodButtons.forEach((button) => {
         button.addEventListener('click', () => {
            setDonationMethod(button.dataset.donationMethod || 'card');
         });
      });

      donationAmountInput?.addEventListener('input', updateDonationTotal);
      donationAmountInput?.addEventListener('keyup', updateDonationTotal);
      donationAmountInput?.addEventListener('change', updateDonationTotal);
      donationAmountInput?.addEventListener('blur', () => {
         formatDonationAmountField();
         updateDonationTotal();
      });
      donationTipSelect?.addEventListener('change', () => {
         selectedDonationTipPercent = Number(donationTipSelect.value) || 0;
         updateDonationTotal();
      });

      donationNameInput?.addEventListener('input', validateDonationIdentity);
      donationContactInput?.addEventListener('input', validateDonationIdentity);
      donationForm?.addEventListener('submit', (event) => {
         if (validateDonationIdentity()) {
            return;
         }

         event.preventDefault();
         donationForm.reportValidity();
      });

      donationModal?.addEventListener('click', (event) => {
         const tipOption = event.target.closest('.donation-modal__tip .nice-select .option');

         if (!tipOption || !donationTipSelect) {
            return;
         }

         window.setTimeout(() => {
            selectedDonationTipPercent = Number(tipOption.dataset.value) || 0;
            donationTipSelect.value = String(selectedDonationTipPercent);
            updateDonationTotal();
         }, 0);
      });

      updateDonationTotal();
      syncDonationSticky();
      window.addEventListener('scroll', syncDonationSticky, { passive: true });
      window.addEventListener('resize', syncDonationSticky);

      referCloseButton?.addEventListener('click', closeReferModal);
      referModal?.addEventListener('click', (event) => {
         if (event.target === referModal) {
            closeReferModal();
         }
      });

      donationCloseButton?.addEventListener('click', () => closeDonationModal());
      donationContinueButton?.addEventListener('click', hideDonationExitConfirm);
      donationConfirmCloseButton?.addEventListener('click', () => closeDonationModal(true));
      donationModal?.addEventListener('click', (event) => {
         if (event.target === donationModal) {
            closeDonationModal();
         }
      });

      document.addEventListener('keydown', (event) => {
         if (event.key === 'Escape' && referModal?.classList.contains('is-open')) {
            closeReferModal();
         }

         if (event.key === 'Escape' && supportersModal?.classList.contains('is-open')) {
            closeSupportersModal();
         }

         if (event.key === 'Escape' && paymentDetailsModal?.classList.contains('is-open')) {
            closePaymentDetailsModal();
         }

         if (event.key === 'Escape' && reportModal?.classList.contains('is-open')) {
            closeReportModal();
         }

         if (event.key === 'Escape' && donationModal?.classList.contains('is-open')) {
            if (donationExit?.classList.contains('is-open')) {
               hideDonationExitConfirm();
               return;
            }

            closeDonationModal();
         }

         if (event.key === 'Escape' && documentModal?.classList.contains('is-open')) {
            closeDocumentPreview();
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

      document.querySelectorAll('[data-document-open]').forEach((button) => {
         button.addEventListener('click', () => openDocumentPreview(button));
      });

      documentCloseButton?.addEventListener('click', closeDocumentPreview);
      documentModal?.addEventListener('click', (event) => {
         if (event.target === documentModal) {
            closeDocumentPreview();
         }
      });

      const canvas = document.getElementById('donationQrCanvas');
      const qrButton = document.querySelector('.donation-qr__button');

      if (!canvas || !qrButton) {
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
                  context.fillStyle = Math.random() > 0.16 ? '#001b3f' : '#a83220';
                  context.fillRect(x * cellSize, y * cellSize, cellSize, cellSize);
               }
            }
         }
      };

      qrButton.addEventListener('click', () => {
         generateQr();
         openDonationModal('qr');
      });
      generateQr();
   });
</script>

<x-footer>
</x-footer>
