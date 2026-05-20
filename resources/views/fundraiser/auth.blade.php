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
            --gold: #932a19;
            --gold-dark: #b21f17;
            --gold-soft: #f7e1df;
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
                radial-gradient(circle at 80% 20%, rgba(147, 42, 25, 0.28), transparent 30%),
                linear-gradient(135deg, #ffffff, #f7f8fb 58%, #f7e1df);
            overflow-x: hidden;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 34px 18px;
        }

        .auth-card {
            width: min(100%, 1160px);
            display: grid;
            grid-template-columns: 0.92fr 1.08fr;
            min-height: 720px;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 70px rgba(18, 24, 39, 0.14);
        }

        .auth-brand {
            min-height: 720px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(28px, 4vw, 48px);
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
            border: 1px solid rgba(147, 42, 25, 0.32);
            border-radius: 999px;
            padding: 9px 15px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.26);
            backdrop-filter: blur(10px);
        }

        .auth-brand__logo img {
            width: 166px;
            max-width: 46vw;
            height: auto;
            display: block;
        }

        .auth-brand h1 {
            max-width: 460px;
            font-size: clamp(38px, 4.4vw, 58px);
            font-weight: 900;
            line-height: 1;
        }

        .auth-brand p {
            font-size: 16px;
            line-height: 1.55;
        }

        .auth-panel {
            padding: clamp(28px, 3vw, 44px);
            overflow: hidden;
        }

        .switch {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-bottom: 16px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 5px;
            background: #ffffff;
        }

        .switch button {
            min-height: 42px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: var(--muted);
            font-size: 14px;
            font-weight: 900;
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        .switch button:hover,
        .switch button:focus,
        .switch button:active {
            background: var(--gold-soft);
            color: #06142f;
        }

        .switch button.active {
            background: var(--gold);
            color: #ffffff;
            box-shadow: 0 10px 22px rgba(147, 42, 25, 0.28);
        }

        .form-wrap {
            position: relative;
            min-height: 390px;
            transition: min-height 0.25s ease;
        }

        .auth-card[data-mode="register"] .form-wrap {
            min-height: 650px;
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
            min-height: 46px;
            border-radius: 10px;
            border-color: var(--line);
            font-size: 15px;
            font-weight: 700;
        }

        .auth-form h2 {
            margin-bottom: 6px !important;
            font-size: clamp(27px, 2.6vw, 34px);
        }

        .auth-form p.muted {
            margin-bottom: 18px !important;
            font-size: 15px;
            line-height: 1.45;
        }

        .auth-form .mb-4 {
            margin-bottom: 1.15rem !important;
        }

        .auth-form .row {
            --bs-gutter-y: 0.8rem;
        }

        .auth-form .form-label {
            margin-bottom: 6px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(147, 42, 25, 0.18);
        }

        .password-field {
            position: relative;
        }

        .password-field .form-control {
            padding-right: 54px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            z-index: 3;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 10px;
            color: #718096;
            background: transparent;
            transform: translateY(-50%);
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .password-toggle i {
            display: block;
            line-height: 1;
            font-size: 15px;
        }

        .password-toggle:hover,
        .password-toggle:focus,
        .password-toggle.is-visible {
            color: var(--gold-dark);
            background: #f7e1df;
        }

        .btn-gold {
            min-height: 48px;
            border: 0;
            border-radius: 10px;
            background: var(--gold);
            color: #ffffff;
            font-weight: 900;
            transition: background-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .btn-gold:hover,
        .btn-gold:focus,
        .btn-gold:active,
        .btn-gold:focus-visible,
        .btn-gold:first-child:active {
            background-color: var(--gold-dark);
            border-color: var(--gold-dark);
            color: #ffffff;
            box-shadow: 0 10px 22px rgba(147, 42, 25, 0.34);
        }

        .btn-gold:hover,
        .btn-gold:focus-visible {
            transform: translateY(-1px);
        }

        .btn-gold:active,
        .btn-gold:first-child:active {
            transform: translateY(0);
        }

        .muted {
            color: var(--muted);
        }

        .upload-box {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 112px;
            border: 1.5px dashed #b21f17;
            border-radius: 10px;
            padding: 14px 16px;
            background: #fff8ec;
            color: var(--ink);
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }

        .upload-box.has-selected-file {
            min-height: 112px;
            padding: 10px 90px 10px 14px;
        }

        .upload-box:hover,
        .upload-box:focus-within {
            border-color: #b21f17;
            background: #f7e1df;
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

        .upload-box.has-selected-file input {
            right: 76px;
            width: calc(100% - 76px);
        }

        .upload-icon {
            width: 28px;
            height: 28px;
            display: inline-grid;
            place-items: center;
            margin-bottom: 6px;
            border-radius: 50%;
            background: #b21f17;
            color: #ffffff;
            font-size: 13px;
        }

        .upload-title {
            display: block;
            margin-bottom: 2px;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.2;
        }

        .upload-help,
        .upload-selected {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            line-height: 1.25;
        }

        .upload-selected {
            margin-top: 3px;
            color: #8a5400;
        }

        .upload-clear {
            position: absolute;
            right: 12px;
            bottom: 12px;
            z-index: 2;
            border: 0;
            border-radius: 999px;
            padding: 4px 12px;
            background: #ffffff;
            color: #8a5400;
            font-size: 11px;
            font-weight: 900;
            box-shadow: 0 6px 14px rgba(147, 42, 25, 0.2);
        }

        .upload-clear:hover,
        .upload-clear:focus {
            background: #ffe6b7;
            color: #000000;
        }

        .alert-auto-dismiss {
            transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease;
        }

        .alert-auto-dismiss.is-hiding {
            opacity: 0;
            transform: translateY(-8px);
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
            border-width: 0;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            .auth-page {
                display: block;
                padding: 18px;
            }

            .auth-card {
                grid-template-columns: 1fr;
                width: 100%;
                min-height: auto;
            }

            .auth-brand {
                min-height: 360px;
            }

            .auth-card[data-mode="register"] .form-wrap {
                min-height: 720px;
            }
        }

        @media (max-width: 575px) {
            .auth-page {
                padding: 0;
                min-height: 100svh;
            }

            .auth-card {
                min-height: 100svh;
                border-radius: 0;
                overflow: visible;
            }

            .auth-brand {
                min-height: 300px;
                padding: 22px 18px;
            }

            .auth-brand__logo img {
                width: 136px;
                max-width: 64vw;
            }

            .auth-brand h1 {
                font-size: clamp(30px, 12vw, 42px);
            }

            .auth-brand p {
                font-size: 14px;
            }

            .auth-panel {
                padding: 24px 18px max(96px, env(safe-area-inset-bottom));
                overflow: visible;
            }

            .switch {
                border-radius: 18px;
            }

            .switch button {
                min-height: 40px;
                font-size: 13px;
            }

            .auth-form {
                transform: translateX(18px);
            }

            .form-control,
            .form-select {
                min-height: 44px;
                font-size: 14px;
            }

            .password-toggle {
                width: 36px;
                height: 36px;
            }

            .auth-card[data-mode="register"] .form-wrap {
                min-height: 960px;
            }

            .upload-box.has-selected-file {
                padding-right: 12px;
                padding-bottom: 44px;
            }
        }

        @media (max-width: 380px) {
            .auth-panel {
                padding-inline: 14px;
                padding-bottom: max(110px, env(safe-area-inset-bottom));
            }

            .auth-card[data-mode="register"] .form-wrap {
                min-height: 1010px;
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
                    <div class="alert alert-success alert-auto-dismiss" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-auto-dismiss" role="alert" data-auto-dismiss="5500">
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
                            <input class="form-control" id="login_email" type="email" name="email" value="{{ $mode !== 'register' ? old('email') : '' }}" placeholder="Enter your email address" autocomplete="email" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" for="login_password">Password</label>
                            <div class="password-field">
                                <input class="form-control" id="login_password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                                <button class="password-toggle" type="button" data-password-toggle="login_password" aria-label="Show password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
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
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" autocomplete="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ $mode === 'register' ? old('email') : '' }}" placeholder="Enter your email address" autocomplete="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="password">Password</label>
                                <div class="password-field">
                                    <input class="form-control" id="password" type="password" name="password" placeholder="Create a password" autocomplete="new-password" required>
                                    <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Show password">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" for="password_confirmation">Confirm Password</label>
                                <div class="password-field">
                                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm your password" autocomplete="new-password" required>
                                    <button class="password-toggle" type="button" data-password-toggle="password_confirmation" aria-label="Show password">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
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
                                <input class="form-control" id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" autocomplete="tel" required>
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
                                    <button class="upload-clear d-none" type="button" data-clear-file="documents">Remove</button>
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-gold w-100 mt-4" type="submit">Upload & Submit</button>
                    </form>
                </div>
            </section>
        </section>
    </main>

    @include('partials.auto-alerts')
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

        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const input = document.getElementById(button.dataset.passwordToggle);
            const icon = button.querySelector('i');

            if (!input || !icon) {
                return;
            }

            button.addEventListener('click', () => {
                const shouldShow = input.type === 'password';

                input.type = shouldShow ? 'text' : 'password';
                button.classList.toggle('is-visible', shouldShow);
                button.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
                icon.classList.toggle('fa-eye', !shouldShow);
                icon.classList.toggle('fa-eye-slash', shouldShow);
                input.focus();
            });
        });

        document.querySelectorAll('[data-file-input]').forEach((input) => {
            const retainedFiles = new WeakMap();

            function cloneFileList(files) {
                if (!files || !files.length || typeof DataTransfer === 'undefined') {
                    return null;
                }

                const transfer = new DataTransfer();
                Array.from(files).forEach((file) => transfer.items.add(file));

                return transfer.files;
            }

            function updateUploadState(input) {
                const box = input.closest('.upload-box');
                const label = box.querySelector('[data-file-label]');
                const clearButton = box.querySelector('[data-clear-file]');
                const files = Array.from(input.files || []);

                label.textContent = files.length === 0
                    ? 'No file chosen'
                    : files.length === 1
                        ? files[0].name
                        : `${files.length} files selected`;

                box.classList.toggle('has-selected-file', files.length > 0);

                if (clearButton) {
                    clearButton.classList.toggle('d-none', files.length === 0);
                }
            }

                input.addEventListener('change', () => {
                    if (input.files.length) {
                        retainedFiles.set(input, cloneFileList(input.files));
                        updateUploadState(input);
                        return;
                    }

                    if (input.dataset.uploadClearing === 'true') {
                        updateUploadState(input);
                        return;
                    }

                    const previousFiles = retainedFiles.get(input);

                    if (previousFiles && previousFiles.length) {
                        const restoredFiles = cloneFileList(previousFiles);

                        if (restoredFiles) {
                            input.files = restoredFiles;
                        }

                        updateUploadState(input);
                        return;
                    }
                });

                input.closest('.upload-box').querySelectorAll('[data-clear-file]').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    retainedFiles.delete(input);
                    input.dataset.uploadClearing = 'true';
                    input.value = '';
                    updateUploadState(input);
                    input.dispatchEvent(new CustomEvent('upload:clear', { bubbles: true }));
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                    delete input.dataset.uploadClearing;
                });
            });
        });

    </script>
</body>
</html>
