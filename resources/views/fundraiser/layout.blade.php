<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fundraiser Dashboard') | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #ffb33f;
            --gold-soft: #fff5e4;
            --ink: #071226;
            --muted: #647083;
            --line: #dde2ea;
            --panel: #ffffff;
            --page: #f7f8fb;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 82% 10%, rgba(255, 179, 63, 0.18), transparent 28%),
                var(--page);
        }

        a {
            text-decoration: none;
        }

        .fundraiser-topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .fundraiser-brand img {
            width: 156px;
        }

        .fundraiser-shell {
            padding: 34px 0 56px;
        }

        .fundraiser-nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .fundraiser-nav a,
        .logout-button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--ink);
            background: #ffffff;
            font-weight: 900;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .fundraiser-nav a:hover,
        .fundraiser-nav a.active,
        .logout-button:hover {
            border-color: rgba(255, 179, 63, 0.75);
            color: #000000;
            background: var(--gold-soft);
            box-shadow: 0 14px 28px rgba(255, 179, 63, 0.18);
            transform: translateY(-1px);
        }

        .logout-button {
            border-color: rgba(255, 179, 63, 0.7);
            background: var(--gold);
        }

        .dashboard-panel {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--panel);
            box-shadow: 0 18px 50px rgba(18, 24, 39, 0.08);
        }

        .dashboard-card {
            height: 100%;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(18, 24, 39, 0.06);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .dashboard-card:hover {
            border-color: rgba(255, 179, 63, 0.65);
            transform: translateY(-4px);
            box-shadow: 0 20px 46px rgba(18, 24, 39, 0.12);
        }

        .icon-pill {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #000000;
            background: var(--gold);
            font-size: 22px;
        }

        .btn-gold {
            min-height: 46px;
            border: 0;
            border-radius: 12px;
            color: #000000;
            background: var(--gold);
            font-weight: 900;
        }

        .btn-soft {
            min-height: 42px;
            border: 1px solid rgba(255, 179, 63, 0.55);
            border-radius: 12px;
            color: var(--ink);
            background: var(--gold-soft);
            font-weight: 900;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 10px;
            border-color: var(--line);
            font-weight: 700;
        }

        textarea.form-control {
            min-height: 150px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(255, 179, 63, 0.18);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-badge.pending {
            color: #8a5400;
            background: #fff3d6;
        }

        .status-badge.approved {
            color: #137333;
            background: #dff7e7;
        }

        .status-badge.rejected {
            color: #a12828;
            background: #ffe1e1;
        }

        .fundraiser-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #eef1f5;
        }

        .progress {
            height: 9px;
            border-radius: 999px;
            background: #edf0f5;
        }

        .progress-bar {
            background: #000000;
        }

        .muted {
            color: var(--muted);
        }

        @media (max-width: 767px) {
            .fundraiser-brand img {
                width: 132px;
            }

            .fundraiser-nav {
                width: 100%;
            }

            .fundraiser-nav a,
            .logout-button {
                flex: 1 1 auto;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="fundraiser-topbar py-3">
        <div class="container d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <a class="fundraiser-brand" href="{{ route('fundraiser.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
            <nav class="fundraiser-nav">
                <a class="{{ request()->routeIs('fundraiser.dashboard') ? 'active' : '' }}" href="{{ route('fundraiser.dashboard') }}">
                    <i class="fa-solid fa-table-cells-large"></i> Dashboard
                </a>
                <a class="{{ request()->routeIs('fundraiser.posts.create') ? 'active' : '' }}" href="{{ route('fundraiser.posts.create') }}">
                    <i class="fa-solid fa-plus"></i> Create Post
                </a>
                <a class="{{ request()->routeIs('fundraiser.posts.index', 'fundraiser.posts.show', 'fundraiser.posts.edit') ? 'active' : '' }}" href="{{ route('fundraiser.posts.index') }}">
                    <i class="fa-solid fa-rectangle-list"></i> My Posts
                </a>
                <form action="{{ route('fundraiser.logout') }}" method="post">
                    @csrf
                    <button class="logout-button" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="fundraiser-shell">
        <div class="container">
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

            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
