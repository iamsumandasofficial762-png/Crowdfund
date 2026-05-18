<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fundraiser->name }} | Fundraiser Details</title>
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
        .btn-soft { border:1px solid var(--line); color:var(--ink); background:#fff; font-weight:900; }
        .panel { border:1px solid var(--line); border-radius:18px; background:#fff; box-shadow:0 14px 34px rgba(18,24,39,.07); }
        .detail-grid { display:grid; grid-template-columns:minmax(0,.85fr) minmax(0,1.15fr); gap:22px; align-items:stretch; }
        .detail-grid > .panel { height:100%; }
        .meta-label { display:block; color:var(--muted); font-size:13px; font-weight:800; }
        .panel { padding:22px; }
        .detail-panel h2 { padding-bottom:14px; margin-bottom:18px !important; border-bottom:1px solid var(--line); }
        .meta-list { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px 18px; margin:0; }
        .meta-list .meta-wide { grid-column:1 / -1; }
        .meta-list dd { margin:4px 0 0; font-weight:900; }
        .summary-panel { min-height:520px; display:flex; flex-direction:column; }
        .summary-grid { flex:1; display:grid; grid-template-columns:repeat(12,minmax(0,1fr)); grid-template-rows:minmax(150px,1fr) minmax(180px,1.2fr); gap:22px; align-items:stretch; }
        .summary-item { min-height:150px; grid-column:span 3; display:flex; flex-direction:column; justify-content:center; border:1px solid var(--line); border-radius:16px; padding:36px 22px; background:#fbfcfe; }
        .summary-item strong { display:block; margin-top:10px; color:var(--ink); font-size:26px; font-weight:900; line-height:1.2; }
        .summary-item.is-wide { grid-column:span 4; min-height:180px; }
        .summary-item.is-primary { border-color:rgba(147,42,25,.22); background:var(--gold-soft); }
        .summary-item.is-primary .meta-label { color:var(--gold); }
        .badge-status { display:inline-flex; align-items:center; border-radius:999px; padding:6px 12px; font-size:12px; font-weight:900; text-transform:capitalize; background:#e8f8ed; color:#087a2a; }
        .badge-status.pending { background:#fff4d8; color:#8a5b00; }
        .badge-status.rejected { background:#fde3e0; color:#9b2417; }
        .documents { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
        .documents .btn { max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .table td,.table th { vertical-align:middle; }
        @media (max-width: 1399px) { .summary-item { grid-column:span 6; } .summary-item.is-wide { grid-column:span 4; } }
        @media (max-width: 1199px) { .detail-grid { grid-template-columns:1fr; } }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } }
        @media (max-width: 767px) { .meta-list { grid-template-columns:1fr; } .summary-grid { grid-template-columns:1fr; } .summary-item,.summary-item.is-wide { grid-column:auto; } }
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
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-muted small mb-1">Fundraiser profile details</p>
                        <h1 class="h4 fw-bold mb-0">{{ $fundraiser->name }}</h1>
                    </div>
                    <div class="topbar-actions">
                        @include('admin.partials.activity-bell')
                        <a class="btn btn-soft" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
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
                <div class="detail-grid mb-4">
                    <section class="panel detail-panel summary-panel">
                        <h2 class="h5 fw-bold mb-3">Personal Details</h2>
                        <dl class="meta-list">
                            <div><dt class="meta-label">Name</dt><dd>{{ $fundraiser->name }}</dd></div>
                            <div><dt class="meta-label">Email</dt><dd>{{ $fundraiser->email ?: '-' }}</dd></div>
                            <div><dt class="meta-label">Phone</dt><dd>{{ $fundraiser->full_phone ?: '-' }}</dd></div>
                            <div><dt class="meta-label">Address / Location</dt><dd>{{ $fundraiser->location ?? 'Not available' }}</dd></div>
                            <div><dt class="meta-label">Cause</dt><dd>{{ $fundraiser->cause ?: '-' }}</dd></div>
                            <div><dt class="meta-label">Registration Date</dt><dd>{{ $fundraiser->created_at->format('d M Y, h:i A') }}</dd></div>
                            <div><dt class="meta-label">Status</dt><dd><span class="badge-status {{ $fundraiser->status }}">{{ $fundraiser->status }}</span></dd></div>
                            <div class="meta-wide">
                                <dt class="meta-label">Documents</dt>
                                <dd>
                                    @if (! empty($fundraiser->documents))
                                        <div class="documents">
                                            @foreach ($fundraiser->documents as $document)
                                                <a class="btn btn-sm btn-soft" href="{{ asset('storage/'.$document) }}" target="_blank" rel="noopener">View {{ basename($document) }}</a>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <section class="panel detail-panel">
                        <h2 class="h5 fw-bold mb-3">Post Summary</h2>
                        <div class="summary-grid">
                            <div class="summary-item"><span class="meta-label">Total Posts</span><strong>{{ number_format($summary['total_posts']) }}</strong></div>
                            <div class="summary-item"><span class="meta-label">Pending Posts</span><strong>{{ number_format($summary['pending_posts']) }}</strong></div>
                            <div class="summary-item"><span class="meta-label">Rejected Posts</span><strong>{{ number_format($summary['rejected_posts']) }}</strong></div>
                            <div class="summary-item"><span class="meta-label">Approved Posts</span><strong>{{ number_format($summary['approved_posts']) }}</strong></div>
                            <div class="summary-item is-wide is-primary"><span class="meta-label">Total Goal Amount</span><strong>Rs. {{ number_format($summary['total_goal_amount'], 0) }}</strong></div>
                            <div class="summary-item is-wide is-primary"><span class="meta-label">Total Raised Amount</span><strong>Rs. {{ number_format($summary['total_raised_amount'], 0) }}</strong></div>
                            <div class="summary-item is-wide is-primary"><span class="meta-label">Platform Tip Amount</span><strong>Rs. {{ number_format($summary['total_tip_amount'], 0) }}</strong></div>
                        </div>
                    </section>
                </div>

                <section class="panel table-responsive">
                    <h2 class="h5 fw-bold mb-3">Fundraiser Posts</h2>
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Post Title</th>
                                <th>Category</th>
                                <th>Goal</th>
                                <th>Raised</th>
                                <th>Tips</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="fw-bold">{{ $post->title }}</td>
                                    <td>{{ $post->category }}</td>
                                    <td>Rs. {{ number_format((float) $post->goal_amount, 0) }}</td>
                                    <td>Rs. {{ number_format((float) $post->calculated_raised_amount, 0) }}</td>
                                    <td>Rs. {{ number_format((float) $post->calculated_tip_amount, 0) }}</td>
                                    <td><span class="badge-status {{ $post->status }}">{{ $post->status }}</span></td>
                                    <td>{{ $post->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                                            <a class="btn btn-sm btn-warning fw-bold" href="{{ route('donate-us', $post) }}" target="_blank" rel="noopener">View Post</a>
                                        @else
                                            <a class="btn btn-sm btn-warning fw-bold" href="{{ route('admin.fundraiser-posts.index', ['status' => $post->status]) }}">View Post</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-5">No posts created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
