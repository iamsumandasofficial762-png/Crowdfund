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
            --gold: #ffb33f;
            --gold-dark: #f5a400;
            --gold-soft: #fff3dd;
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
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid var(--line);
            padding: 24px 18px;
            background: #ffffff;
        }

        .brand img {
            width: 142px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            padding: 12px 14px;
            color: #2f3a4c;
            font-weight: 800;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gold-soft);
            color: #ff7a00;
            transform: translateX(4px);
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
            padding: 18px clamp(16px, 3vw, 32px);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .content {
            padding: clamp(16px, 3vw, 32px);
        }

        .stat-card,
        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
        }

        .stat-card {
            padding: 20px;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .stat-card:hover {
            border-color: rgba(255, 179, 63, 0.74);
            transform: translateY(-4px);
        }

        .icon-box {
            width: 44px;
            height: 44px;
            display: inline-grid;
            place-items: center;
            border-radius: 10px;
            background: var(--gold-soft);
            color: var(--gold-dark);
        }

        .muted {
            color: var(--muted);
        }

        .chart-bars {
            height: 260px;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            align-items: end;
            gap: 14px;
            padding-top: 24px;
            border-bottom: 1px solid var(--line);
            background-image: repeating-linear-gradient(to top, transparent 0 63px, #e7ebf1 64px);
        }

        .chart-bars span {
            min-height: 42px;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, #ffd27a, var(--gold));
            box-shadow: 0 12px 28px rgba(255, 179, 63, 0.16);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--ink);
            --bs-table-border-color: var(--line);
            margin-bottom: 0;
        }

        .table th {
            color: var(--ink);
            font-weight: 900;
        }

        .badge-gold {
            background: var(--green-soft);
            color: var(--green);
        }

        .profile-btn {
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #ffffff;
            color: var(--ink);
            box-shadow: 0 4px 12px rgba(18, 24, 39, 0.06);
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
            color: #ff7a00;
        }

        .mobile-toggle {
            display: none;
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
                <a class="nav-link" href="#"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-users"></i> Supporters</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-warning mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')" aria-label="Toggle sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <p class="muted small mb-1">Admin dashboard</p>
                        <h1 class="h4 fw-black mb-0">Overview</h1>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle me-2 text-warning"></i>
                            {{ auth()->user()->name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                        </ul>
                    </div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-sm btn-warning fw-bold" type="submit">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="content">
                <div class="row g-3 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="icon-box"><i class="fa-solid fa-wallet"></i></span>
                                <span class="badge badge-gold">+18%</span>
                            </div>
                            <p class="muted mb-1">Total donations</p>
                            <h2 class="h3 fw-black mb-0">Rs. 12.8L</h2>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="icon-box"><i class="fa-solid fa-bullhorn"></i></span>
                                <span class="badge badge-gold">42 live</span>
                            </div>
                            <p class="muted mb-1">Campaigns</p>
                            <h2 class="h3 fw-black mb-0">128</h2>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="icon-box"><i class="fa-solid fa-user-plus"></i></span>
                                <span class="badge badge-gold">+9%</span>
                            </div>
                            <p class="muted mb-1">New supporters</p>
                            <h2 class="h3 fw-black mb-0">3,482</h2>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <article class="stat-card">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="icon-box"><i class="fa-solid fa-chart-line"></i></span>
                                <span class="badge badge-gold">94%</span>
                            </div>
                            <p class="muted mb-1">Success rate</p>
                            <h2 class="h3 fw-black mb-0">High</h2>
                        </article>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-7">
                        <section class="panel p-4 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
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
                        <section class="panel p-4 h-100">
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
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
