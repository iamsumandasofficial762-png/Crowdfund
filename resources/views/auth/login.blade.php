@php
    $authMode = old('auth_mode', 'login');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Auth | Karna Kabach Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --auth-gold: #932a19;
            --auth-gold-dark: #b21f17;
            --auth-black: #000000;
            --auth-panel: rgba(255, 255, 255, 0.96);
            --auth-panel-solid: #ffffff;
            --auth-line: #dde2ea;
            --auth-muted: #53617a;
            --auth-ink: #071126;
            --auth-white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--auth-ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 88% 22%, rgba(147, 42, 25, 0.24), transparent 32%),
                linear-gradient(135deg, #ffffff 0%, #f7f8fb 58%, #f7e1df 100%);
            overflow-x: hidden;
        }

        body::before {
            display: none;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 14px;
            position: relative;
        }

        .auth-card {
            width: min(100%, 1080px);
            display: grid;
            grid-template-columns: 0.92fr 1.08fr;
            min-height: min(720px, calc(100vh - 64px));
            overflow: hidden;
            border: 1px solid var(--auth-line);
            border-radius: 24px;
            background: var(--auth-panel);
            box-shadow: 0 24px 70px rgba(18, 24, 39, 0.14);
        }

        .auth-brand {
            position: relative;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(28px, 4vw, 54px);
            background:
                linear-gradient(180deg, rgba(0, 0, 0, 0.12), rgba(0, 0, 0, 0.88)),
                url("{{ asset('assets/images/banner/banner-two-bg.jpg') }}") center / cover no-repeat;
        }

        .auth-brand::after {
            position: absolute;
            inset: 18px;
            content: "";
            border: 1px solid rgba(147, 42, 25, 0.24);
            border-radius: 18px;
            pointer-events: none;
        }

        .auth-brand__logo {
            position: relative;
            z-index: 1;
            display: inline-flex;
            width: max-content;
            align-items: center;
            border: 1px solid rgba(147, 42, 25, 0.34);
            border-radius: 999px;
            padding: 10px 17px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px);
        }

        .auth-brand__logo img {
            width: 148px;
            max-width: 52vw;
            height: auto;
            display: block;
        }

        .auth-brand__content {
            position: relative;
            z-index: 1;
            max-width: 430px;
        }

        .auth-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--auth-gold);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .auth-eyebrow::before {
            width: 34px;
            height: 2px;
            content: "";
            background: var(--auth-gold);
        }

        .auth-brand h1 {
            margin: 0 0 18px;
            color: #ffffff;
            font-size: clamp(34px, 4.4vw, 56px);
            font-weight: 900;
            line-height: 1;
        }

        .auth-brand p {
            margin: 0;
            color: rgba(255, 255, 255, 0.76);
            font-size: 16px;
            line-height: 1.7;
        }

        .auth-form-panel {
            display: flex;
            align-items: center;
            min-width: 0;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
            padding: clamp(24px, 4vw, 48px);
            background: #ffffff;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 470px;
            margin: 0 auto;
        }

        .auth-switch {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-bottom: 24px;
            border: 1px solid var(--auth-line);
            border-radius: 999px;
            padding: 6px;
            background: #ffffff;
        }

        .auth-switch button {
            min-height: 42px;
            border: 0;
            border-radius: 999px;
            color: var(--auth-muted);
            background: transparent;
            font: inherit;
            font-weight: 900;
            transition: color 0.25s ease, background 0.25s ease, transform 0.25s ease;
        }

        .auth-switch button.active {
            color: #ffffff;
            background: linear-gradient(180deg, #c94a35, var(--auth-gold));
            box-shadow: 0 12px 26px rgba(147, 42, 25, 0.22);
        }

        .auth-stage {
            position: relative;
            min-height: 420px;
            overflow: hidden;
            transition: min-height 0.28s ease;
        }

        .auth-card[data-mode="login"] .auth-stage {
            min-height: 410px;
        }

        .auth-card[data-mode="register"] .auth-stage {
            min-height: 560px;
        }

        .auth-form {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateX(38px) scale(0.98);
            pointer-events: none;
            transition: opacity 0.34s ease, transform 0.34s ease;
        }

        .auth-form.active {
            opacity: 1;
            transform: translateX(0) scale(1);
            pointer-events: auto;
        }

        .auth-form.leaving-left {
            transform: translateX(-38px) scale(0.98);
        }

        .auth-title {
            margin: 0 0 8px;
            color: var(--auth-ink);
            font-size: clamp(28px, 3.4vw, 38px);
            font-weight: 900;
            line-height: 1.05;
        }

        .auth-copy {
            margin: 0 0 20px;
            color: var(--auth-muted);
            line-height: 1.65;
        }

        .auth-field {
            margin-bottom: 14px;
        }

        .auth-field label {
            display: block;
            margin-bottom: 8px;
            color: var(--auth-ink);
            font-size: 14px;
            font-weight: 800;
        }

        .auth-input {
            position: relative;
        }

        .auth-input i {
            position: absolute;
            left: 16px;
            top: 50%;
            color: var(--auth-gold);
            transform: translateY(-50%);
        }

        .auth-input .form-control {
            min-height: 52px;
            border: 1px solid var(--auth-line);
            border-radius: 12px;
            padding-left: 46px;
            padding-right: 50px;
            color: var(--auth-ink);
            background: #ffffff;
            box-shadow: none;
        }

        .auth-input .form-control:focus {
            border-color: var(--auth-gold);
            color: var(--auth-ink);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(147, 42, 25, 0.16);
        }

        .auth-input .form-control::placeholder {
            color: #8a94a6;
        }

        .password-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            color: #718096;
            background: transparent;
            transform: translateY(-50%);
            transition: background 0.2s ease, color 0.2s ease;
        }

        .password-toggle:hover,
        .password-toggle:focus,
        .password-toggle.is-visible {
            color: var(--auth-gold);
            background: #f7e1df;
        }

        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--auth-muted);
            font-size: 14px;
            cursor: pointer;
        }

        .auth-check input {
            width: 17px;
            height: 17px;
            accent-color: var(--auth-gold);
        }

        .btn-auth {
            width: 100%;
            min-height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 12px;
            color: #ffffff;
            background: linear-gradient(180deg, #c94a35, var(--auth-gold));
            font: inherit;
            font-size: 16px;
            font-weight: 900;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn-auth:hover,
        .btn-auth:focus {
            color: #ffffff;
            transform: translateY(-2px);
            filter: saturate(1.05);
            box-shadow: 0 18px 36px rgba(147, 42, 25, 0.24);
        }

        .btn-auth.is-loading {
            pointer-events: none;
            opacity: 0.82;
        }

        .btn-auth .spinner-border {
            display: none;
            width: 18px;
            height: 18px;
            border-width: 2px;
        }

        .btn-auth.is-loading .spinner-border {
            display: inline-block;
        }

        .auth-note {
            margin-top: 16px;
            color: var(--auth-muted);
            font-size: 14px;
            text-align: center;
        }

        .auth-note button {
            border: 0;
            color: var(--auth-gold);
            background: transparent;
            font-weight: 900;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid var(--auth-line);
        }

        .alert-danger {
            color: #9f321f;
            background: #fff5f2;
        }

        .alert-success {
            color: #176b2c;
            background: #effaf1;
        }

        .alert-auto-dismiss {
            transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease;
        }

        .alert-auto-dismiss.is-hiding {
            opacity: 0;
            transform: translateY(-8px);
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            border-width: 0 !important;
            overflow: hidden;
        }

        @media (max-width: 991px) {
            .auth-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .auth-brand {
                min-height: 320px;
            }

            .auth-form-panel {
                max-height: none;
                overflow: visible;
            }

            .auth-card[data-mode="login"] .auth-stage {
                min-height: 430px;
            }

            .auth-card[data-mode="register"] .auth-stage {
                min-height: 585px;
            }
        }

        @media (max-width: 575px) {
            .auth-shell {
                padding: 0;
            }

            .auth-card {
                min-height: 100vh;
                border-width: 0;
                border-radius: 0;
            }

            .auth-brand {
                min-height: 260px;
                padding: 28px 20px;
            }

            .auth-form-panel {
                padding: 28px 20px 34px;
            }

            .auth-card[data-mode="login"] .auth-stage {
                min-height: 430px;
            }

            .auth-card[data-mode="register"] .auth-stage {
                min-height: 610px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <section class="auth-card" data-auth-card data-initial-mode="{{ $authMode }}" data-mode="{{ $authMode === 'register' ? 'register' : 'login' }}">
            <aside class="auth-brand">
                <a class="auth-brand__logo" href="{{ route('home') }}" aria-label="Karna Kabach home">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
                </a>

                <div class="auth-brand__content">
                    <span class="auth-eyebrow">Crowdfunding command center</span>
                    <h1>Raise, review, and respond with confidence.</h1>
                    <p>Secure JWT access for campaign teams, fundraisers, and admins managing every donation moment.</p>
                </div>
            </aside>

            <section class="auth-form-panel" aria-label="Authentication forms">
                <div class="auth-form-wrap">
                    <div class="auth-switch" role="tablist" aria-label="Login or register">
                        <button type="button" class="{{ $authMode !== 'register' ? 'active' : '' }}" data-auth-switch="login" role="tab" aria-selected="{{ $authMode !== 'register' ? 'true' : 'false' }}">Login</button>
                        <button type="button" class="{{ $authMode === 'register' ? 'active' : '' }}" data-auth-switch="register" role="tab" aria-selected="{{ $authMode === 'register' ? 'true' : 'false' }}">Register</button>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-auto-dismiss mb-4" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-auto-dismiss mb-4" role="alert" data-auto-dismiss="5500">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="auth-stage">
                        <form class="auth-form {{ $authMode !== 'register' ? 'active' : '' }}" data-auth-form="login" action="{{ route('login.submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="auth_mode" value="login">

                            <h2 class="auth-title">Welcome back</h2>
                            <p class="auth-copy">Login to continue managing campaigns, supporters, and donations.</p>

                            <div class="auth-field">
                                <label for="login_email">Email</label>
                                <div class="auth-input">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input class="form-control" type="email" id="login_email" name="email" value="{{ $authMode !== 'register' ? old('email') : '' }}" placeholder="admin@example.com" autocomplete="username" required autofocus>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="login_password">Password</label>
                                <div class="auth-input">
                                    <i class="fa-solid fa-lock"></i>
                                    <input class="form-control" type="password" id="login_password" name="password" placeholder="Enter password" autocomplete="current-password" required>
                                    <button class="password-toggle" type="button" data-toggle-password="login_password" aria-label="Show password">
                                        <span class="fa-regular fa-eye"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                                <label class="auth-check" for="remember">
                                    <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                                    <span>Remember me</span>
                                </label>
                            </div>

                            <button class="btn-auth" type="submit">
                                <span class="spinner-border" aria-hidden="true"></span>
                                <span>Login securely</span>
                            </button>

                            <p class="auth-note">New here? <button type="button" data-auth-switch="register">Create an account</button></p>
                        </form>

                        <form class="auth-form {{ $authMode === 'register' ? 'active' : '' }}" data-auth-form="register" action="{{ route('register.submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="auth_mode" value="register">

                            <h2 class="auth-title">Create account</h2>
                            <p class="auth-copy">Register once and enter the admin dashboard instantly with JWT protection.</p>

                            <div class="auth-field">
                                <label for="register_name">Full Name</label>
                                <div class="auth-input">
                                    <i class="fa-regular fa-user"></i>
                                    <input class="form-control" type="text" id="register_name" name="name" value="{{ old('name') }}" placeholder="Your full name" autocomplete="name" required>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="register_email">Email</label>
                                <div class="auth-input">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input class="form-control" type="email" id="register_email" name="email" value="{{ $authMode === 'register' ? old('email') : '' }}" placeholder="you@example.com" autocomplete="email" required>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="register_password">Password</label>
                                <div class="auth-input">
                                    <i class="fa-solid fa-lock"></i>
                                    <input class="form-control" type="password" id="register_password" name="password" placeholder="Minimum 8 characters" autocomplete="new-password" required>
                                    <button class="password-toggle" type="button" data-toggle-password="register_password" aria-label="Show password">
                                        <span class="fa-regular fa-eye"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="auth-input">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" autocomplete="new-password" required>
                                    <button class="password-toggle" type="button" data-toggle-password="password_confirmation" aria-label="Show password">
                                        <span class="fa-regular fa-eye"></span>
                                    </button>
                                </div>
                            </div>

                            <button class="btn-auth mt-2" type="submit">
                                <span class="spinner-border" aria-hidden="true"></span>
                                <span>Create account</span>
                            </button>

                            <p class="auth-note">Already registered? <button type="button" data-auth-switch="login">Login instead</button></p>
                        </form>
                    </div>
                </div>
            </section>
        </section>
    </main>

    @include('partials.auto-alerts')
    <script>
        (function () {
            const card = document.querySelector('[data-auth-card]');
            const switchers = document.querySelectorAll('[data-auth-switch]');
            const forms = document.querySelectorAll('[data-auth-form]');

            function setMode(mode) {
                card.dataset.mode = mode;

                switchers.forEach((button) => {
                    const active = button.dataset.authSwitch === mode;
                    button.classList.toggle('active', active);
                    button.setAttribute('aria-selected', active ? 'true' : 'false');
                });

                forms.forEach((form) => {
                    const active = form.dataset.authForm === mode;
                    form.classList.toggle('active', active);
                    form.classList.toggle('leaving-left', !active && mode === 'register');
                });
            }

            switchers.forEach((button) => {
                button.addEventListener('click', () => setMode(button.dataset.authSwitch));
            });

            document.querySelectorAll('[data-toggle-password]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.togglePassword);
                    const icon = button.querySelector('span');
                    const visible = input.type === 'text';

                    input.type = visible ? 'password' : 'text';
                    button.classList.toggle('is-visible', !visible);
                    icon.classList.toggle('fa-eye', visible);
                    icon.classList.toggle('fa-eye-slash', !visible);
                    button.setAttribute('aria-label', visible ? 'Show password' : 'Hide password');
                });
            });

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', () => {
                    const button = form.querySelector('.btn-auth');
                    button.classList.add('is-loading');
                    button.setAttribute('disabled', 'disabled');
                });
            });

            setMode(card.dataset.initialMode === 'register' ? 'register' : 'login');
        })();
    </script>
</body>
</html>
