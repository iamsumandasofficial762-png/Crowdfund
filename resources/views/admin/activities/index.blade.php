<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Activities | Admin</title>
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
        .activity-row { display:grid; grid-template-columns:1fr auto; gap:18px; padding:18px; border-bottom:1px solid var(--line); background:#fff; }
        .activity-row:last-child { border-bottom:0; }
        .activity-row.is-unread { background:#fff7f5; }
        .activity-row h2 { margin:0 0 6px; font-size:18px; font-weight:900; }
        .activity-row p { margin:0 0 8px; color:var(--muted); line-height:1.55; }
        .activity-meta { display:flex; flex-wrap:wrap; gap:8px; align-items:center; color:var(--muted); font-size:13px; font-weight:800; }
        .badge-soft { display:inline-flex; border-radius:999px; padding:5px 10px; color:var(--gold); background:var(--gold-soft); font-size:12px; font-weight:900; text-transform:capitalize; }
        .activity-actions { display:flex; gap:8px; align-items:center; flex-wrap:wrap; justify-content:flex-end; }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } .activity-row { grid-template-columns:1fr; } .activity-actions { justify-content:flex-start; } }
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
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-muted small mb-1">Admin notification center</p>
                        <h1 class="h4 fw-bold mb-0">All Activities</h1>
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
                @if (session('status'))
                    <div class="alert alert-success border-0 mb-4">{{ session('status') }}</div>
                @endif
                <section class="panel overflow-hidden">
                    @forelse ($activities as $activity)
                        <article class="activity-row {{ $activity->is_read ? '' : 'is-unread' }}">
                            <div>
                                <h2>{{ $activity->title }}</h2>
                                <p>{{ $activity->message }}</p>
                                <div class="activity-meta">
                                    <span class="badge-soft">{{ $activity->type ?: 'activity' }}</span>
                                    <span>{{ $activity->is_read ? 'Read' : 'Unread' }}</span>
                                    <span>{{ $activity->created_at->format('d M Y, h:i A') }}</span>
                                    @if ($activity->created_by)
                                        <span>By {{ $activity->created_by }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="activity-actions">
                                @unless ($activity->is_read)
                                    <form action="{{ route('admin.activities.read', $activity) }}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-warning fw-bold" type="submit">Mark read</button>
                                    </form>
                                @endunless
                                <form action="{{ route('admin.activities.destroy', $activity) }}" method="post" data-delete-confirm>
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger fw-bold" type="submit">Delete</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="text-center text-muted py-5">No activities yet.</div>
                    @endforelse
                </section>
                <div class="mt-4">{{ $activities->links() }}</div>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
