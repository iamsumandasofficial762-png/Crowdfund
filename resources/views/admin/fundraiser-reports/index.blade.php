<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports | Admin</title>
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
        .panel { border:1px solid var(--line); border-radius:18px; background:#fff; box-shadow:0 14px 34px rgba(18,24,39,.07); overflow:hidden; }
        .panel + .panel { margin-top:24px; }
        .section-head { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; padding:22px 22px 0; }
        .section-head h2 { margin:0; font-size:20px; font-weight:900; }
        .section-head p { margin:4px 0 0; color:var(--muted); }
        .count-pill { border-radius:999px; padding:6px 10px; color:var(--gold); background:var(--gold-soft); font-weight:900; }
        .status-overview { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; padding:18px 22px 8px; }
        .status-tile { min-height:82px; display:flex; align-items:center; justify-content:space-between; gap:14px; border:1px solid var(--line); border-radius:14px; padding:16px; background:#fbfcfe; }
        .status-tile span { display:block; color:var(--muted); font-size:12px; font-weight:900; text-transform:uppercase; }
        .status-tile strong { display:block; margin-top:4px; color:var(--ink); font-size:24px; font-weight:900; line-height:1; }
        .status-tile i { width:38px; height:38px; display:inline-flex; align-items:center; justify-content:center; border-radius:12px; font-size:16px; }
        .status-tile--under-processing { border-color:#f2d99c; background:#fffaf0; }
        .status-tile--under-processing i { color:#8a5b00; background:#fff1cf; }
        .status-tile--solved { border-color:#b9ebcb; background:#f3fff7; }
        .status-tile--solved i { color:#087a2a; background:#e0f7e8; }
        .status-tile--dismissed { border-color:#efc5c1; background:#fff6f5; }
        .status-tile--dismissed i { color:#9b2417; background:#fde3e0; }
        .reports-table { margin-top:10px; }
        .reports-table thead th { border-top:1px solid var(--line); border-bottom:1px solid var(--line); color:#354052; background:#fbfcfe; font-size:12px; font-weight:900; text-transform:uppercase; white-space:nowrap; }
        .reports-table tbody tr { border-color:#eef1f5; }
        .reports-table tbody tr:hover { background:#fffaf8; }
        .message-cell { max-width:380px; min-width:260px; white-space:normal; line-height:1.55; }
        .report-title-link { display:inline-block; max-width:280px; color:#0057ff; line-height:1.4; }
        .muted-meta { color:var(--muted); font-size:12px; font-weight:800; }
        .status-cell { min-width:250px; }
        .report-status-form { max-width:245px; }
        .status-control { border:1px solid var(--line); border-radius:14px; padding:10px; background:#fff; box-shadow:0 8px 18px rgba(18,24,39,.05); }
        .status-control__top { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:8px; }
        .status-badge { display:inline-flex; align-items:center; border-radius:999px; padding:6px 10px; font-size:12px; font-weight:900; white-space:nowrap; }
        .status-badge i { margin-right:5px; font-size:10px; }
        .status-badge--under-processing { color:#8a5b00; background:#fff1cf; }
        .status-badge--solved { color:#087a2a; background:#e0f7e8; }
        .status-badge--dismissed { color:#9b2417; background:#fde3e0; }
        .status-control__hint { color:var(--muted); font-size:11px; font-weight:800; }
        .report-status-select { width:100%; border:1px solid var(--line); border-radius:10px; padding:8px 34px 8px 10px; color:var(--ink); background-color:#fff; font-size:13px; font-weight:900; }
        .report-status-select:focus { border-color:rgba(147,42,25,.65); box-shadow:0 0 0 .2rem rgba(147,42,25,.12); }
        .report-status-select--under-processing { border-color:#f2d99c; background-color:#fffaf0; }
        .report-status-select--solved { border-color:#b9ebcb; background-color:#f3fff7; }
        .report-status-select--dismissed { border-color:#efc5c1; background-color:#fff6f5; }
        .doc-link { display:inline-flex; align-items:center; gap:6px; border:1px solid rgba(147,42,25,.28); border-radius:999px; padding:7px 11px; color:var(--gold); background:var(--gold-soft); font-size:12px; font-weight:900; }
        .doc-link:hover { color:#fff; background:var(--gold); }
        @media (max-width: 991px) { .admin-layout { grid-template-columns:1fr; } .sidebar { position:static; } .status-overview { grid-template-columns:1fr; } }
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
                <a class="nav-link active" href="{{ route('admin.fundraiser-reports.index') }}"><i class="fa-solid fa-flag"></i> Reports</a>
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
                        <p class="text-muted small mb-1">Supporter report data</p>
                        <h1 class="h4 fw-bold mb-0">Reports</h1>
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
                    <div class="alert alert-success fw-bold">{{ session('status') }}</div>
                @endif
                <div class="panel">
                    <div class="section-head">
                        <div>
                            <h2>Supporter Reports</h2>
                            <p>Reports submitted from fundraiser detail pages by supporters or visitors.</p>
                        </div>
                        <span class="count-pill">{{ $supporterReports->total() }} total</span>
                    </div>
                    <div class="status-overview">
                        @foreach (\App\Models\FundraiserReport::statuses() as $statusValue => $statusLabel)
                            @php
                                $statusClass = str_replace('_', '-', $statusValue);
                                $statusIcon = [
                                    \App\Models\FundraiserReport::STATUS_UNDER_PROCESSING => 'fa-hourglass-half',
                                    \App\Models\FundraiserReport::STATUS_SOLVED => 'fa-circle-check',
                                    \App\Models\FundraiserReport::STATUS_DISMISSED => 'fa-circle-xmark',
                                ][$statusValue] ?? 'fa-flag';
                            @endphp
                            <article class="status-tile status-tile--{{ $statusClass }}">
                                <div>
                                    <span>{{ $statusLabel }}</span>
                                    <strong>{{ number_format($statusCounts[$statusValue] ?? 0) }}</strong>
                                </div>
                                <i class="fa-solid {{ $statusIcon }}"></i>
                            </article>
                        @endforeach
                    </div>
                    <div class="table-responsive">
                    <table class="table align-middle mb-0 reports-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Fundraiser</th>
                                <th>Post ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supporterReports as $report)
                                @php
                                    $currentStatus = $report->status ?: \App\Models\FundraiserReport::STATUS_UNDER_PROCESSING;
                                    $statusClass = str_replace('_', '-', $currentStatus);
                                    $statusIcon = [
                                        \App\Models\FundraiserReport::STATUS_UNDER_PROCESSING => 'fa-hourglass-half',
                                        \App\Models\FundraiserReport::STATUS_SOLVED => 'fa-circle-check',
                                        \App\Models\FundraiserReport::STATUS_DISMISSED => 'fa-circle-xmark',
                                    ][$currentStatus] ?? 'fa-flag';
                                @endphp
                                <tr>
                                    <td>#{{ $report->id }}</td>
                                    <td>
                                        <strong>{{ $report->created_at->format('d M Y') }}</strong>
                                        <div class="muted-meta">{{ $report->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        @if ($report->fundraiserPost)
                                            <a class="fw-bold report-title-link" href="{{ route('donate-us', $report->fundraiserPost) }}" target="_blank">{{ $report->fundraiserPost->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $report->fundraiser_post_id ?: '-' }}</td>
                                    <td>{{ $report->name ?: '-' }}</td>
                                    <td>{{ $report->email ?: '-' }}</td>
                                    <td>{{ trim(($report->country_code ?? '') . ' ' . ($report->phone ?? '')) ?: '-' }}</td>
                                    <td class="message-cell">{{ $report->message ?: '-' }}</td>
                                    <td class="status-cell">
                                        <form class="report-status-form" action="{{ route('admin.reports.status', $report->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="status-control">
                                                <div class="status-control__top">
                                                    <span class="status-badge status-badge--{{ $statusClass }}"><i class="fa-solid {{ $statusIcon }}"></i>{{ $report->statusLabel() }}</span>
                                                    <span class="status-control__hint">Change</span>
                                                </div>
                                                <select class="form-select form-select-sm report-status-select report-status-select--{{ $statusClass }}" name="status" aria-label="Report status" onchange="this.form.submit()">
                                                    @foreach (\App\Models\FundraiserReport::statuses() as $statusValue => $statusLabel)
                                                        <option value="{{ $statusValue }}" @selected($currentStatus === $statusValue)>{{ $statusLabel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($report->supporting_document)
                                            <a class="doc-link" href="{{ asset('storage/' . $report->supporting_document) }}" target="_blank"><i class="fa-solid fa-paperclip"></i> View</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-5">No supporter side reports yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="p-3">{{ $supporterReports->links() }}</div>
                </div>
            </div>
        </main>
    </div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>



