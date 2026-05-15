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
        .panel + .panel { margin-top:24px; }
        .section-head { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; padding:20px 20px 0; }
        .section-head h2 { margin:0; font-size:20px; font-weight:900; }
        .section-head p { margin:4px 0 0; color:var(--muted); }
        .count-pill { border-radius:999px; padding:6px 10px; color:var(--gold); background:var(--gold-soft); font-weight:900; }
        .message-cell { max-width:360px; white-space:normal; }
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
                <a class="nav-link" href="{{ route('admin.contact-messages.index') }}"><i class="fa-solid fa-envelope"></i> Contact Messages</a>
                <a class="nav-link active" href="{{ route('admin.fundraiser-reports.index') }}"><i class="fa-solid fa-flag"></i> Reports</a>
                <a class="nav-link" href="{{ route('admin.donations.index') }}"><i class="fa-solid fa-indian-rupee-sign"></i> Donations</a>
                <a class="nav-link" href="{{ route('admin.supporters.index') }}"><i class="fa-solid fa-users"></i> Supporters</a>
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <main>
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-muted small mb-1">Site and supporter report data</p>
                        <h1 class="h4 fw-bold mb-0">Reports</h1>
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
                        <form action="{{ route('logout') }}" method="post">@csrf<button class="btn btn-sm btn-warning fw-bold" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form>
                    </div>
                </div>
            </header>

            <div class="content">
                <div class="panel">
                    <div class="section-head">
                        <div>
                            <h2>Site Related Reports</h2>
                            <p>General website issues, misuse reports, page problems, and support concerns.</p>
                        </div>
                        <span class="count-pill">{{ $siteReports->total() }} total</span>
                    </div>
                    <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Page</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Document</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siteReports as $report)
                                <tr>
                                    <td>#{{ $report->id }}</td>
                                    <td>{{ $report->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $report->name ?: '-' }}</td>
                                    <td>{{ $report->email ?: '-' }}</td>
                                    <td>{{ $report->phone ?: '-' }}</td>
                                    <td class="message-cell">{{ $report->page_url ?: '-' }}</td>
                                    <td>{{ $report->subject ?: '-' }}</td>
                                    <td class="message-cell">{{ $report->message ?: '-' }}</td>
                                    <td>
                                        @if ($report->supporting_document)
                                            <a href="{{ asset('storage/' . $report->supporting_document) }}" target="_blank">View</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($report->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-5">No site reports yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="p-3">{{ $siteReports->links() }}</div>
                </div>

                <div class="panel">
                    <div class="section-head">
                        <div>
                            <h2>Supporter Side Reports</h2>
                            <p>Reports submitted from fundraiser detail pages by supporters or visitors.</p>
                        </div>
                        <span class="count-pill">{{ $supporterReports->total() }} total</span>
                    </div>
                    <div class="table-responsive">
                    <table class="table align-middle mb-0">
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
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supporterReports as $report)
                                <tr>
                                    <td>#{{ $report->id }}</td>
                                    <td>{{ $report->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        @if ($report->fundraiserPost)
                                            <a class="fw-bold" href="{{ route('donate-us', $report->fundraiserPost) }}" target="_blank">{{ $report->fundraiserPost->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $report->fundraiser_post_id ?: '-' }}</td>
                                    <td>{{ $report->name ?: '-' }}</td>
                                    <td>{{ $report->email ?: '-' }}</td>
                                    <td>{{ trim(($report->country_code ?? '') . ' ' . ($report->phone ?? '')) ?: '-' }}</td>
                                    <td class="message-cell">{{ $report->message ?: '-' }}</td>
                                    <td>
                                        @if ($report->supporting_document)
                                            <a href="{{ asset('storage/' . $report->supporting_document) }}" target="_blank">View</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-5">No supporter side reports yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="p-3">{{ $supporterReports->links() }}</div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
