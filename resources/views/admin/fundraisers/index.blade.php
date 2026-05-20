<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundraisers | Admin</title>
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
        .fundraisers-table-panel { overflow:visible; }
        .filters-panel { padding:18px; }
        .filter-link { display:inline-flex; align-items:center; justify-content:center; gap:8px; border:1px solid var(--line); border-radius:999px; min-height:40px; padding:8px 15px; color:#2f3a4c; font-weight:900; background:#fff; }
        .filter-link span { display:inline-flex; align-items:center; justify-content:center; min-width:24px; min-height:24px; border-radius:999px; padding:3px 8px; color:var(--muted); background:#f1f4f8; font-size:12px; }
        .filter-link:hover,.filter-link.active { border-color:rgba(147,42,25,.5); color:#fff; background:var(--gold); }
        .filter-link:hover span,.filter-link.active span { color:#fff; background:rgba(255,255,255,.2); }
        .badge-status { display:inline-flex; align-items:center; border-radius:999px; padding:6px 12px; font-size:12px; font-weight:900; text-transform:capitalize; background:#e8f8ed; color:#087a2a; }
        .badge-status.pending { background:#fff4d8; color:#8a5b00; }
        .badge-status.hold { background:#ffe8c2; color:#9a4f00; }
        .badge-status.rejected { background:#fde3e0; color:#9b2417; }
        .action-group { display:flex; align-items:center; gap:8px; flex-wrap:wrap; min-width:220px; }
        .action-group form { margin:0; }
        .action-menu-btn { min-height:34px; display:inline-flex; align-items:center; gap:8px; border:0; border-radius:9px; padding:7px 12px; color:#fff !important; background:linear-gradient(180deg,#b73a27,#932a19); font-size:13px; font-weight:900; box-shadow:0 10px 22px rgba(147,42,25,.2); }
        .action-menu-btn::after { margin-left:2px; }
        .action-menu-btn:hover,.action-menu-btn:focus,.action-menu-btn.show { color:#fff !important; background:linear-gradient(180deg,#c8402b,#7e2115); box-shadow:0 12px 26px rgba(147,42,25,.28); }
        .action-menu { min-width:198px; padding:10px; border:1px solid rgba(221,226,234,.95); border-radius:16px; background:#fff; box-shadow:0 22px 48px rgba(18,24,39,.18); transform:translateY(6px); }
        .action-menu::before { position:absolute; top:-6px; left:22px; width:12px; height:12px; content:""; border-left:1px solid rgba(221,226,234,.95); border-top:1px solid rgba(221,226,234,.95); background:#fff; transform:rotate(45deg); }
        .action-menu li + li { margin-top:5px; }
        .action-menu .dropdown-item { position:relative; min-height:42px; display:flex; align-items:center; gap:11px; border:0; border-radius:11px; padding:9px 12px; font-size:14px; font-weight:900; background:#fff; transition:background .16s ease,color .16s ease,transform .16s ease; }
        .action-menu .dropdown-item:disabled { opacity:.48; cursor:not-allowed; }
        .action-menu .dropdown-item:not(:disabled):hover { color:#fff !important; transform:translateX(2px); }
        .action-menu .dropdown-item i { width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; border-radius:999px; font-size:12px; }
        .action-menu .text-success { color:#0b6f3c !important; background:#cdeed9; }
        .action-menu .text-warning { color:#9a5a00 !important; background:#ffdf9a; }
        .action-menu .text-danger { color:#aa1d2a !important; background:#ffc8cf; }
        .action-menu .text-success i { background:#aee4c1; }
        .action-menu .text-warning i { background:#ffc96b; }
        .action-menu .text-danger i { background:#ffadb8; }
        .action-menu .text-success:not(:disabled):hover { background:#18864b; }
        .action-menu .text-warning:not(:disabled):hover { background:#e9982d; }
        .action-menu .text-danger:not(:disabled):hover { background:#dc3545; }
        .action-menu .dropdown-item:not(:disabled):hover i { background:rgba(255,255,255,.22); }
        .btn-hold { border-color:#e9982d; color:#fff !important; background:#e9982d; }
        .btn-hold:hover,.btn-hold:focus { border-color:#c87500; color:#fff !important; background:#c87500; }
        .modal-backdrop.show { opacity:.22; backdrop-filter:blur(8px); }
        .moderation-modal .modal-content { border:1px solid var(--line); border-radius:18px; box-shadow:0 22px 60px rgba(18,24,39,.2); }
        .moderation-modal textarea { min-height:130px; border-radius:12px; font-weight:700; }
        .table td,.table th { vertical-align:middle; }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } }
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
                <a class="nav-link active" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-user-tie"></i> Fundraisers</a>
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
                        <p class="text-muted small mb-1">Registered fundraiser accounts</p>
                        <h1 class="h4 fw-bold mb-0">Fundraisers</h1>
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
                    <div class="alert alert-success fw-bold border-0 mb-4" data-auto-dismiss="3500">{{ session('status') }}</div>
                @endif

                <div class="panel filters-panel mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach (['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'hold' => 'Hold', 'rejected' => 'Rejected'] as $key => $label)
                            <a class="filter-link {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.fundraisers.index', ['status' => $key]) }}">
                                {{ $label }}
                                <span>{{ $counts[$key] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="panel table-responsive fundraisers-table-panel">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Total Posts</th>
                                <th>Total Raised</th>
                                <th>Total Tips</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fundraisers as $fundraiser)
                                <tr>
                                    <td class="fw-bold">{{ $fundraiser->name }}</td>
                                    <td>{{ $fundraiser->email ?: '-' }}</td>
                                    <td>{{ $fundraiser->full_phone ?: '-' }}</td>
                                    <td><span class="badge-status {{ $fundraiser->status }}">{{ $fundraiser->status }}</span></td>
                                    <td>{{ number_format($fundraiser->posts_count) }}</td>
                                    <td>Rs. {{ number_format((float) $fundraiser->total_raised_amount, 0) }}</td>
                                    <td>Rs. {{ number_format((float) $fundraiser->total_tip_amount, 0) }}</td>
                                    <td>{{ $fundraiser->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="action-group">
                                            <div class="dropdown">
                                                <button class="btn btn-sm action-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu action-menu">
                                                    <li>
                                                        <button class="dropdown-item text-success" type="button" data-bs-toggle="modal" data-bs-target="#approveFundraiser{{ $fundraiser->id }}" @disabled($fundraiser->status === \App\Models\Fundraiser::STATUS_APPROVED)>
                                                            <i class="fa-solid fa-circle-check"></i>
                                                            Approve
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-warning" type="button" data-bs-toggle="modal" data-bs-target="#holdFundraiser{{ $fundraiser->id }}" @disabled($fundraiser->status === \App\Models\Fundraiser::STATUS_HOLD)>
                                                            <i class="fa-solid fa-pause"></i>
                                                            Hold
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#rejectFundraiser{{ $fundraiser->id }}" @disabled($fundraiser->status === \App\Models\Fundraiser::STATUS_REJECTED)>
                                                            <i class="fa-solid fa-circle-xmark"></i>
                                                            Reject
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a class="btn btn-sm btn-warning fw-bold" href="{{ route('admin.fundraisers.show', $fundraiser) }}">View Details</a>
                                        </div>

                                        <div class="modal fade moderation-modal" id="approveFundraiser{{ $fundraiser->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0">
                                                        <h2 class="modal-title h5 fw-bold">Approve fundraiser?</h2>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <p class="text-muted mb-0">This will mark {{ $fundraiser->name }} as approved and clear any hold or rejection reason.</p>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.fundraisers.approve', $fundraiser) }}" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-success fw-bold" type="submit">Approve</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade moderation-modal" id="holdFundraiser{{ $fundraiser->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form class="modal-content" action="{{ route('admin.fundraisers.hold', $fundraiser) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header border-0">
                                                        <h2 class="modal-title h5 fw-bold">Hold fundraiser</h2>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <label class="form-label fw-bold" for="hold_reason_{{ $fundraiser->id }}">Reason for holding</label>
                                                        <textarea class="form-control" id="hold_reason_{{ $fundraiser->id }}" name="hold_reason" required>{{ old('hold_reason') }}</textarea>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-hold fw-bold" type="submit">Hold</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade moderation-modal" id="rejectFundraiser{{ $fundraiser->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form class="modal-content" action="{{ route('admin.fundraisers.reject', $fundraiser) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header border-0">
                                                        <h2 class="modal-title h5 fw-bold">Reject fundraiser</h2>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <label class="form-label fw-bold" for="rejected_reason_{{ $fundraiser->id }}">Reason for rejection</label>
                                                        <textarea class="form-control" id="rejected_reason_{{ $fundraiser->id }}" name="rejected_reason" required>{{ old('rejected_reason') }}</textarea>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-outline-danger fw-bold" type="submit">Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-5">No fundraisers found for this status.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $fundraisers->links() }}</div>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    @include('partials.auto-alerts')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
