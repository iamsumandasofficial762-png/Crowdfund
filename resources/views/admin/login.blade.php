<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Charitia</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/default-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        :root {
            --admin-ink: #17211b;
            --admin-muted: #64736b;
            --admin-line: #dde7df;
            --admin-panel: #ffffff;
            --admin-field: #f7faf8;
            --admin-accent: #2f8f46;
            --admin-accent-dark: #226c35;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--admin-ink);
            font-family: "Nunito", sans-serif;
            background: #edf3ef;
        }

        a {
            color: var(--admin-accent);
            text-decoration: none;
        }

        a:hover {
            color: var(--admin-accent-dark);
        }

        .admin-login {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(360px, 520px) 1fr;
        }

        .admin-login__panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px clamp(24px, 6vw, 72px);
            background: var(--admin-panel);
        }

        .admin-login__brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 46px;
            width: max-content;
            border: 1px solid rgba(255, 179, 63, 0.28);
            border-radius: 999px;
            padding: 9px 15px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 14px 34px rgba(23, 33, 27, 0.12);
            color: var(--admin-ink);
            font-size: 20px;
            font-weight: 900;
            line-height: 1;
        }

        .admin-login__brand img {
            width: 142px;
            max-width: 100%;
            height: auto;
            display: block;
        }

        .admin-login__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            color: var(--admin-accent);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0;
            text-transform: uppercase;
        }

        .admin-login__eyebrow::before {
            width: 28px;
            height: 2px;
            content: "";
            background: var(--admin-accent);
        }

        .admin-login h1 {
            margin: 0 0 12px;
            color: var(--admin-ink);
            font-size: clamp(32px, 5vw, 46px);
            font-weight: 900;
            line-height: 1.08;
            letter-spacing: 0;
        }

        .admin-login__intro {
            max-width: 420px;
            margin: 0 0 32px;
            color: var(--admin-muted);
            font-size: 16px;
            line-height: 1.65;
        }

        .admin-login__status,
        .admin-login__errors {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            background: #f8fbf9;
            color: var(--admin-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .admin-login__errors {
            border-color: #f0c6bd;
            background: #fff7f5;
            color: #9f321f;
        }

        .admin-login__errors ul {
            padding-left: 18px;
            margin: 0;
        }

        .admin-login__field {
            margin-bottom: 18px;
        }

        .admin-login__field label {
            display: block;
            margin-bottom: 8px;
            color: var(--admin-ink);
            font-size: 14px;
            font-weight: 800;
        }

        .admin-login__field input {
            width: 100%;
            height: 56px;
            border: 1px solid var(--admin-line);
            border-radius: 8px;
            outline: 0;
            padding: 0 18px;
            background: var(--admin-field);
            color: var(--admin-ink);
            font: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .admin-login__field input:focus {
            border-color: var(--admin-accent);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(47, 143, 70, 0.14);
        }

        .admin-login__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin: 4px 0 26px;
            color: var(--admin-muted);
            font-size: 14px;
        }

        .admin-login__check {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
        }

        .admin-login__check input {
            width: 17px;
            height: 17px;
            accent-color: var(--admin-accent);
        }

        .admin-login__submit {
            width: 100%;
            min-height: 58px;
            border: 0;
            border-radius: 8px;
            padding: 15px 24px;
            background: var(--admin-accent);
            color: #ffffff;
            font: inherit;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .admin-login__submit:hover,
        .admin-login__submit:focus {
            background: var(--admin-accent-dark);
            transform: translateY(-1px);
        }

        .admin-login__home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 28px;
            color: var(--admin-muted);
            font-size: 14px;
            font-weight: 800;
        }

        .admin-login__visual {
            position: relative;
            display: flex;
            align-items: flex-end;
            min-height: 100vh;
            padding: 48px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(17, 31, 22, 0.2), rgba(17, 31, 22, 0.82)),
                url("{{ asset('assets/images/banner/banner-two-bg.jpg') }}") center / cover no-repeat;
        }

        .admin-login__visual-content {
            position: relative;
            z-index: 1;
            max-width: 640px;
            color: #ffffff;
        }

        .admin-login__visual-content span {
            display: block;
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .admin-login__visual-content h2 {
            margin: 0;
            color: #ffffff;
            font-size: clamp(34px, 5vw, 64px);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: 0;
        }

        .admin-login__visual-content p {
            max-width: 520px;
            margin: 18px 0 0;
            color: rgba(255, 255, 255, 0.88);
            font-size: 17px;
            line-height: 1.65;
        }

        @media (max-width: 991px) {
            .admin-login {
                grid-template-columns: 1fr;
            }

            .admin-login__panel {
                min-height: 100vh;
            }

            .admin-login__visual {
                display: none;
            }
        }

        @media (max-width: 575px) {
            .admin-login__panel {
                padding: 34px 20px;
            }

            .admin-login__brand {
                margin-bottom: 34px;
            }

            .admin-login__meta {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <main class="admin-login">
        <section class="admin-login__panel" aria-labelledby="admin-login-title">
            <a class="admin-login__brand" href="{{ route('home') }}" aria-label="Charitia home">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Charitia">
            </a>

            <span class="admin-login__eyebrow">Admin Access</span>
            <h1 id="admin-login-title">Welcome back</h1>
            <p class="admin-login__intro">Sign in to manage campaigns, donations, updates, and supporter activity from the admin area.</p>

            @if (session('status'))
                <div class="admin-login__status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="admin-login__errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="post">
                @csrf

                <div class="admin-login__field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="admin@example.com" required autofocus>
                </div>

                <div class="admin-login__field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" placeholder="Enter password" required>
                </div>

                <div class="admin-login__meta">
                    <label class="admin-login__check" for="remember">
                        <input type="checkbox" id="remember" name="remember" value="1" @checked(old('remember'))>
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('coming-soon', ['menu' => 'forgot-password']) }}">Forgot password?</a>
                </div>

                <button class="admin-login__submit" type="submit">Sign in to admin</button>
            </form>

            <a class="admin-login__home" href="{{ route('home') }}">Back to website</a>
        </section>

        <section class="admin-login__visual" aria-hidden="true">
            <div class="admin-login__visual-content">
                <span>Charitia Admin</span>
                <h2>Keep every campaign moving with confidence.</h2>
                <p>Review activity, publish updates, and guide fundraising work from one focused admin entry point.</p>
            </div>
        </section>
    </main>
</body>
</html>
