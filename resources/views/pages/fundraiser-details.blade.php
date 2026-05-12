<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraiser Details | Charitia</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        :root {
            --fundraiser-accent: #ffb33f;
            --fundraiser-accent-dark: #e89c22;
            --fundraiser-ink: #000000;
            --fundraiser-muted: #5d5d5d;
            --fundraiser-line: #e3ddd2;
            --fundraiser-soft: #fff8ec;
            --fundraiser-yellow: #ffb33f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Nunito", sans-serif;
            color: var(--fundraiser-ink);
            background:
                radial-gradient(circle at 100% 49%, rgba(255, 179, 63, 0.32) 0 18%, transparent 19%),
                radial-gradient(circle at 4% 82%, rgba(255, 179, 63, 0.22) 0 20%, transparent 21%),
                linear-gradient(135deg, #000000 0%, #181818 58%, #ffb33f 100%);
        }

        .fundraiser-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 14px;
            position: relative;
            overflow: hidden;
        }

        .fundraiser-page::before,
        .fundraiser-page::after {
            position: absolute;
            width: 150px;
            height: 170px;
            content: "";
            opacity: 0.2;
            background-image: radial-gradient(circle, #ffb33f 0 4px, transparent 5px);
            background-size: 28px 28px;
        }

        .fundraiser-page::before {
            left: -18px;
            top: 34%;
        }

        .fundraiser-page::after {
            right: -18px;
            bottom: 4%;
        }

        .fundraiser-card {
            position: relative;
            z-index: 1;
            width: min(100%, 560px);
            border-radius: 18px;
            padding: clamp(18px, 3vw, 26px) clamp(16px, 4vw, 36px);
            border: 1px solid rgba(255, 179, 63, 0.35);
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 26px 70px rgba(0, 0, 0, 0.32);
        }

        .fundraiser-card__logo {
            display: flex;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .fundraiser-card__logo img {
            width: 138px;
            max-width: 52%;
            height: auto;
        }

        .fundraiser-card h1 {
            margin: 0;
            color: var(--fundraiser-ink);
            font-size: clamp(24px, 4vw, 30px);
            font-weight: 900;
            line-height: 1.12;
            text-align: center;
            letter-spacing: 0;
        }

        .fundraiser-card__divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0;
            color: var(--fundraiser-yellow);
            font-size: 14px;
        }

        .fundraiser-card__divider::before,
        .fundraiser-card__divider::after {
            flex: 1;
            height: 1px;
            content: "";
            background: var(--fundraiser-line);
        }

        .fundraiser-card__notice {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            padding: 14px 20px;
            border: 1px solid rgba(255, 179, 63, 0.28);
            background: linear-gradient(90deg, #fff9ef, #fff3de);
            color: var(--fundraiser-ink);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.36;
        }

        .fundraiser-alert {
            margin-bottom: 16px;
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid rgba(255, 179, 63, 0.28);
            background: #fff8ec;
            color: var(--fundraiser-ink);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.45;
        }

        .fundraiser-alert--error {
            border-color: #efc0b4;
            background: #fff5f2;
            color: #9f321f;
        }

        .fundraiser-alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .fundraiser-card__pill {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 2px solid var(--fundraiser-accent);
            border-radius: 999px;
            padding: 6px 14px;
            color: var(--fundraiser-ink);
            background: #ffffff;
            font-size: 12px;
            font-weight: 900;
        }

        .fundraiser-form__label {
            display: block;
            margin: 0 0 6px;
            color: var(--fundraiser-ink);
            font-size: 13px;
            font-weight: 900;
        }

        .fundraiser-form__field {
            position: relative;
            margin-bottom: 14px;
        }

        .fundraiser-form__field input,
        .fundraiser-form__field select {
            width: 100%;
            height: 44px;
            border: 2px solid var(--fundraiser-line);
            border-radius: 8px;
            outline: 0;
            padding: 0 14px 0 44px;
            color: var(--fundraiser-ink);
            background: #ffffff;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .fundraiser-form__field select {
            appearance: none;
            color: var(--fundraiser-muted);
            cursor: pointer;
        }

        .fundraiser-form__field input::placeholder {
            color: var(--fundraiser-muted);
            opacity: 1;
        }

        .fundraiser-form__field input:focus,
        .fundraiser-form__field select:focus {
            border-color: var(--fundraiser-accent);
            box-shadow: 0 0 0 4px rgba(255, 179, 63, 0.22);
        }

        .fundraiser-form__icon,
        .fundraiser-form__select-arrow {
            position: absolute;
            top: 50%;
            color: var(--fundraiser-muted);
            font-size: 16px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .fundraiser-form__icon {
            left: 16px;
        }

        .fundraiser-form__select-arrow {
            right: 16px;
        }

        .fundraiser-form__phone {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .fundraiser-form__phone .fundraiser-form__field {
            margin-bottom: 0;
        }

        .fundraiser-form__country select {
            padding: 0 34px 0 16px;
            color: var(--fundraiser-ink);
        }

        .fundraiser-form__hint {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin: 0 0 12px;
            color: var(--fundraiser-muted);
            font-size: 12px;
            font-weight: 700;
            line-height: 1.45;
        }

        .fundraiser-form__hint i {
            color: var(--fundraiser-accent-dark);
            margin-top: 3px;
        }

        .fundraiser-upload {
            display: block;
            position: relative;
            border: 2px dashed rgba(255, 179, 63, 0.78);
            border-radius: 10px;
            padding: 18px 16px;
            margin-bottom: 18px;
            background: var(--fundraiser-soft);
            color: var(--fundraiser-ink);
            text-align: center;
            cursor: pointer;
        }

        .fundraiser-upload input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .fundraiser-upload i {
            display: block;
            margin-bottom: 8px;
            color: var(--fundraiser-accent-dark);
            font-size: 32px;
        }

        .fundraiser-upload strong {
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
            font-weight: 900;
        }

        .fundraiser-upload span {
            color: var(--fundraiser-muted);
            font-size: 12px;
            font-weight: 700;
        }

        .fundraiser-form__submit {
            width: 100%;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 10px;
            padding: 10px 20px;
            color: var(--fundraiser-ink);
            background: linear-gradient(180deg, #ffc966, #ffb33f);
            box-shadow: 0 14px 24px rgba(255, 170, 12, 0.22);
            font: inherit;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .fundraiser-form__submit:hover,
        .fundraiser-form__submit:focus {
            transform: translateY(-1px);
            box-shadow: 0 18px 28px rgba(255, 170, 12, 0.28);
        }

        .fundraiser-form__safe {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 14px 0 16px;
            color: var(--fundraiser-muted);
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .fundraiser-form__safe i {
            color: var(--fundraiser-accent-dark);
            font-size: 16px;
        }

        .fundraiser-form__or {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            color: var(--fundraiser-muted);
            font-size: 13px;
            font-weight: 900;
            text-align: center;
        }

        .fundraiser-form__or::before,
        .fundraiser-form__or::after {
            flex: 1;
            height: 1px;
            content: "";
            background: var(--fundraiser-line);
        }

        .fundraiser-form__skip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--fundraiser-ink);
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
        }

        @media (max-width: 767px) {
            .fundraiser-page {
                align-items: flex-start;
                padding: 22px 12px;
            }

            .fundraiser-card {
                border-radius: 18px;
            }

            .fundraiser-card__notice {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
                padding: 22px;
                font-size: 19px;
            }

            .fundraiser-form__phone {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .fundraiser-form__field input,
            .fundraiser-form__field select {
                height: 54px;
                font-size: 16px;
            }

            .fundraiser-form__submit {
                min-height: 58px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <main class="fundraiser-page">
        <section class="fundraiser-card" aria-labelledby="fundraiser-title">
            <a class="fundraiser-card__logo" href="{{ route('home') }}" aria-label="Charitia home">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Charitia">
            </a>
            <h1 id="fundraiser-title">Fundraiser Details</h1>
            <div class="fundraiser-card__divider" aria-hidden="true">
                <i class="fa-solid fa-heart"></i>
            </div>

            <div class="fundraiser-card__notice">
                <span class="fundraiser-card__pill">Faster <i class="fa-solid fa-bolt"></i></span>
                <span>Start your fundraiser in just two steps by uploading the documents</span>
            </div>

            @if (session('status'))
                <div class="fundraiser-alert" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="fundraiser-alert fundraiser-alert--error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="fundraiser-form" action="{{ route('fundraiser-details.submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label class="fundraiser-form__label" for="fundraiser_name">Name *</label>
                <div class="fundraiser-form__field">
                    <i class="fundraiser-form__icon fa-regular fa-user"></i>
                    <input type="text" id="fundraiser_name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
                </div>

                <div class="fundraiser-form__phone">
                    <div class="fundraiser-form__field fundraiser-form__country">
                        <select name="country_code" aria-label="Country code">
                            <option value="+91" @selected(old('country_code', '+91') === '+91')>+91</option>
                            <option value="+1" @selected(old('country_code') === '+1')>+1</option>
                            <option value="+44" @selected(old('country_code') === '+44')>+44</option>
                            <option value="+971" @selected(old('country_code') === '+971')>+971</option>
                        </select>
                        <i class="fundraiser-form__select-arrow fa-solid fa-chevron-down"></i>
                    </div>

                    <div class="fundraiser-form__field">
                        <i class="fundraiser-form__icon fa-solid fa-phone"></i>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone number *" required>
                    </div>
                </div>

                <label class="fundraiser-form__label" for="cause">Select the Cause *</label>
                <div class="fundraiser-form__field">
                    <i class="fundraiser-form__icon fa-solid fa-hand-holding-heart"></i>
                    <select id="cause" name="cause" required>
                        <option value="">Ex: Medical</option>
                        <option value="medical" @selected(old('cause') === 'medical')>Medical</option>
                        <option value="education" @selected(old('cause') === 'education')>Education</option>
                        <option value="emergency" @selected(old('cause') === 'emergency')>Emergency</option>
                        <option value="community" @selected(old('cause') === 'community')>Community Support</option>
                    </select>
                    <i class="fundraiser-form__select-arrow fa-solid fa-chevron-down"></i>
                </div>

                <p class="fundraiser-form__hint">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Upload reports, bills, estimates, admission letters, death certificate/summary etc.</span>
                </p>

                <label class="fundraiser-upload" for="documents">
                    <input type="file" id="documents" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple>
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <strong>Upload documents</strong>
                    <span>PDF, JPG, PNG - Max 4 documents</span>
                </label>

                <button class="fundraiser-form__submit" type="submit">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    Upload &amp; Continue
                </button>

                <p class="fundraiser-form__safe">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Your documents are safe and private</span>
                </p>

                <div class="fundraiser-form__or">Or</div>

                <a class="fundraiser-form__skip" href="{{ route('coming-soon', ['menu' => 'fundraiser-without-documents']) }}">
                    <i class="fa-solid fa-rotate-right"></i>
                    Continue without documents
                </a>
            </form>
        </section>
    </main>
</body>
</html>
