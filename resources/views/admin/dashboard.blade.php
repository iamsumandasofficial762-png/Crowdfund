<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Dashboard | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
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
            min-height: 390px;
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
            height: 270px;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            align-items: end;
            gap: 16px;
            padding-top: 24px;
            border-bottom: 1px solid var(--line);
            background-image: repeating-linear-gradient(to top, transparent 0 63px, #e7ebf1 64px);
        }

        .chart-bars span {
            min-height: 42px;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, #c94a35, var(--gold));
            box-shadow: 0 12px 28px rgba(147, 42, 25, 0.16);
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

        @media (max-width: 991px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                z-index: 20;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 575px) {
            .topbar {
                padding: 16px;
            }

            .content {
                padding: 18px 16px 32px;
            }

            .panel {
                min-height: auto;
                padding: 20px !important;
            }

            .chart-bars {
                height: 220px;
                gap: 8px;
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
                <a class="nav-link" href="#"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-users"></i> Supporters</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
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
                            <button class="btn btn-sm btn-warning fw-bold" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="content">
                <div class="content-inner">
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-wallet"></i></span>
                                <span class="badge badge-gold">+18%</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Total donations</p>
                                <h2 class="h3 fw-black mb-0">Rs. 12.8L</h2>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-bullhorn"></i></span>
                                <span class="badge badge-gold">42 live</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Campaigns</p>
                                <h2 class="h3 fw-black mb-0">128</h2>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-user-plus"></i></span>
                                <span class="badge badge-gold">+9%</span>
                            </div>
                            <div>
                                <p class="muted mb-1">New supporters</p>
                                <h2 class="h3 fw-black mb-0">3,482</h2>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="stat-card__top">
                                <span class="icon-box"><i class="fa-solid fa-chart-line"></i></span>
                                <span class="badge badge-gold">94%</span>
                            </div>
                            <div>
                                <p class="muted mb-1">Success rate</p>
                                <h2 class="h3 fw-black mb-0">High</h2>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <section class="panel h-100">
                            <div class="panel-header">
                                <div>
                                    <p class="muted small mb-1">Donations</p>
                                    <h2 class="h5 fw-black mb-0">Monthly growth</h2>
                                </div>
                                <span class="badge badge-gold">2026</span>
                            </div>
                            <div class="chart-bars" aria-hidden="true">
                                <span style="height: 46%"></span>
                                <span style="height: 66%"></span>
                                <span style="height: 52%"></span>
                                <span style="height: 78%"></span>
                                <span style="height: 62%"></span>
                                <span style="height: 88%"></span>
                                <span style="height: 73%"></span>
                                <span style="height: 96%"></span>
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
                                        <tr>
                                            <td>Medical campaign approved</td>
                                            <td><span class="badge badge-gold">Live</span></td>
                                            <td class="muted">10 min</td>
                                        </tr>
                                        <tr>
                                            <td>Donation received</td>
                                            <td><span class="badge badge-gold">Paid</span></td>
                                            <td class="muted">28 min</td>
                                        </tr>
                                        <tr>
                                            <td>Beneficiary document uploaded</td>
                                            <td><span class="badge badge-gold">Review</span></td>
                                            <td class="muted">1 hr</td>
                                        </tr>
                                        <tr>
                                            <td>Campaign story updated</td>
                                            <td><span class="badge badge-gold">Done</span></td>
                                            <td class="muted">2 hrs</td>
                                        </tr>
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
        })();
    </script>
</body>
</html>
