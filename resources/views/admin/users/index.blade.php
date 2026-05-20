<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>User Management | Karna Kabach Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root { --gold:#932a19; --gold-dark:#b21f17; --gold-soft:#f7e1df; --bg:#f7f8fb; --panel:#fff; --line:#dde2ea; --ink:#121827; --muted:#647083; --green:#168231; --green-soft:#e2f4e6; --yellow:#a35d00; --yellow-soft:#fff1cf; --red:#b42318; --red-soft:#fde4e2; }
        body { margin:0; color:var(--ink); font-family:"Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:var(--bg); }
        a { color:inherit; text-decoration:none; }
        .admin-layout { min-height:100vh; display:grid; grid-template-columns:300px minmax(0,1fr); }
        .sidebar { position:sticky; top:0; height:100vh; min-width:300px; border-right:1px solid var(--line); padding:30px 22px; background:#fff; }
        .brand img { width:154px; height:auto; display:block; }
        .nav-link { display:flex; align-items:center; gap:12px; margin-bottom:10px; border-radius:12px; padding:13px 15px; color:#2f3a4c; font-weight:800; line-height:1.2; }
        .nav-link i { width:20px; display:inline-flex; justify-content:center; }
        .nav-link:hover,.nav-link.active { background:var(--gold-soft); color:var(--gold); }
        .main { min-width:0; background:#f8f9fb; }
        .topbar { position:sticky; top:0; z-index:10; border-bottom:1px solid var(--line); padding:22px clamp(18px,3vw,36px); background:rgba(255,255,255,.92); backdrop-filter:blur(14px); }
        .content { padding:28px clamp(18px,2vw,30px) 48px; }
        .panel { border:1px solid var(--line); border-radius:14px; background:var(--panel); box-shadow:0 8px 22px rgba(18,24,39,.08); }
        .filters { padding:18px; display:grid; grid-template-columns:2fr 1fr 1fr auto; gap:12px; align-items:end; }
        .form-control,.form-select { border-color:var(--line); border-radius:10px; min-height:42px; font-weight:700; }
        .table-panel { overflow:hidden; }
        .table-responsive { overflow-x:auto; }
        table { margin:0; min-width:980px; }
        th { color:var(--muted); font-size:12px; text-transform:uppercase; letter-spacing:.04em; }
        td, th { padding:16px !important; vertical-align:middle; }
        .status-badge { display:inline-flex; align-items:center; border-radius:999px; padding:6px 10px; font-size:12px; font-weight:900; }
        .status-badge--active { color:var(--green); background:var(--green-soft); }
        .status-badge--hold { color:var(--yellow); background:var(--yellow-soft); }
        .status-badge--deleted { color:var(--red); background:var(--red-soft); }
        .btn-admin { min-height:38px; display:inline-flex; align-items:center; justify-content:center; gap:7px; border-radius:9px; border:1px solid transparent; padding:8px 12px; font-weight:900; transition:transform .18s ease, box-shadow .18s ease; }
        .btn-admin:hover { transform:translateY(-2px); box-shadow:0 12px 22px rgba(18,24,39,.14); }
        .btn-create,.btn-active { color:#fff; background:var(--green); border-color:var(--green); }
        .btn-hold { color:#352100; background:#f2bd3d; border-color:#f2bd3d; }
        .btn-edit { color:var(--ink); background:#fff; border-color:var(--line); }
        .btn-delete { color:#fff; background:#7f1d1d; border-color:#7f1d1d; }
        .btn-warning,.btn-warning:focus { border-color:var(--gold); color:#fff !important; background:var(--gold); }
        .btn-warning:hover,.btn-warning:active,.btn-warning:first-child:active { border-color:var(--gold-dark); color:#fff !important; background:var(--gold-dark); box-shadow:0 12px 24px rgba(147,42,25,.22); }
        .topbar-actions { display:flex; align-items:center; gap:8px; flex-wrap:wrap; justify-content:flex-end; }
        .profile-btn { min-height:40px; display:inline-flex; align-items:center; gap:6px; border:1px solid var(--line); border-radius:999px; background:#fff; color:var(--ink); }
        .mobile-toggle { display:none; }
        .permission-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; }
        .permission-group { border:1px solid var(--line); border-radius:12px; padding:12px; background:#f9fafc; }
        .permission-group h4 { margin:0 0 8px; font-size:13px; font-weight:900; color:var(--gold); }
        .permission-option { display:flex; align-items:flex-start; gap:8px; margin:8px 0; color:#344054; font-size:13px; font-weight:800; }
        .permission-option input { margin-top:3px; accent-color:var(--gold); }
        .modal-content { border:1px solid var(--line); border-radius:18px; box-shadow:0 22px 60px rgba(18,24,39,.2); }
        .alert-auto-dismiss { transition:opacity .35s ease, transform .35s ease, margin .35s ease, padding .35s ease, border-width .35s ease; }
        .alert-auto-dismiss.is-hiding { opacity:0; transform:translateY(-8px); margin-top:0!important; margin-bottom:0!important; padding-top:0!important; padding-bottom:0!important; border-width:0!important; overflow:hidden; }
        @media (max-width:991px) { .admin-layout{grid-template-columns:1fr}.sidebar{position:fixed;z-index:20;width:280px;transform:translateX(-100%);transition:transform .25s ease}.sidebar.show{transform:translateX(0)}.mobile-toggle{display:inline-flex}.filters{grid-template-columns:1fr}.permission-grid{grid-template-columns:1fr} }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar" id="sidebar">
            @include('admin.partials.sidebar')
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-sm btn-outline-warning mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')" aria-label="Toggle sidebar"><i class="fa-solid fa-bars"></i></button>
                        <div>
                            <p class="text-muted small mb-1">Admin access control</p>
                            <h1 class="h4 fw-black mb-0">User Management</h1>
                        </div>
                    </div>
                    <div class="topbar-actions">
                        @include('admin.partials.activity-bell')
                        <button class="btn profile-btn" type="button"><i class="fa-solid fa-user-circle text-warning"></i>{{ auth()->user()->name ?? 'Admin' }}</button>
                        <form action="{{ route('logout') }}" method="post">@csrf <button class="btn btn-warning fw-bold" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form>
                    </div>
                </div>
            </header>

            <section class="content">
                @if (session('status'))
                    <div class="alert alert-success alert-auto-dismiss border-0 mb-4" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-auto-dismiss mb-4" data-auto-dismiss="6500">
                        <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="panel mb-4">
                    <form class="filters" method="get">
                        <div>
                            <label class="form-label fw-bold">Search</label>
                            <input class="form-control" type="search" name="search" value="{{ $search }}" placeholder="Name, email, or phone">
                        </div>
                        <div>
                            <label class="form-label fw-bold">Role</label>
                            <select class="form-select" name="role">
                                <option value="">All roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->slug }}" @selected($roleFilter === $role->slug)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label fw-bold">Status</label>
                            <select class="form-select" name="status">
                                <option value="all" @selected($statusFilter === 'all')>All</option>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected($statusFilter === $key)>{{ $label }}</option>
                                @endforeach
                                <option value="deleted" @selected($statusFilter === 'deleted')>Deleted</option>
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-admin btn-edit" type="submit"><i class="fa-solid fa-filter"></i>Filter</button>
                            <button class="btn-admin btn-create" type="button" data-bs-toggle="modal" data-bs-target="#createUser"><i class="fa-solid fa-user-plus"></i>Create User</button>
                        </div>
                    </form>
                </div>

                <div class="panel table-panel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead><tr><th>User</th><th>Role</th><th>Status</th><th>Phone</th><th>Created</th><th>Actions</th></tr></thead>
                            <tbody>
                                @forelse ($users as $user)
                                    @php
                                        $deleted = $user->trashed();
                                        $statusClass = $deleted ? 'deleted' : $user->status;
                                        $isCurrentUser = $user->id === auth()->id();
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $user->name }}</strong><br><span class="text-muted">{{ $user->email }}</span></td>
                                        <td>{{ $user->role?->name ?? 'No role' }}</td>
                                        <td><span class="status-badge status-badge--{{ $statusClass }}">{{ $deleted ? 'Deleted' : ucfirst($user->status) }}</span></td>
                                        <td>{{ $user->phone ?: '-' }}</td>
                                        <td>{{ $user->created_at?->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if ($deleted)
                                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="post" data-delete-confirm data-confirm-title="Restore user?" data-confirm-message="This user will be restored and set to active." data-confirm-button="Restore User">@csrf @method('PATCH')<button class="btn-admin btn-active" type="submit">Restore</button></form>
                                                @else
                                                    @if ($user->status === \App\Models\User::STATUS_ACTIVE && ! $isCurrentUser)
                                                        <form action="{{ route('admin.users.hold', $user) }}" method="post" data-delete-confirm data-confirm-title="Put user on hold?" data-confirm-message="This user will not be able to login until the account is activated again." data-confirm-button="Hold User">@csrf @method('PATCH')<button class="btn-admin btn-hold" type="submit">Hold</button></form>
                                                    @elseif ($user->status === \App\Models\User::STATUS_HOLD)
                                                        <form action="{{ route('admin.users.activate', $user) }}" method="post" data-delete-confirm data-confirm-title="Activate user?" data-confirm-message="This user will regain admin login access." data-confirm-button="Activate User">@csrf @method('PATCH')<button class="btn-admin btn-active" type="submit">Activate</button></form>
                                                    @endif
                                                    <button class="btn-admin btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#editUser{{ $user->id }}">Edit</button>
                                                    @unless ($isCurrentUser)
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="post" data-delete-confirm>@csrf @method('DELETE')<button class="btn-admin btn-delete" type="submit">Delete</button></form>
                                                    @endunless
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-5">No users found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">{{ $users->links() }}</div>
                </div>

                @include('admin.users.partials.user-modal', ['modalId' => 'createUser', 'formAction' => route('admin.users.store'), 'method' => 'POST', 'user' => null])
                @foreach ($users as $user)
                    @unless ($user->trashed())
                        @include('admin.users.partials.user-modal', ['modalId' => 'editUser'.$user->id, 'formAction' => route('admin.users.update', $user), 'method' => 'PUT', 'user' => $user])
                    @endunless
                @endforeach
            </section>
        </main>
    </div>

    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.querySelectorAll('[data-auto-dismiss]').forEach((alert) => {
            window.setTimeout(() => { alert.classList.add('is-hiding'); window.setTimeout(() => alert.remove(), 400); }, Number(alert.dataset.autoDismiss) || 3500);
        });
    </script>
</body>
</html>
