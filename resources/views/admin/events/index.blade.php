<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root { --gold:#932a19; --gold-soft:#f7e1df; --bg:#f7f8fb; --line:#dde2ea; --ink:#071226; }
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
        .btn-warning,.btn-warning:focus { border-color:var(--gold); color:#fff !important; background:var(--gold); }
        .btn-warning:hover,.btn-warning:active { border-color:#b21f17; color:#fff !important; background:#b21f17; }
        .btn-soft { border:1px solid rgba(147,42,25,.3); color:var(--gold); background:var(--gold-soft); font-weight:800; }
        .btn-soft:hover { color:#fff; background:var(--gold); }
        .panel { border:1px solid var(--line); border-radius:18px; background:#fff; box-shadow:0 14px 34px rgba(18,24,39,.07); }
        .event-thumb { width:86px; height:62px; object-fit:cover; border-radius:10px; background:#f2f3f5; }
        .text-clip { max-width:320px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .badge-published { color:#116149; background:#dff8ec; }
        .badge-draft { color:#7a4b00; background:#fff1cf; }
        [data-auto-dismiss] { transition: opacity .35s ease, transform .35s ease, margin .35s ease, padding .35s ease, border-width .35s ease; }
        [data-auto-dismiss].is-hiding { opacity:0; transform:translateY(-8px); margin-top:0 !important; margin-bottom:0 !important; padding-top:0 !important; padding-bottom:0 !important; border-width:0 !important; overflow:hidden; }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } }
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
                <a class="nav-link active" href="{{ route('admin.events.index') }}"><i class="fa-solid fa-calendar-days"></i> Events</a>
                <a class="nav-link" href="{{ route('admin.blogs.index') }}"><i class="fa-solid fa-newspaper"></i> Blogs</a>
                <a class="nav-link" href="{{ route('admin.blog-categories.index') }}"><i class="fa-solid fa-tags"></i> Blog Categories</a>
                <a class="nav-link" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-user-tie"></i> Fundraisers</a>
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>
        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div><p class="text-muted small mb-1">Program calendar</p><h1 class="h4 fw-bold mb-0">Events</h1></div>
                    <div class="topbar-actions">
                        @include('admin.partials.activity-bell')
                        <a class="btn btn-warning fw-bold" href="{{ route('admin.events.create') }}"><i class="fa-solid fa-plus"></i> Add Event</a>
                        <form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-warning fw-bold" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form>
                    </div>
                </div>
            </header>
            <div class="content">
                @if (session('status'))<div class="alert alert-success fw-bold" data-auto-dismiss="3500">{{ session('status') }}</div>@endif
                <div class="panel table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date / Time</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                                <tr>
                                    <td><img class="event-thumb" src="{{ $event->imageUrl() }}" alt="{{ $event->title }}"></td>
                                    <td><strong>{{ $event->title }}</strong><div class="text-muted small text-clip">{{ $event->short_description ?: 'No short description.' }}</div></td>
                                    <td>{{ $event->categoryLabel() }}</td>
                                    <td>{{ $event->event_date?->format('d M Y') ?? '-' }}<div class="text-muted small">{{ $event->event_time?->format('h:i A') ?? '' }}</div></td>
                                    <td>{{ $event->location ?: '-' }}</td>
                                    <td><span class="badge rounded-pill px-3 py-2 {{ $event->status === 'published' ? 'badge-published' : 'badge-draft' }}">{{ ucfirst($event->status) }}</span></td>
                                    <td class="text-end">
                                        @if ($event->status === 'published')<a class="btn btn-sm btn-soft" href="{{ route('events.show', $event->slug) }}" target="_blank">View</a>@endif
                                        <a class="btn btn-sm btn-warning" href="{{ route('admin.events.edit', $event) }}">Edit</a>
                                        <form class="d-inline" action="{{ route('admin.events.destroy', $event) }}" method="post" data-delete-confirm>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-5">No events yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $events->links() }}</div>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.querySelectorAll('[data-auto-dismiss]').forEach((alert) => {
            const delay = Number(alert.dataset.autoDismiss) || 3500;

            window.setTimeout(() => {
                alert.classList.add('is-hiding');
                window.setTimeout(() => alert.remove(), 400);
            }, delay);
        });
    </script>
</body>
</html>
