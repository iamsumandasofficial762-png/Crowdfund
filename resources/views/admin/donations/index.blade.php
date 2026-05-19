<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations | Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root { --gold:#932a19; --gold-soft:#f7e1df; --bg:#f7f8fb; --line:#dde2ea; --ink:#071226; --muted:#647083; }
        body { margin:0; color:var(--ink); background:var(--bg); font-family:Nunito, system-ui, sans-serif; }
        a { text-decoration:none; }
        .admin-layout { min-height:100vh; display:grid; grid-template-columns:280px 1fr; }
        .sidebar { padding:24px; border-right:1px solid var(--line); background:#fff; }
        .brand img { width:154px; }
        .nav-link { display:flex; align-items:center; gap:10px; margin-bottom:8px; border-radius:12px; padding:12px 14px; color:var(--ink); font-weight:900; }
        .nav-link:hover,.nav-link.active { color:var(--gold); background:var(--gold-soft); }
        .topbar { border-bottom:1px solid var(--line); background:#fff; }
        .topbar-inner,.content { padding:24px; }
        .topbar-actions { display:flex; align-items:center; gap:8px; flex-wrap:wrap; justify-content:flex-end; }
        .topbar-actions form { margin:0; }
        .profile-btn { min-height:40px; display:inline-flex; align-items:center; gap:6px; border:1px solid var(--line); border-radius:999px; color:var(--ink); background:#fff; box-shadow:0 4px 12px rgba(18,24,39,.06); }
        .profile-btn:hover,.profile-btn:focus,.profile-btn:active,.profile-btn.show { border-color:rgba(147,42,25,.75); color:#000; background:#efd1cd; box-shadow:0 12px 24px rgba(147,42,25,.18); }
        .dropdown-menu { border:1px solid var(--line); box-shadow:0 14px 34px rgba(18,24,39,.12); }
        .dropdown-item:hover { color:var(--gold); background:var(--gold-soft); }
        .btn-warning,.btn-warning:focus { border-color:var(--gold); color:#fff !important; background:var(--gold); }
        .btn-warning:hover,.btn-warning:active { border-color:#b21f17; color:#fff !important; background:#b21f17; }
        .panel { border:1px solid var(--line); border-radius:18px; background:#fff; box-shadow:0 14px 34px rgba(18,24,39,.07); }
        .summary-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:38px; margin:0 8px 34px; }
        .summary-card { min-height:196px; display:flex; align-items:center; justify-content:space-between; gap:28px; border:1px solid var(--line); border-radius:22px; padding:38px 54px; background:#fff; box-shadow:0 16px 36px rgba(18,24,39,.08); }
        .summary-card__body { min-width:0; }
        .summary-card__label { display:block; color:var(--muted); font-size:26px; line-height:1.2; font-weight:900; }
        .summary-card__value { display:block; margin-top:22px; color:var(--ink); font-size:48px; line-height:1.05; font-weight:900; white-space:nowrap; }
        .summary-card__icon { width:82px; height:82px; display:inline-flex; align-items:center; justify-content:center; flex:0 0 82px; border-radius:18px; color:#607185; background:var(--gold-soft); }
        .summary-card__icon i { display:block; margin:0; font-size:36px; line-height:1; }
        .text-clip { max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        @media (max-width: 1400px) { .summary-grid { gap:24px; } .summary-card { padding:32px 36px; } .summary-card__value { font-size:40px; } .summary-card__label { font-size:22px; } }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } .summary-grid { grid-template-columns:1fr; gap:18px; margin:0 0 24px; } .summary-card { min-height:160px; padding:28px; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach"></a>
            <nav>
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-referrals.index') }}"><i class="fa-solid fa-hand-holding-heart"></i> Referrals</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-reports.index') }}"><i class="fa-solid fa-flag"></i> Reports</a>
                <a class="nav-link" href="{{ route('admin.events.index') }}"><i class="fa-solid fa-calendar-days"></i> Events</a>
                <a class="nav-link" href="{{ route('admin.blogs.index') }}"><i class="fa-solid fa-newspaper"></i> Blogs</a>
                <a class="nav-link" href="{{ route('admin.blog-categories.index') }}"><i class="fa-solid fa-tags"></i> Blog Categories</a>
                <a class="nav-link active" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-user-tie"></i> Fundraisers</a>
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-muted small mb-1">Donation records</p>
                        <h1 class="h4 fw-bold mb-0">Donations</h1>
                    </div>
                    <div class="topbar-actions">
                        @include('admin.partials.activity-bell')
                        <div class="dropdown">
                            <button class="btn profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-circle text-warning"></i>
                                {{ auth()->user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Profile</a></li>
                            </ul>
                        </div>
                        <form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-warning fw-bold" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form>
                    </div>
                </div>
            </header>

            <div class="content">
                <div class="summary-grid">
                    <article class="summary-card">
                        <div class="summary-card__body">
                            <span class="summary-card__label">Total amount</span>
                            <strong class="summary-card__value">Rs. {{ number_format($totalAmount, 0) }}</strong>
                        </div>
                        <span class="summary-card__icon"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                    </article>
                    <article class="summary-card">
                        <div class="summary-card__body">
                            <span class="summary-card__label">Main amount</span>
                            <strong class="summary-card__value">Rs. {{ number_format($mainAmount, 0) }}</strong>
                        </div>
                        <span class="summary-card__icon"><i class="fa-solid fa-hand-holding-heart"></i></span>
                    </article>
                    <article class="summary-card">
                        <div class="summary-card__body">
                            <span class="summary-card__label">Tip amount</span>
                            <strong class="summary-card__value">Rs. {{ number_format($tipAmount, 0) }}</strong>
                        </div>
                        <span class="summary-card__icon"><i class="fa-solid fa-coins"></i></span>
                    </article>
                </div>

                <div class="panel table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Donor</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Campaign</th>
                                <th>Main</th>
                                <th>Tip</th>
                                <th>Total</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donations as $donation)
                                <tr>
                                    <td>#{{ $donation->id }}</td>
                                    <td>{{ $donation->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $donation->publicDonorName() }}</td>
                                    <td>{{ $donation->donor_email ?: '-' }}</td>
                                    <td>{{ $donation->donor_phone ?: '-' }}</td>
                                    <td class="text-clip">
                                        @if ($donation->fundraiserPost)
                                            <a class="fw-bold" href="{{ route('donate-us', $donation->fundraiserPost) }}" target="_blank" title="{{ $donation->fundraiserPost->title }}">{{ $donation->fundraiserPost->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Rs. {{ number_format((float) ($donation->main_amount ?: $donation->amount), 0) }}</td>
                                    <td>Rs. {{ number_format((float) $donation->tip_amount, 0) }}</td>
                                    <td>Rs. {{ number_format((float) $donation->amount, 0) }}</td>
                                    <td>{{ ucfirst($donation->payment_method ?: '-') }}</td>
                                    <td>{{ ucfirst($donation->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="11" class="text-center text-muted py-5">No donations yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $donations->links() }}</div>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>



