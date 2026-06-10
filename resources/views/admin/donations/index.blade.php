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
        .admin-layout { min-height:100vh; display:grid; grid-template-columns:300px minmax(0,1fr); }
        .sidebar { position:sticky; top:0; height:100vh; min-width:300px; padding:30px 22px; border-right:1px solid var(--line); background:#fff; }
        .brand img { width:154px; }
        .nav-link { display:flex; align-items:center; gap:12px; margin-bottom:10px; border-radius:12px; padding:13px 15px; color:#2f3a4c; font-weight:800; line-height:1.2; }
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
        .summary-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:24px; margin:0 0 34px; }
        .summary-card { min-height:176px; display:flex; align-items:center; justify-content:space-between; gap:22px; min-width:0; border:1px solid var(--line); border-radius:22px; padding:32px; background:#fff; box-shadow:0 16px 36px rgba(18,24,39,.08); }
        .summary-card__body { min-width:0; }
        .summary-card__label { display:block; color:var(--muted); font-size:clamp(18px,1.5vw,26px); line-height:1.2; font-weight:900; }
        .summary-card__value { display:block; margin-top:18px; color:var(--ink); font-size:clamp(30px,2.8vw,48px); line-height:1.05; font-weight:900; overflow-wrap:anywhere; }
        .summary-card__icon { width:76px; height:76px; display:inline-flex; align-items:center; justify-content:center; flex:0 0 76px; border-radius:18px; color:#607185; background:var(--gold-soft); }
        .summary-card__icon i { display:block; margin:0; font-size:34px; line-height:1; }
        .donations-panel { overflow:hidden; }
        .donations-table { min-width:1120px; table-layout:fixed; }
        .donations-table th,
        .donations-table td { vertical-align:middle; }
        .donations-table th:nth-child(1) { width:54px; }
        .donations-table th:nth-child(2) { width:170px; }
        .donations-table th:nth-child(3) { width:170px; }
        .donations-table th:nth-child(4) { width:220px; }
        .donations-table th:nth-child(5) { width:110px; }
        .donations-table th:nth-child(6) { width:260px; }
        .donations-table th:nth-child(7),
        .donations-table th:nth-child(8),
        .donations-table th:nth-child(9) { width:110px; }
        .donations-table th:nth-child(10),
        .donations-table th:nth-child(11) { width:90px; }
        .text-clip { display:block; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .amount-cell { white-space:nowrap; }
        .status-pill { display:inline-flex; align-items:center; justify-content:center; border-radius:999px; padding:5px 10px; color:#116149; background:#dff8ec; font-size:12px; font-weight:900; white-space:nowrap; }
        @media (max-width: 1400px) {
            .summary-card { padding:28px; }
            .summary-card__icon { width:68px; height:68px; flex-basis:68px; }
            .summary-card__icon i { font-size:30px; }
        }
        @media (max-width: 1199px) {
            .summary-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
        }
        @media (max-width: 991px) {
            .admin-layout { grid-template-columns:1fr; }
            .sidebar { position:static; width:100%; min-width:0; height:auto; }
            .topbar-inner { align-items:flex-start !important; flex-direction:column; }
            .topbar-actions { width:100%; justify-content:flex-start; }
            .summary-grid { grid-template-columns:1fr; gap:18px; margin:0 0 24px; }
            .summary-card { min-height:150px; }
        }
        @media (max-width: 767px) {
            .topbar-inner,.content { padding:18px; }
            .brand img { width:132px; }
            .sidebar { padding:22px 18px; }
            .nav-link { padding:12px 13px; }
            .summary-card { min-height:0; padding:22px; border-radius:16px; }
            .summary-card__icon { width:56px; height:56px; flex-basis:56px; border-radius:14px; }
            .summary-card__icon i { font-size:24px; }
            .donations-panel { border:0; background:transparent; box-shadow:none; }
            .donations-table { min-width:0; }
            .donations-table thead { display:none; }
            .donations-table,
            .donations-table tbody,
            .donations-table tr,
            .donations-table td { display:block; width:100%; }
            .donations-table tr {
                margin-bottom:14px;
                border:1px solid var(--line);
                border-radius:16px;
                padding:10px 14px;
                background:#fff;
                box-shadow:0 12px 26px rgba(18,24,39,.07);
            }
            .donations-table td {
                display:grid;
                grid-template-columns:112px minmax(0,1fr);
                gap:12px;
                border:0;
                border-bottom:1px solid #edf0f5;
                padding:10px 0;
                text-align:left;
            }
            .donations-table td:last-child { border-bottom:0; }
            .donations-table td::before {
                content:attr(data-label);
                color:var(--muted);
                font-size:12px;
                font-weight:900;
                text-transform:uppercase;
                letter-spacing:.02em;
            }
            .donations-table .empty-row {
                display:table-row;
                margin:0;
                border:1px solid var(--line);
                border-radius:16px;
                padding:0;
                background:#fff;
            }
            .donations-table .empty-row td {
                display:block;
                border:0;
                padding:28px 14px;
                text-align:center;
            }
            .donations-table .empty-row td::before { content:none; }
        }
        @media (max-width: 480px) {
            .topbar-actions .btn,
            .topbar-actions form,
            .topbar-actions form button,
            .profile-btn { width:100%; justify-content:center; }
            .summary-card { align-items:flex-start; flex-direction:column-reverse; gap:14px; }
            .donations-table td { grid-template-columns:1fr; gap:4px; }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kavach"></a>
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
                @if (auth()->user()?->hasPermission(\App\Support\AdminPermissions::USERS_MANAGE))
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users-gear"></i> Users</a>
                @endif
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

                <div class="panel donations-panel table-responsive">
                    <table class="table donations-table align-middle mb-0">
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
                                    <td data-label="ID">#{{ $donation->id }}</td>
                                    <td data-label="Date">{{ $donation->created_at->format('d M Y, h:i A') }}</td>
                                    <td data-label="Donor">{{ $donation->publicDonorName() }}</td>
                                    <td data-label="Email"><span class="text-clip" title="{{ $donation->donor_email ?: '-' }}">{{ $donation->donor_email ?: '-' }}</span></td>
                                    <td data-label="Phone">{{ $donation->donor_phone ?: '-' }}</td>
                                    <td data-label="Campaign">
                                        @if ($donation->fundraiserPost)
                                            <a class="fw-bold text-clip" href="{{ route('donate-us', $donation->fundraiserPost) }}" target="_blank" title="{{ $donation->fundraiserPost->title }}">{{ $donation->fundraiserPost->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="amount-cell" data-label="Main">Rs. {{ number_format((float) ($donation->main_amount ?: $donation->amount), 0) }}</td>
                                    <td class="amount-cell" data-label="Tip">Rs. {{ number_format((float) $donation->tip_amount, 0) }}</td>
                                    <td class="amount-cell" data-label="Total">Rs. {{ number_format((float) $donation->amount, 0) }}</td>
                                    <td data-label="Method">{{ ucfirst($donation->payment_method ?: '-') }}</td>
                                    <td data-label="Status"><span class="status-pill">{{ ucfirst($donation->status) }}</span></td>
                                </tr>
                            @empty
                                <tr class="empty-row"><td colspan="11" class="text-center text-muted py-5">No donations yet.</td></tr>
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



