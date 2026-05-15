<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraiser Referrals | Admin</title>
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
            --ink: #071226;
            --muted: #647083;
            --soft: #fdf5f3;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 88% 4%, rgba(147, 42, 25, 0.12), transparent 26%),
                var(--bg);
        }

        a { text-decoration: none; }

        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            padding: 24px;
            border-right: 1px solid var(--line);
            background: #ffffff;
        }

        .brand img {
            width: 154px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--ink);
            font-weight: 900;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #932a19;
            background: var(--gold-soft);
        }

        .main {
            min-width: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
        }

        .topbar-inner {
            padding: 18px 24px;
        }

        .content {
            padding: 24px;
        }

        .content-inner {
            max-width: 1320px;
            margin-inline: auto;
        }

        .panel,
        .referral-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--panel);
            box-shadow: 0 14px 34px rgba(18, 24, 39, 0.07);
        }

        .panel {
            padding: 20px;
        }

        .page-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(260px, 0.75fr);
            gap: 18px;
            align-items: stretch;
            margin-bottom: 24px;
        }

        .hero-card {
            border: 1px solid rgba(147, 42, 25, 0.24);
            border-radius: 20px;
            padding: 26px;
            background: linear-gradient(135deg, #ffffff 0%, #fff7f5 100%);
            box-shadow: 0 18px 44px rgba(18, 24, 39, 0.08);
        }

        .hero-card__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            border-radius: 999px;
            padding: 7px 11px;
            color: var(--gold);
            background: var(--gold-soft);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .hero-card h2 {
            margin: 0 0 8px;
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 900;
            letter-spacing: 0;
        }

        .hero-card p {
            max-width: 680px;
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.65;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .stat-tile {
            min-height: 118px;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 18px;
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(18, 24, 39, 0.06);
        }

        .stat-tile span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .stat-tile strong {
            display: block;
            margin-top: 8px;
            color: var(--ink);
            font-size: 30px;
            font-weight: 900;
        }

        .filter-link {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 9px 14px;
            color: var(--ink);
            background: #ffffff;
            font-weight: 900;
        }

        .filter-link.active,
        .filter-link:hover {
            border-color: rgba(147, 42, 25, 0.45);
            background: var(--gold-soft);
            color: var(--gold);
        }

        .filter-link span {
            border-radius: 999px;
            padding: 2px 7px;
            background: #ffffff;
            color: var(--muted);
            font-size: 12px;
        }

        .referral-card {
            height: 100%;
            padding: 0;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .referral-card:hover {
            border-color: rgba(147, 42, 25, 0.38);
            transform: translateY(-3px);
            box-shadow: 0 20px 48px rgba(18, 24, 39, 0.12);
        }

        .referral-card__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding: 22px 22px 18px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(90deg, #ffffff, #fff9f8);
        }

        .referral-person {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .referral-avatar {
            width: 52px;
            height: 52px;
            flex: 0 0 auto;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            background: var(--gold-soft);
            font-size: 20px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .referral-person h2 {
            margin: 0 0 4px;
            font-size: 20px;
            font-weight: 900;
        }

        .referral-card__body {
            padding: 20px 22px 22px;
        }

        .referral-card__meta {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            flex-wrap: wrap;
        }

        .referral-actions {
            display: flex;
            align-items: stretch;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .referral-actions form {
            margin: 0;
        }

        .referral-action-btn {
            min-height: 38px;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 8px 11px;
            color: var(--ink);
            background: #ffffff;
            font-size: 13px;
            font-weight: 900;
        }

        .referral-action-btn:hover,
        .referral-action-btn.active {
            border-color: rgba(147, 42, 25, 0.5);
            color: var(--gold);
            background: var(--gold-soft);
        }

        .referral-action-btn.delete {
            border-color: #f1b7b7;
            color: #b42318;
        }

        .referral-action-btn.delete:hover {
            color: #ffffff;
            background: #b42318;
        }

        .status-badge {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 10px;
            color: #932a19;
            background: var(--gold-soft);
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .muted {
            color: var(--muted);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .detail-box {
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 13px 14px;
            background: #fbfcfe;
            min-height: 82px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .detail-box span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }

        .detail-box strong {
            display: block;
            margin-top: 3px;
            color: var(--ink);
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .detail-box--wide {
            grid-column: 1 / -1;
        }

        .btn-warning {
            border-color: var(--gold);
            color: #ffffff !important;
            background: var(--gold);
            font-weight: 900;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .topbar-actions form {
            margin: 0;
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
        .profile-btn.show {
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

        .dropdown-item:hover {
            color: var(--gold);
            background: var(--gold-soft);
        }

        .empty-panel {
            min-height: 280px;
            display: grid;
            place-items: center;
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
            .admin-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .page-hero {
                grid-template-columns: 1fr;
            }

            .detail-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575px) {
            .stats-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-box--wide {
                grid-column: auto;
            }

            .referral-card__head {
                flex-direction: column;
            }

            .referral-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .referral-action-btn {
                flex: 1 1 130px;
            }

            .content {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
            <nav>
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
                <a class="nav-link active" href="{{ route('admin.fundraiser-referrals.index') }}"><i class="fa-solid fa-hand-holding-heart"></i> Referrals</a>
                <a class="nav-link" href="{{ route('admin.contact-messages.index') }}"><i class="fa-solid fa-envelope"></i> Contact Messages</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-reports.index') }}"><i class="fa-solid fa-flag"></i> Reports</a>
                <a class="nav-link" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.supporters.index') }}"><i class="fa-solid fa-users"></i> Supporters</a>
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div>
                        <p class="muted small mb-1">Referral leads</p>
                        <h1 class="h4 fw-black mb-0">Fundraiser Referrals</h1>
                    </div>
                    <div class="topbar-actions">
                        <div class="dropdown">
                            <button class="btn profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-circle text-warning"></i>
                                {{ auth()->user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Profile</a></li>
                            </ul>
                        </div>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-sm btn-warning fw-bold" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="content">
                <div class="content-inner">
                    <section class="page-hero">
                        <div class="hero-card">
                            <span class="hero-card__eyebrow"><i class="fa-solid fa-hand-holding-heart"></i> Referral leads</span>
                            <h2>Fundraiser Referrals</h2>
                            <p>Review people who asked for fundraising help from the public campaign page. Use the details here to call them back, understand the need, and help them start a verified fundraiser.</p>
                        </div>
                        <div class="stats-grid">
                            <article class="stat-tile">
                                <span>Total leads</span>
                                <strong>{{ number_format($counts['all']) }}</strong>
                            </article>
                            <article class="stat-tile">
                                <span>New leads</span>
                                <strong>{{ number_format($counts['new']) }}</strong>
                            </article>
                            <article class="stat-tile">
                                <span>Contacted</span>
                                <strong>{{ number_format($counts['contacted']) }}</strong>
                            </article>
                            <article class="stat-tile">
                                <span>Closed</span>
                                <strong>{{ number_format($counts['closed']) }}</strong>
                            </article>
                        </div>
                    </section>

                    <section class="panel mb-4">
                        @if (session('status'))
                            <div class="alert alert-success alert-auto-dismiss mb-3" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                            <div>
                                <h2 class="h5 fw-black mb-1">Lead status</h2>
                                <p class="muted mb-0">Filter referral requests by follow-up stage.</p>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                            @foreach (['all' => 'All', 'new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'] as $key => $label)
                                <a class="filter-link {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.fundraiser-referrals.index', ['status' => $key]) }}">
                                    {{ $label }}
                                    <span>{{ $counts[$key] }}</span>
                                </a>
                            @endforeach
                            </div>
                        </div>
                    </section>

                    <div class="row g-4">
                        @forelse ($referrals as $referral)
                            @php
                                $initial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($referral->name, 0, 1));
                            @endphp
                            <div class="col-12">
                                <article class="referral-card">
                                    <div class="referral-card__head">
                                        <div class="referral-person">
                                            <span class="referral-avatar">{{ $initial }}</span>
                                            <div>
                                                <h2>{{ $referral->name }}</h2>
                                                <p class="muted mb-0">{{ $referral->created_at->format('d M Y, h:i A') }}</p>
                                            </div>
                                        </div>
                                        <div class="referral-card__meta">
                                            <span class="status-badge">{{ $referral->status }}</span>
                                            <div class="referral-actions" aria-label="Referral actions">
                                                @foreach (['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'] as $statusKey => $statusLabel)
                                                    <form action="{{ route('admin.fundraiser-referrals.status', $referral) }}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $statusKey }}">
                                                        <button class="referral-action-btn {{ $referral->status === $statusKey ? 'active' : '' }}" type="submit" @disabled($referral->status === $statusKey)>{{ $statusLabel }}</button>
                                                    </form>
                                                @endforeach
                                                <form action="{{ route('admin.fundraiser-referrals.destroy', $referral) }}" method="post" onsubmit="return confirm('Delete this referral?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="referral-action-btn delete" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="referral-card__body">
                                        <div class="detail-grid">
                                            <div class="detail-box">
                                                <span>Phone</span>
                                                <strong>{{ $referral->country_code }} {{ $referral->phone }}</strong>
                                            </div>
                                            <div class="detail-box">
                                                <span>Alternate Phone</span>
                                                <strong>{{ $referral->alternate_phone ? ($referral->alternate_country_code . ' ' . $referral->alternate_phone) : 'Not provided' }}</strong>
                                            </div>
                                            <div class="detail-box">
                                                <span>Preferred Language</span>
                                                <strong>{{ $referral->preferred_language }}</strong>
                                            </div>
                                            <div class="detail-box">
                                                <span>Reason</span>
                                                <strong>{{ $referral->reason }}</strong>
                                            </div>
                                            <div class="detail-box">
                                                <span>Estimated Cost</span>
                                                <strong>{{ $referral->estimated_cost }}</strong>
                                            </div>
                                            <div class="detail-box detail-box--wide">
                                                <span>Source Campaign</span>
                                                <strong>{{ $referral->fundraiserPost?->title ?: 'General referral' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <section class="panel empty-panel text-center p-5">
                                    <div>
                                        <h2 class="h5 fw-black">No referrals found.</h2>
                                        <p class="muted mb-0">Submitted referral forms will appear here.</p>
                                    </div>
                                </section>
                            </div>
                        @endforelse
                    </div>

                    @if ($referrals->hasPages())
                        <section class="panel mt-4">
                            {{ $referrals->links() }}
                        </section>
                    @endif
                </div>
            </section>
        </main>
    </div>
    <script>
        document.querySelectorAll('[data-auto-dismiss]').forEach((alert) => {
            const delay = Number(alert.dataset.autoDismiss) || 3500;

            window.setTimeout(() => {
                alert.classList.add('is-hiding');
                window.setTimeout(() => alert.remove(), 400);
            }, delay);
        });
    </script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
