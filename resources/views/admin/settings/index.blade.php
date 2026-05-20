<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Admin</title>
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
        .panel { border:1px solid var(--line); border-radius:18px; padding:24px; background:#fff; box-shadow:0 14px 34px rgba(18,24,39,.07); }
        .settings-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; }
        .settings-card { border:1px solid var(--line); border-radius:14px; padding:18px; background:#fff; }
        .settings-card span { display:block; color:var(--muted); font-weight:800; }
        .settings-card strong { display:block; margin-top:8px; font-size:28px; font-weight:900; }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } .settings-grid { grid-template-columns:1fr; } }
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
                <a class="nav-link" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-user-tie"></i> Fundraisers</a>
                @if (auth()->user()?->hasPermission(\App\Support\AdminPermissions::USERS_MANAGE))
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users-gear"></i> Users</a>
                @endif
                <a class="nav-link active" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-muted small mb-1">Admin profile and system summary</p>
                        <h1 class="h4 fw-bold mb-0">Settings</h1>
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
                <section class="panel mb-4">
                    <h2 class="h5 fw-bold mb-3">Signed in admin</h2>
                    <div class="row g-3">
                        <div class="col-md-4"><strong>Name:</strong> {{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="col-md-4"><strong>Email:</strong> {{ auth()->user()->email ?? 'admin@example.com' }}</div>
                        <div class="col-md-4"><strong>Role:</strong> Admin</div>
                    </div>
                </section>

                <section class="panel">
                    <h2 class="h5 fw-bold mb-3">System summary</h2>
                    <div class="settings-grid">
                        <div class="settings-card"><span>Paid donations</span><strong>{{ number_format($settingsSummary['paid_donations']) }}</strong></div>
                        <div class="settings-card"><span>Campaigns</span><strong>{{ number_format($settingsSummary['campaigns']) }}</strong></div>
                        <div class="settings-card"><span>Contact messages</span><strong>{{ number_format($settingsSummary['contact_messages']) }}</strong></div>
                        <div class="settings-card"><span>Supporter reports</span><strong>{{ number_format($settingsSummary['supporter_reports']) }}</strong></div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>



