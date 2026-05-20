<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Dashboard | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #932a19;
            --gold-dark: #b21f17;
            --gold-soft: #f7e1df;
            --bg: #f7f8fb;
            --panel: #ffffff;
            --line: #dde2ea;
            --ink: #121827;
            --muted: #647083;
            --green-soft: #e2f4e6;
            --green: #168231;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            min-width: 300px;
            border-right: 1px solid var(--line);
            padding: 30px 22px;
            background: #ffffff;
        }

        .brand {
            min-height: 44px;
            align-items: center;
        }

        .brand img {
            width: 154px;
            height: auto;
            display: block;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
            border-radius: 12px;
            padding: 13px 15px;
            color: #2f3a4c;
            font-weight: 800;
            line-height: 1.2;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .nav-link i {
            width: 20px;
            display: inline-flex;
            justify-content: center;
            line-height: 1;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gold-soft);
            color: #932a19;
            transform: translateX(4px);
        }

        .nav-link:focus,
        .nav-link:active {
            background: #efd1cd;
            color: #000000;
        }

        .main {
            min-width: 0;
            background: #f8f9fb;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid var(--line);
            padding: 22px clamp(18px, 3vw, 36px);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .topbar-inner,
        .content-inner {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        .content {
            padding: 28px clamp(18px, 2vw, 30px) 48px;
        }

        .stat-card,
        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
        }

        .stat-card {
            height: 100%;
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .stat-card[data-card-url] {
            cursor: pointer;
        }

        .stat-card__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat-card:hover {
            border-color: rgba(147, 42, 25, 0.74);
            transform: translateY(-4px);
        }

        .icon-box {
            width: 46px;
            height: 46px;
            display: inline-grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 12px;
            background: var(--gold-soft);
            color: var(--gold-dark);
        }

        .icon-box i {
            font-size: 16px;
            line-height: 1;
        }

        .stat-switch {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .stat-switch__button {
            width: 46px;
            height: 46px;
            display: inline-grid;
            place-items: center;
            flex: 0 0 auto;
            border: 0;
            border-radius: 12px;
            color: var(--gold-dark);
            background: var(--gold-soft);
            opacity: 0.5;
            transition: opacity 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-switch__button i {
            font-size: 16px;
            line-height: 1;
        }

        .stat-switch__button.is-active,
        .stat-switch__button:hover,
        .stat-switch__button:focus {
            opacity: 1;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(147, 42, 25, 0.12);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 24px;
            border-radius: 8px;
            padding: 5px 9px;
            line-height: 1;
        }

        .muted {
            color: var(--muted);
        }

        .panel {
            min-height: auto;
            padding: 28px !important;
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .chart-bars {
            height: 100%;
            min-height: 280px;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            align-items: end;
            gap: 16px;
            padding-top: 12px;
            border-bottom: 1px solid var(--line);
            background-image: repeating-linear-gradient(to top, transparent 0 63px, #e7ebf1 64px);
        }

        .chart-bar__columns {
            min-height: 0;
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 8px;
        }

        .chart-bar__fill {
            width: min(100%, 96px);
            min-height: 42px;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, #c94a35, var(--gold));
            box-shadow: 0 12px 28px rgba(147, 42, 25, 0.16);
            transition: height 0.25s ease, background 0.25s ease, width 0.25s ease, opacity 0.25s ease;
        }

        .chart-bar__fill--tip {
            display: none;
            background: linear-gradient(180deg, #f0b44d, #d9841f);
            box-shadow: 0 12px 28px rgba(217, 132, 31, 0.18);
        }

        .chart-bars.is-tip .chart-bar__fill--donation {
            background: linear-gradient(180deg, #f0b44d, #d9841f);
            box-shadow: 0 12px 28px rgba(217, 132, 31, 0.18);
        }

        .chart-bars.is-both .chart-bar__fill {
            width: min(45%, 46px);
        }

        .chart-bars.is-both .chart-bar__fill--tip {
            display: block;
        }

        .chart-bar {
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 8px;
            height: 100%;
            text-align: center;
            position: relative;
        }

        .chart-bar::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 50%;
            bottom: calc(100% + 8px);
            z-index: 2;
            min-width: 150px;
            max-width: 220px;
            border-radius: 10px;
            padding: 9px 11px;
            color: #ffffff;
            background: #071226;
            box-shadow: 0 14px 30px rgba(18, 24, 39, 0.22);
            font-size: 12px;
            font-weight: 900;
            line-height: 1.4;
            white-space: pre-line;
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, 6px);
            transition: opacity 0.18s ease, visibility 0.18s ease, transform 0.18s ease;
        }

        .growth-panel {
            display: flex;
            flex-direction: column;
        }

        .growth-panel .chart-bars {
            flex: 1;
        }

        .chart-bar:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }

        .chart-bar small {
            color: var(--muted);
            font-size: 12px;
            font-weight: 900;
        }

        .chart-controls {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }

        .chart-toggle {
            min-height: 34px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 7px 12px;
            color: var(--ink);
            background: #ffffff;
            font-weight: 900;
            line-height: 1;
        }

        .chart-toggle.is-active,
        .chart-toggle:hover,
        .chart-toggle:focus {
            border-color: var(--gold);
            color: #ffffff;
            background: var(--gold);
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .mini-stat {
            height: 100%;
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 24px;
            background: #ffffff;
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .mini-stat:hover {
            border-color: rgba(147, 42, 25, 0.74);
            transform: translateY(-4px);
        }

        .mini-stat__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .mini-stat__top > span {
            display: inline-flex;
        }

        .mini-stat__body span {
            display: block;
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 15px;
            font-weight: 400;
            line-height: 1.3;
            text-transform: none;
        }

        .mini-stat__body strong {
            display: block;
            color: var(--ink);
            font-size: 28px;
            font-weight: 800;
            line-height: 1.15;
        }

        .mini-stat__body {
            transform: translateY(2px);
        }

        .dashboard-section {
            margin-top: 24px;
        }

        .table-link {
            color: var(--gold);
            font-weight: 900;
            text-decoration: underline;
        }

        .text-clip {
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--ink);
            --bs-table-border-color: var(--line);
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table th {
            color: var(--ink);
            font-weight: 900;
            white-space: nowrap;
            padding-top: 14px;
            padding-bottom: 14px;
        }

        .table td {
            padding-top: 13px;
            padding-bottom: 13px;
        }

        .badge-gold {
            background: var(--green-soft);
            color: var(--green);
        }

        .profile-btn {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #ffffff;
            color: var(--ink);
            box-shadow: 0 4px 12px rgba(18, 24, 39, 0.06);
        }

        .profile-btn:hover,
        .profile-btn:focus,
        .profile-btn:active,
        .profile-btn.show,
        .profile-btn:first-child:active {
            border-color: rgba(147, 42, 25, 0.75);
            color: #000000;
            background: #efd1cd;
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.18);
        }

        .dropdown-menu {
            border: 1px solid var(--line);
            background: #ffffff;
            box-shadow: 0 14px 34px rgba(18, 24, 39, 0.12);
        }

        .dropdown-item {
            color: var(--ink);
        }

        .dropdown-item:hover {
            background: var(--gold-soft);
            color: #932a19;
        }

        .dropdown-item:focus,
        .dropdown-item:active {
            background: #efd1cd;
            color: #000000;
        }

        .profile-popup {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: grid;
            place-items: center;
            padding: 20px;
            background: rgba(18, 24, 39, 0.38);
            backdrop-filter: blur(8px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .profile-popup.is-open {
            opacity: 1;
            visibility: visible;
        }

        .profile-card {
            width: min(100%, 390px);
            border: 1px solid rgba(147, 42, 25, 0.36);
            border-radius: 18px;
            padding: 24px;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(18, 24, 39, 0.24);
            transform: translateY(12px) scale(0.98);
            transition: transform 0.2s ease;
        }

        .profile-popup.is-open .profile-card {
            transform: translateY(0) scale(1);
        }

        .profile-card__top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .profile-card__avatar {
            width: 54px;
            height: 54px;
            display: inline-grid;
            place-items: center;
            border-radius: 16px;
            color: #000000;
            background: var(--gold-soft);
            font-size: 22px;
        }

        .profile-card__close {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 12px;
            color: var(--ink);
            background: #ffffff;
        }

        .profile-card__close:hover,
        .profile-card__close:focus {
            border-color: rgba(147, 42, 25, 0.75);
            background: #efd1cd;
        }

        .profile-card__row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            border-top: 1px solid var(--line);
            padding: 14px 0;
        }

        .profile-card__row:last-child {
            padding-bottom: 0;
        }

        .btn-warning:hover,
        .btn-warning:focus,
        .btn-warning:active,
        .btn-warning:first-child:active {
            border-color: var(--gold-dark);
            color: #000000;
            background: var(--gold-dark);
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.22);
        }

        .btn-outline-warning:hover,
        .btn-outline-warning:focus,
        .btn-outline-warning:active,
        .btn-outline-warning:first-child:active {
            border-color: var(--gold-dark);
            color: #000000;
            background: #efd1cd;
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.18);
        }

        .mobile-toggle {
            display: none;
        }

        .topbar-actions {
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .topbar-actions form {
            margin: 0;
        }

        .topbar-actions .btn {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-warning,
        .btn-warning:focus {
            border-color: var(--gold);
            color: #ffffff !important;
            background: var(--gold);
        }

        .btn-warning:hover,
        .btn-warning:active,
        .btn-warning:first-child:active {
            border-color: var(--gold-dark);
            color: #ffffff !important;
            background: var(--gold-dark);
        }

        .btn-outline-warning {
            border-color: var(--gold);
            color: var(--gold);
        }

        @media (max-width: 1199px) {
            .admin-layout {
                grid-template-columns: 300px minmax(0, 1fr);
            }

            .sidebar {
                padding: 30px 22px;
            }

            .report-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 18px;
            }

            .stat-card {
                min-height: 158px;
                padding: 20px;
            }

            .panel-header {
                flex-direction: column;
                align-items: stretch;
            }

            .chart-controls {
                justify-content: flex-start;
            }
        }

        @media (max-width: 991px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }

            .report-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sidebar {
                position: fixed;
                z-index: 20;
                width: 280px;
                max-width: 84vw;
                height: 100dvh;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                box-shadow: 18px 0 40px rgba(18, 24, 39, 0.18);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .topbar-inner {
                align-items: flex-start !important;
                flex-wrap: wrap;
            }

            .topbar-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .content {
                padding-inline: 18px;
            }

            .table-responsive {
                border-radius: 12px;
            }

            .table-responsive table {
                min-width: 720px;
            }
        }

        @media (max-width: 575px) {
            .topbar {
                padding: 14px;
            }

            .content {
                padding: 16px 12px 30px;
            }

            .panel {
                min-height: auto;
                padding: 16px !important;
            }

            .chart-bars {
                min-height: 180px;
                gap: 8px;
                overflow-x: auto;
                grid-template-columns: repeat(8, minmax(44px, 1fr));
            }

            .report-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .stat-card {
                min-height: 140px;
                padding: 18px;
            }

            .stat-card__top,
            .mini-stat__top {
                margin-bottom: 12px;
            }

            .stat-switch__button,
            .icon-box {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .topbar-actions .btn,
            .profile-btn {
                min-height: 38px;
                font-size: 13px;
            }

            .chart-controls {
                gap: 6px;
            }

            .chart-toggle {
                flex: 1 1 calc(50% - 6px);
                min-height: 36px;
                padding-inline: 8px;
                font-size: 12px;
            }

            .profile-card {
                padding: 18px;
            }

            .text-clip {
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar" id="sidebar">
            <a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
            <nav>
                <a class="nav-link active" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-referrals.index') }}"><i class="fa-solid fa-hand-holding-heart"></i> Referrals</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-reports.index') }}"><i class="fa-solid fa-flag"></i> Reports</a>
                <a class="nav-link" href="{{ route('admin.events.index') }}"><i class="fa-solid fa-calendar-days"></i> Events</a>
                <a class="nav-link" href="{{ route('admin.blogs.index') }}"><i class="fa-solid fa-newspaper"></i> Blogs</a>
                <a class="nav-link" href="{{ route('admin.blog-categories.index') }}"><i class="fa-solid fa-tags"></i> Blog Categories</a>
                <a class="nav-link" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-user-tie"></i> Fundraisers</a>
                @if (auth()->user()?->hasPermission(\App\Support\AdminPermissions::USERS_MANAGE))
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users-gear"></i> Users</a>
                @endif
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-sm btn-outline-warning mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')" aria-label="Toggle sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div>
                            <p class="muted small mb-1">Admin dashboard</p>
                            <h1 class="h4 fw-black mb-0">Overview</h1>
                        </div>
                    </div>

                    <div class="topbar-actions d-flex align-items-center gap-2">
                        @include('admin.partials.activity-bell')
                        <div class="dropdown">
                            <button class="btn profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-circle text-warning"></i>
                                {{ auth()->user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="button" data-profile-open>Profile</button></li>
                            </ul>
                        </div>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-warning fw-bold" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="content">
                <div class="content-inner">
                <section class="mb-4">
                    <div class="report-grid">
                        <article class="stat-card" data-card-url="{{ route('admin.donations.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <div class="stat-switch" aria-label="Donation card type">
                                    <button class="stat-switch__button is-active" type="button" data-stat-switch="donation" data-label="Total donations" data-value="Rs. {{ number_format($totalDonations, 0) }}" data-badge="{{ $supporterCount }} paid" aria-label="Show total donations">
                                        <i class="fa-solid fa-wallet"></i>
                                    </button>
                                    <button class="stat-switch__button" type="button" data-stat-switch="donation" data-label="Tip amount" data-value="Rs. {{ number_format($totalTips, 0) }}" data-badge="Tips" aria-label="Show tip amount">
                                        <i class="fa-solid fa-coins"></i>
                                    </button>
                                </div>
                                <span class="badge badge-gold" data-stat-badge="donation">{{ $supporterCount }} paid</span>
                            </div>
                            <div>
                                <p class="muted mb-1" data-stat-label="donation">Total donations</p>
                                <h2 class="h3 fw-black mb-0" data-stat-value="donation">Rs. {{ number_format($totalDonations, 0) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.fundraiser-posts.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <div class="stat-switch" aria-label="Campaign card type">
                                    <button class="stat-switch__button is-active" type="button" data-stat-switch="campaign" data-label="Live campaigns" data-value="{{ number_format($liveCampaignCount) }}" data-badge="Live" aria-label="Show live campaigns">
                                        <i class="fa-solid fa-bullhorn"></i>
                                    </button>
                                    <button class="stat-switch__button" type="button" data-stat-switch="campaign" data-label="Pending campaigns" data-value="{{ number_format($pendingCampaignCount) }}" data-badge="Review" aria-label="Show pending campaigns">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </button>
                                </div>
                                <span class="badge badge-gold" data-stat-badge="campaign">Live</span>
                            </div>
                            <div>
                                <p class="muted mb-1" data-stat-label="campaign">Live campaigns</p>
                                <h2 class="h3 fw-black mb-0" data-stat-value="campaign">{{ number_format($liveCampaignCount) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.events.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <div class="stat-switch" aria-label="Event card type">
                                    <button class="stat-switch__button is-active" type="button" data-stat-switch="event" data-label="Published events" data-value="{{ number_format($publishedEventCount) }}" data-badge="Published" aria-label="Show published events">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </button>
                                    <button class="stat-switch__button" type="button" data-stat-switch="event" data-label="Draft events" data-value="{{ number_format($draftEventCount) }}" data-badge="Draft" aria-label="Show draft events">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                    </button>
                                </div>
                                <span class="badge badge-gold" data-stat-badge="event">Published</span>
                            </div>
                            <div>
                                <p class="muted mb-1" data-stat-label="event">Published events</p>
                                <h2 class="h3 fw-black mb-0" data-stat-value="event">{{ number_format($publishedEventCount) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.blogs.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <div class="stat-switch" aria-label="Blog card type">
                                    <button class="stat-switch__button is-active" type="button" data-stat-switch="blog" data-label="Published blogs" data-value="{{ number_format($publishedBlogCount) }}" data-badge="Published" aria-label="Show published blogs">
                                        <i class="fa-solid fa-newspaper"></i>
                                    </button>
                                    <button class="stat-switch__button" type="button" data-stat-switch="blog" data-label="Draft blogs" data-value="{{ number_format($draftBlogCount) }}" data-badge="Draft" aria-label="Show draft blogs">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </button>
                                </div>
                                <span class="badge badge-gold" data-stat-badge="blog">Published</span>
                            </div>
                            <div>
                                <p class="muted mb-1" data-stat-label="blog">Published blogs</p>
                                <h2 class="h3 fw-black mb-0" data-stat-value="blog">{{ number_format($publishedBlogCount) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.fundraiser-reports.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-user-shield"></i></span>
                                <span class="badge badge-gold">Supporter</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Supporter reports</p>
                                <h2 class="h3 fw-black mb-0">{{ number_format($supporterReportCount) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.fundraiser-referrals.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-hand-holding-heart"></i></span>
                                <span class="badge badge-gold">Requests</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Referral requests</p>
                                <h2 class="h3 fw-black mb-0">{{ number_format($referralCount) }}</h2>
                            </div>
                        </article>
                        <article class="stat-card" data-card-url="{{ route('admin.fundraisers.index') }}" tabindex="0" role="link">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-users-gear"></i></span>
                                <span class="badge badge-gold">Accounts</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Fundraisers</p>
                                <h2 class="h3 fw-black mb-0">{{ number_format($fundraiserCount) }}</h2>
                            </div>
                        </article>
                    </div>
                </section>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <section class="panel h-100 growth-panel">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Donations</p>
                                    <h2 class="h5 fw-black mb-0">Monthly growth</h2>
                                </div>
                                <div class="chart-controls" aria-label="Monthly growth chart type">
                                    <button class="chart-toggle is-active" type="button" data-chart-mode="donation">Total donation</button>
                                    <button class="chart-toggle" type="button" data-chart-mode="tip">Tip amount</button>
                                    <button class="chart-toggle" type="button" data-chart-mode="both">Both</button>
                                    <span class="badge badge-gold">{{ now()->year }}</span>
                                </div>
                            </div>
                            <div class="chart-bars" aria-hidden="true">
                                @foreach ($monthlyChart as $month)
                                    @php
                                        $initialHeight = max(12, (int) round(($month['donation'] / $monthlyChartMax) * 100));
                                    @endphp
                                    <div
                                        class="chart-bar"
                                        title="{{ $month['label'] }}: Rs. {{ number_format($month['donation'], 0) }}"
                                        data-chart-bar
                                        data-label="{{ $month['label'] }}"
                                        data-donation="{{ $month['donation'] }}"
                                        data-tip="{{ $month['tip'] }}"
                                        data-both="{{ $month['both'] }}"
                                        data-tooltip="{{ $month['label'] }}: Total donation Rs. {{ number_format($month['donation'], 0) }}"
                                    >
                                        <div class="chart-bar__columns">
                                            <span class="chart-bar__fill chart-bar__fill--donation" style="height: {{ $initialHeight }}%"></span>
                                            <span class="chart-bar__fill chart-bar__fill--tip" style="height: 12%"></span>
                                        </div>
                                        <small>{{ $month['label'] }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-5">
                        <section class="panel h-100">
                            <p class="muted small mb-1">Recent activity</p>
                            <h2 class="h5 fw-black mb-3">Latest updates</h2>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th>Status</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentActivity as $activity)
                                            <tr>
                                                <td class="text-clip">{{ $activity['activity'] }}</td>
                                                <td><span class="badge badge-gold">{{ $activity['status'] }}</span></td>
                                                <td class="muted">{{ $activity['time']->diffForHumans(null, true) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center muted py-4">No activity yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="row g-4 dashboard-section">
                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Donation data</p>
                                    <h2 class="h5 fw-black mb-0">Recent donations</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.donations.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Donor</th>
                                            <th>Campaign</th>
                                            <th>Main</th>
                                            <th>Tip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentDonations as $donation)
                                            <tr>
                                                <td>{{ $donation->publicDonorName() }}</td>
                                                <td class="text-clip">{{ $donation->fundraiserPost?->title ?? '-' }}</td>
                                                <td>Rs. {{ number_format((float) ($donation->main_amount ?: $donation->amount), 0) }}</td>
                                                <td>Rs. {{ number_format((float) $donation->tip_amount, 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center muted py-4">No donations yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Supporter report data</p>
                                    <h2 class="h5 fw-black mb-0">Recent supporter reports</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.fundraiser-reports.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Campaign</th>
                                            <th>Phone</th>
                                            <th>Document</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentReports as $report)
                                            <tr>
                                                <td>{{ $report->name ?: '-' }}</td>
                                                <td class="text-clip">{{ $report->fundraiserPost?->title ?? '-' }}</td>
                                                <td>{{ trim(($report->country_code ?? '') . ' ' . ($report->phone ?? '')) ?: '-' }}</td>
                                                <td>
                                                    @if ($report->supporting_document)
                                                        <a class="table-link" href="{{ asset('storage/' . $report->supporting_document) }}" target="_blank">View</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center muted py-4">No supporter reports yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Referral data</p>
                                    <h2 class="h5 fw-black mb-0">Referral requests</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.fundraiser-referrals.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentReferrals as $referral)
                                            <tr>
                                                <td class="text-clip">{{ $referral->name }}</td>
                                                <td class="text-clip">{{ $referral->reason ?: '-' }}</td>
                                                <td><span class="badge badge-gold">{{ ucfirst($referral->status) }}</span></td>
                                                <td class="muted">{{ $referral->created_at->format('d M') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center muted py-4">No referral requests yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Blog data</p>
                                    <h2 class="h5 fw-black mb-0">Recent blogs</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.blogs.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentBlogs as $blog)
                                            <tr>
                                                <td class="text-clip">{{ $blog->title }}</td>
                                                <td><span class="badge badge-gold">{{ ucfirst($blog->status) }}</span></td>
                                                <td class="muted">{{ $blog->created_at->format('d M') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center muted py-4">No blogs yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Event data</p>
                                    <h2 class="h5 fw-black mb-0">Recent events</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.events.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentEvents as $event)
                                            <tr>
                                                <td class="text-clip">{{ $event->title }}</td>
                                                <td><span class="badge badge-gold">{{ ucfirst($event->status) }}</span></td>
                                                <td class="muted">{{ $event->created_at->format('d M') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center muted py-4">No events yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Fundraiser data</p>
                                    <h2 class="h5 fw-black mb-0">Recent fundraisers</h2>
                                </div>
                                <a class="table-link" href="{{ route('admin.fundraisers.index') }}">View all</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentFundraisers as $fundraiser)
                                            <tr>
                                                <td class="text-clip">{{ $fundraiser->name }}</td>
                                                <td><span class="badge badge-gold">{{ ucfirst($fundraiser->status) }}</span></td>
                                                <td class="muted">{{ $fundraiser->created_at->format('d M') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center muted py-4">No fundraisers yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                </div>
            </section>
        </main>
    </div>

    <div class="profile-popup" data-profile-popup aria-hidden="true">
        <section class="profile-card" role="dialog" aria-modal="true" aria-labelledby="profile-popup-title">
            <div class="profile-card__top">
                <div class="d-flex align-items-center gap-3">
                    <span class="profile-card__avatar" aria-hidden="true"><i class="fa-solid fa-user"></i></span>
                    <div>
                        <p class="muted small mb-1">Signed in as</p>
                        <h2 class="h5 fw-black mb-0" id="profile-popup-title">{{ auth()->user()->name ?? 'Admin' }}</h2>
                    </div>
                </div>
                <button class="profile-card__close" type="button" data-profile-close aria-label="Close profile">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="profile-card__row">
                <span class="muted">Email</span>
                <strong>{{ auth()->user()->email ?? 'admin@example.com' }}</strong>
            </div>
            <div class="profile-card__row">
                <span class="muted">Role</span>
                <span class="badge badge-gold">Admin</span>
            </div>
            <div class="profile-card__row">
                <span class="muted">Panel</span>
                <strong>Karna Kabach</strong>
            </div>
        </section>
    </div>

    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (() => {
            const popup = document.querySelector('[data-profile-popup]');
            const openButton = document.querySelector('[data-profile-open]');
            const closeButton = document.querySelector('[data-profile-close]');

            if (!popup || !openButton || !closeButton) {
                return;
            }

            function openProfile() {
                popup.classList.add('is-open');
                popup.setAttribute('aria-hidden', 'false');
                closeButton.focus();
            }

            function closeProfile() {
                popup.classList.remove('is-open');
                popup.setAttribute('aria-hidden', 'true');
                openButton.focus();
            }

            openButton.addEventListener('click', openProfile);
            closeButton.addEventListener('click', closeProfile);

            popup.addEventListener('click', (event) => {
                if (event.target === popup) {
                    closeProfile();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && popup.classList.contains('is-open')) {
                    closeProfile();
                }
            });

            document.querySelectorAll('[data-stat-switch]').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.stopPropagation();
                    const stat = button.dataset.statSwitch;
                    const label = document.querySelector(`[data-stat-label="${stat}"]`);
                    const value = document.querySelector(`[data-stat-value="${stat}"]`);
                    const badge = document.querySelector(`[data-stat-badge="${stat}"]`);

                    document.querySelectorAll(`[data-stat-switch="${stat}"]`).forEach((item) => {
                        item.classList.toggle('is-active', item === button);
                    });

                    if (label) {
                        label.textContent = button.dataset.label || '';
                    }

                    if (value) {
                        value.textContent = button.dataset.value || '0';
                    }

                    if (badge) {
                        badge.textContent = button.dataset.badge || '';
                    }
                });
            });

            document.querySelectorAll('[data-card-url]').forEach((card) => {
                const openCard = () => {
                    const url = card.dataset.cardUrl;

                    if (url) {
                        window.location.href = url;
                    }
                };

                card.addEventListener('click', (event) => {
                    if (event.target.closest('button, a, input, select, textarea')) {
                        return;
                    }

                    openCard();
                });

                card.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openCard();
                    }
                });
            });

            const chartButtons = document.querySelectorAll('[data-chart-mode]');
            const chartBars = document.querySelectorAll('[data-chart-bar]');
            const chartContainer = document.querySelector('.chart-bars');

            function updateChart(mode) {
                chartButtons.forEach((button) => {
                    button.classList.toggle('is-active', button.dataset.chartMode === mode);
                });

                chartContainer?.classList.toggle('is-both', mode === 'both');
                chartContainer?.classList.toggle('is-tip', mode === 'tip');
                const modeMax = Math.max(...Array.from(chartBars).flatMap((bar) => {
                    if (mode === 'both') {
                        return [Number(bar.dataset.donation) || 0, Number(bar.dataset.tip) || 0];
                    }

                    return [Number(bar.dataset[mode]) || 0];
                }), 1);

                chartBars.forEach((bar) => {
                    const donationValue = Number(bar.dataset.donation) || 0;
                    const tipValue = Number(bar.dataset.tip) || 0;
                    const singleValue = mode === 'tip' ? tipValue : donationValue;
                    const donationHeight = donationValue > 0 ? Math.max(12, Math.round((donationValue / modeMax) * 100)) : 12;
                    const tipHeight = tipValue > 0 ? Math.max(12, Math.round((tipValue / modeMax) * 100)) : 12;
                    const singleHeight = singleValue > 0 ? Math.max(12, Math.round((singleValue / modeMax) * 100)) : 12;
                    const donationFill = bar.querySelector('.chart-bar__fill--donation');
                    const tipFill = bar.querySelector('.chart-bar__fill--tip');
                    const formatter = new Intl.NumberFormat('en-IN');

                    if (donationFill) {
                        donationFill.style.height = `${mode === 'both' ? donationHeight : singleHeight}%`;
                    }

                    if (tipFill) {
                        tipFill.style.height = `${tipHeight}%`;
                    }

                    if (mode === 'both') {
                        bar.dataset.tooltip = `${bar.dataset.label}\nDonation: Rs. ${formatter.format(donationValue)}\nTip: Rs. ${formatter.format(tipValue)}`;
                        bar.title = `${bar.dataset.label}: Donation Rs. ${formatter.format(donationValue)}, Tip Rs. ${formatter.format(tipValue)}`;
                        return;
                    }

                    const label = mode === 'tip' ? 'Tip amount' : 'Total donation';
                    bar.dataset.tooltip = `${bar.dataset.label}\n${label}: Rs. ${formatter.format(singleValue)}`;
                    bar.title = `${bar.dataset.label}: ${label} Rs. ${formatter.format(singleValue)}`;
                });
            }

            chartButtons.forEach((button) => {
                button.addEventListener('click', () => updateChart(button.dataset.chartMode || 'donation'));
            });

            updateChart('donation');
        })();
    </script>
</body>
</html>

