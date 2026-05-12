@php
    $requestedMode = request('mode') === 'register' ? 'register' : 'login';
    $mode = old('auth_mode', session('auth_mode', $requestedMode));
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraiser Login | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #ffb33f;
            --gold-soft: #fff3dd;
            --ink: #121827;
            --muted: #647083;
            --line: #dde2ea;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 80% 20%, rgba(255, 179, 63, 0.28), transparent 30%),
                linear-gradient(135deg, #ffffff, #f7f8fb 58%, #fff3dd);
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 18px 14px;
        }

        .auth-card {
            width: min(100%, 980px);
            display: grid;
            grid-template-columns: 0.86fr 1.14fr;
            min-height: 610px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 70px rgba(18, 24, 39, 0.14);
        }

        .auth-brand {
            min-height: 610px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(22px, 4vw, 40px);
            background:
                linear-gradient(180deg, rgba(0, 0, 0, 0.18), rgba(0, 0, 0, 0.78)),
                url("{{ asset('assets/images/banner/banner-two-bg.jpg') }}") center / cover no-repeat;
            color: #ffffff;
        }

        .auth-brand__logo {
            position: relative;
            z-index: 1;
            display: inline-flex;
            width: max-content;
            align-items: center;
            border: 1px solid rgba(255, 179, 63, 0.32);
            border-radius: 999px;
            padding: 9px 15px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.26);
            backdrop-filter: blur(10px);
        }

        .auth-brand__logo img {
            width: 150px;
            max-width: 46vw;
            height: auto;
            display: block;
        }

        .auth-brand h1 {
            max-width: 420px;
            font-size: clamp(30px, 4vw, 48px);
            font-weight: 900;
            line-height: 1;
        }

        .auth-panel {
            padding: clamp(16px, 3vw, 30px);
            overflow: hidden;
        }

        .switch {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-bottom: 12px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 5px;
            background: #ffffff;
        }

        .switch button {
            min-height: 34px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--muted);
            font-weight: 900;
        }

        .switch button.active {
            background: var(--gold);
            color: #080808;
            box-shadow: 0 10px 22px rgba(255, 179, 63, 0.28);
        }

        .form-wrap {
            position: relative;
            min-height: 340px;
            transition: min-height 0.25s ease;
        }

        .auth-card[data-mode="register"] .form-wrap {
            min-height: 535px;
        }

        .auth-form {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateX(32px);
            pointer-events: none;
            transition: opacity 0.28s ease, transform 0.28s ease;
        }

        .auth-form.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto;
        }

        .form-control,
        .form-select {
            min-height: 36px;
            border-radius: 8px;
            border-color: var(--line);
            font-size: 14px;
            font-weight: 700;
        }

        .auth-form h2 {
            margin-bottom: 4px !important;
            font-size: clamp(21px, 2.4vw, 27px);
        }

        .auth-form p.muted {
            margin-bottom: 9px !important;
            font-size: 14px;
            line-height: 1.4;
        }

        .auth-form .mb-4 {
            margin-bottom: 0.75rem !important;
        }

        .auth-form .row {
            --bs-gutter-y: 0.35rem;
        }

        .auth-form .form-label {
            margin-bottom: 4px;
            font-size: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(255, 179, 63, 0.18);
        }

        .btn-gold {
            min-height: 40px;
            border: 0;
            border-radius: 10px;
            background: var(--gold);
            color: #080808;
            font-weight: 900;
        }

        .muted {
            color: var(--muted);
        }

        .upload-box {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 76px;
            border: 2px dashed #ffb33f;
            border-radius: 12px;
            padding: 7px;
            background: #fff8ec;
            color: var(--ink);
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }

        .upload-box:hover,
        .upload-box:focus-within {
            border-color: #f5a400;
            background: #fff3dd;
            transform: translateY(-1px);
        }

        .upload-box input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            width: 28px;
            height: 28px;
            display: inline-grid;
            place-items: center;
            margin-bottom: 4px;
            border-radius: 50%;
            background: #f5a400;
            color: #ffffff;
            font-size: 15px;
        }

        .upload-title {
            display: block;
            margin-bottom: 2px;
            font-size: 14px;
            font-weight: 900;
        }

        .upload-help,
        .upload-selected {
            display: block;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
        }

        .upload-selected {
            margin-top: 3px;
            color: #8a5400;
        }

        @media (max-width: 991px) {
            .auth-card {
                grid-template-columns: 1fr;
            }

            .auth-brand {
                min-height: 280px;
            }
        }

        @media (max-width: 575px) {
            .auth-page {
                padding: 0;
            }

            .auth-card {
                min-height: 100vh;
                border-radius: 0;
            }

            .auth-panel {
                padding: 24px 18px 34px;
                overflow: visible;
            }

            .auth-card[data-mode="register"] .form-wrap {
                min-height: 650px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <section class="auth-card" data-card data-mode="{{ $mode === 'register' ? 'register' : 'login' }}">
            <aside class="auth-brand">
                <a class="auth-brand__logo" href="{{ route('home') }}" aria-label="Karna Kabach home">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
                </a>
                <div>
                    <p class="text-warning fw-bold text-uppercase mb-2">Fundraiser Access</p>
                    <h1>Start your fundraiser today.</h1>
                    <p class="mb-0 text-white-50">Create your account, enter the dashboard instantly, and submit campaign posts for review.</p>
                </div>
            </aside>

            <section class="auth-panel">
                <div class="switch" role="tablist">
                    <button type="button" class="{{ $mode !== 'register' ? 'active' : '' }}" data-switch="login">Login</button>
                    <button type="button" class="{{ $mode === 'register' ? 'active' : '' }}" data-switch="register">Create Account</button>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-wrap">
                    <form class="auth-form {{ $mode !== 'register' ? 'active' : '' }}" data-form="login" action="{{ route('fundraiser.login.submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="auth_mode" value="login">

                        <h2 class="fw-black mb-2">Fundraiser Login</h2>
                        <p class="muted mb-4">Login to access your dashboard and manage fundraiser posts.</p>

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="login_email">Email</label>
                            <input class="form-control" id="login_email" type="email" name="email" value="{{ $mode !== 'register' ? old('email') : '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" for="login_password">Password</label>
                            <input class="form-control" id="login_password" type="password" name="password" required>
                        </div>

                        <button class="btn btn-gold w-100" type="submit">Login</button>
                    </form>

                    <form class="auth-form {{ $mode === 'register' ? 'active' : '' }}" data-form="register" action="{{ route('fundraiser.register.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="auth_mode" value="register">

                        <h2 class="fw-black mb-2">Create Fundraiser Account</h2>
                        <p class="muted mb-4">Create your account and go directly to your fundraiser dashboard.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="name">Full Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ $mode === 'register' ? old('email') : '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="password">Password</label>
                                <input class="form-control" id="password" type="password" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="password_confirmation">Confirm Password</label>
                                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="country_code">Code</label>
                                <select class="form-select" id="country_code" name="country_code" required>
                                    <option value="+91" @selected(old('country_code', '+91') === '+91')>+91</option>
                                    <option value="+1" @selected(old('country_code') === '+1')>+1</option>
                                    <option value="+44" @selected(old('country_code') === '+44')>+44</option>
                                    <option value="+971" @selected(old('country_code') === '+971')>+971</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold" for="phone">Phone</label>
                                <input class="form-control" id="phone" type="tel" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold" for="cause">Cause</label>
                                <select class="form-select" id="cause" name="cause" required>
                                    <option value="">Select cause</option>
                                    <option value="medical" @selected(old('cause') === 'medical')>Medical</option>
                                    <option value="education" @selected(old('cause') === 'education')>Education</option>
                                    <option value="emergency" @selected(old('cause') === 'emergency')>Emergency</option>
                                    <option value="community" @selected(old('cause') === 'community')>Community Support</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold" for="documents">Documents</label>
                                <label class="upload-box" for="documents">
                                    <input id="documents" type="file" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple data-file-input>
                                    <span class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                                    <span class="upload-title">Upload documents</span>
                                    <span class="upload-help">PDF, JPG, PNG - Max 4 documents</span>
                                    <span class="upload-selected" data-file-label>No file chosen</span>
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-gold w-100 mt-4" type="submit">Upload & Submit</button>
                    </form>
                </div>
            </section>
        </section>
    </main>

    <script>
        const card = document.querySelector('[data-card]');
        const switches = document.querySelectorAll('[data-switch]');
        const forms = document.querySelectorAll('[data-form]');

        function setMode(mode) {
            card.dataset.mode = mode;
            switches.forEach((button) => button.classList.toggle('active', button.dataset.switch === mode));
            forms.forEach((form) => form.classList.toggle('active', form.dataset.form === mode));
        }

        switches.forEach((button) => button.addEventListener('click', () => setMode(button.dataset.switch)));

        document.querySelectorAll('[data-file-input]').forEach((input) => {
            const label = input.closest('.upload-box').querySelector('[data-file-label]');

            input.addEventListener('change', () => {
                const files = Array.from(input.files || []);

                if (!files.length) {
                    label.textContent = 'No file chosen';
                    return;
                }

                label.textContent = files.length === 1
                    ? files[0].name
                    : `${files.length} files selected`;
            });
        });
    </script>
</body>
</html>
