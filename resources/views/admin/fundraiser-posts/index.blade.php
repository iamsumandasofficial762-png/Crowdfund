<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fundraiser Posts | Karna Kabach Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #932a19;
            --gold-dark: #b21f17;
            --gold-soft: #f7e1df;
            --bg: #f7f8fb;
            --panel: #ffffff;
            --line: #dde2ea;
            --ink: #121827;
            --muted: #647083;
            --green-soft: #e2f4e6;
            --green: #168231;
            --yellow-soft: #fff2cc;
            --yellow: #b76a00;
            --red-soft: #fde4e2;
            --red: #b42318;
            --red-dark: #7f1d1d;
        }

        body {
            margin: 0;
            color: var(--ink);
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .admin-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            min-width: 300px;
            border-right: 1px solid var(--line);
            padding: 30px 22px;
            background: #ffffff;
        }

        .brand {
            min-height: 44px;
            align-items: center;
        }

        .brand img {
            width: 154px;
            height: auto;
            display: block;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
            border-radius: 12px;
            padding: 13px 15px;
            color: #2f3a4c;
            font-weight: 800;
            line-height: 1.2;
        }

        .nav-link i {
            width: 20px;
            display: inline-flex;
            justify-content: center;
            line-height: 1;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gold-soft);
            color: #932a19;
        }

        .nav-link:focus,
        .nav-link:active {
            background: #efd1cd;
            color: #000000;
        }

        .main {
            background: #f8f9fb;
            min-width: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid var(--line);
            padding: 22px clamp(18px, 3vw, 36px);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .topbar-inner,
        .content-inner {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        .content {
            padding: 28px clamp(18px, 2vw, 30px) 48px;
        }

        .panel,
        .post-card {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
        }

        .filters-panel {
            padding: 24px;
        }

        .post-card {
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .post-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #eef1f5;
        }

        .post-card__body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .post-card__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .post-card__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: auto;
        }

        .post-card__actions form {
            margin: 0;
        }

        .post-card__actions .btn,
        .moderation-btn {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
        }

        .moderation-btn {
            position: relative;
            gap: 7px;
            border-radius: 8px;
            border: 1px solid transparent;
            padding: 8px 16px;
            color: #ffffff;
            font-weight: 900;
            line-height: 1;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease;
        }

        .moderation-btn:hover,
        .moderation-btn:focus {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(18, 24, 39, 0.14);
        }

        .moderation-btn.is-loading {
            pointer-events: none;
            color: transparent !important;
        }

        .moderation-btn.is-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.55);
            border-top-color: #ffffff;
            border-radius: 999px;
            animation: moderation-spin 0.7s linear infinite;
        }

        .moderation-btn.is-hidden,
        .moderation-form.is-hidden {
            display: none !important;
        }

        .moderation-btn--approve {
            border-color: #168231;
            background: #168231;
        }

        .moderation-btn--approve:hover,
        .moderation-btn--approve:focus {
            background: #106625;
        }

        .moderation-btn--hold {
            border-color: #f2bd3d;
            background: #f2bd3d;
            color: #352100;
        }

        .moderation-btn--hold:hover,
        .moderation-btn--hold:focus {
            border-color: #d99100;
            background: #d99100;
            color: #ffffff;
        }

        .moderation-btn--reject {
            border-color: #b42318;
            background: #b42318;
        }

        .moderation-btn--reject:hover,
        .moderation-btn--reject:focus {
            background: #931f16;
        }

        .moderation-btn--delete {
            border-color: var(--red-dark);
            background: var(--red-dark);
        }

        .moderation-btn--delete:hover,
        .moderation-btn--delete:focus {
            background: #5f1515;
        }

        @keyframes moderation-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .muted {
            color: var(--muted);
        }

        .filter-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--line);
            border-radius: 999px;
            min-height: 42px;
            padding: 9px 16px;
            color: #2f3a4c;
            font-weight: 800;
            line-height: 1;
            background: #ffffff;
        }

        .filter-link.active,
        .filter-link:hover {
            border-color: rgba(147, 42, 25, 0.5);
            color: #ffffff;
            background: var(--gold);
        }

        .filter-link:focus,
        .filter-link:active {
            border-color: var(--gold-dark);
            color: #ffffff;
            background: var(--gold-dark);
        }

        .filter-link.active span,
        .filter-link:hover span,
        .filter-link:focus span,
        .filter-link:active span {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.18);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            border-radius: 999px;
            padding: 6px 10px;
            border: 0;
            background: #edf1f7;
            color: #586174;
            font-weight: 900;
        }

        .badge-status.pending {
            background: #edf1f7;
            color: #586174;
        }

        .badge-status.approved {
            color: #137333;
            background: #dff7e7;
        }

        .badge-status.hold {
            color: var(--yellow);
            background: var(--yellow-soft);
        }

        .badge-status.rejected {
            color: #a12828;
            background: #ffe1e1;
        }

        .status-reason {
            min-height: 20px;
        }

        .admin-toast-wrap {
            position: fixed;
            right: 22px;
            top: 22px;
            z-index: 11000;
            display: grid;
            gap: 10px;
            width: min(360px, calc(100vw - 32px));
        }

        .admin-toast {
            border: 1px solid rgba(22, 130, 49, 0.18);
            border-radius: 14px;
            padding: 13px 16px;
            color: #0f5132;
            background: #e7f7ec;
            box-shadow: 0 18px 42px rgba(18, 24, 39, 0.16);
            font-weight: 900;
            transform: translateY(-10px);
            opacity: 0;
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        .admin-toast.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .admin-toast--error {
            border-color: rgba(180, 35, 24, 0.18);
            color: #842029;
            background: #fde4e2;
        }

        .modal-backdrop.show {
            opacity: 0.22;
            backdrop-filter: blur(8px);
        }

        .moderation-modal .modal-content {
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 22px 60px rgba(18, 24, 39, 0.2);
        }

        .moderation-modal textarea {
            min-height: 130px;
            border-radius: 12px;
            font-weight: 700;
        }

        .document-link {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 10px;
            background: #f1f4f8;
            color: var(--ink);
            font-size: 12px;
            font-weight: 800;
        }

        .empty-panel {
            min-height: 120px;
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .btn-outline-light {
            border-color: #d6dce5;
            color: var(--ink);
        }

        .btn-outline-light:hover {
            border-color: var(--red);
            background: var(--red-soft);
            color: var(--red);
        }

        .btn-warning:hover,
        .btn-warning:focus,
        .btn-warning:active,
        .btn-warning:first-child:active,
        .btn-outline-warning:hover,
        .btn-outline-warning:focus,
        .btn-outline-warning:active,
        .btn-outline-warning:first-child:active {
            border-color: var(--gold-dark);
            color: #ffffff !important;
            background: var(--gold-dark);
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.22);
        }

        .btn-warning,
        .btn-warning:focus {
            border-color: var(--gold);
            color: #ffffff !important;
            background: var(--gold);
        }

        .btn-outline-warning {
            border-color: var(--gold);
            color: var(--gold);
        }

        .alert-auto-dismiss {
            transition: opacity 0.35s ease, transform 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease;
        }

        .alert-auto-dismiss.is-hiding {
            opacity: 0;
            transform: translateY(-8px);
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            border-width: 0 !important;
            overflow: hidden;
        }

        .btn-outline-light:focus,
        .btn-outline-light:active,
        .btn-outline-light:first-child:active {
            border-color: var(--red);
            background: var(--red);
            color: #ffffff;
        }

        .mobile-toggle {
            display: none;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .topbar-actions form {
            margin: 0;
        }

        .topbar-actions .btn {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .profile-btn {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #ffffff;
            color: var(--ink);
            box-shadow: 0 4px 12px rgba(18, 24, 39, 0.06);
        }

        .profile-btn:hover,
        .profile-btn:focus,
        .profile-btn:active,
        .profile-btn.show,
        .profile-btn:first-child:active {
            border-color: rgba(147, 42, 25, 0.75);
            color: #000000;
            background: #efd1cd;
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.18);
        }

        .dropdown-menu {
            border: 1px solid var(--line);
            background: #ffffff;
            box-shadow: 0 14px 34px rgba(18, 24, 39, 0.12);
        }

        .dropdown-item:hover {
            color: var(--gold);
            background: var(--gold-soft);
        }

        @media (max-width: 991px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                z-index: 20;
                width: 280px;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 575px) {
            .topbar {
                padding: 16px;
            }

            .topbar-inner {
                align-items: flex-start !important;
                flex-direction: column;
            }

            .content {
                padding: 18px 16px 32px;
            }

            .filters-panel {
                padding: 18px;
            }

            .filter-link {
                flex: 1 1 calc(50% - 8px);
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar" id="sidebar">
            <a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
            </a>
            <nav>
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-table-cells-large"></i> Dashboard</a>
                <a class="nav-link active" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
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

        <main class="main">
            <header class="topbar">
                <div class="topbar-inner d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-sm btn-outline-warning mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')" aria-label="Toggle sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div>
                            <p class="muted small mb-1">Admin review</p>
                            <h1 class="h4 fw-black mb-0">Fundraiser Posts</h1>
                        </div>
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
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-warning fw-bold" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="content">
                <div class="content-inner">
                @if (session('status'))
                    <div class="alert alert-success alert-auto-dismiss border-0 mb-4" role="status" data-auto-dismiss="3500">{{ session('status') }}</div>
                @endif

                <div class="panel filters-panel mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach (['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'hold' => 'Hold', 'rejected' => 'Rejected'] as $key => $label)
                            <a class="filter-link {{ $status === $key ? 'active' : '' }}" href="{{ $key === 'all' ? route('admin.fundraiser-posts.index') : route('admin.fundraiser-posts.index', ['status' => $key]) }}">
                                {{ $label }}
                                <span data-status-count="{{ $key }}">{{ $counts[$key] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="row g-3">
                    @forelse ($posts as $post)
                        <div class="col-lg-6 col-xl-4">
                            @php
                                $actions = $post->adminActions();
                                $canApprove = in_array(\App\Models\FundraiserPost::ACTION_APPROVE, $actions, true);
                                $canHold = in_array(\App\Models\FundraiserPost::ACTION_HOLD, $actions, true);
                                $canReject = in_array(\App\Models\FundraiserPost::ACTION_REJECT, $actions, true);
                                $canDelete = in_array(\App\Models\FundraiserPost::ACTION_DELETE, $actions, true);
                            @endphp
                            <article class="post-card" data-post-card="{{ $post->id }}" data-current-status="{{ $post->status }}">
                                @if ($post->main_image)
                                    <img src="{{ asset('storage/'.$post->main_image) }}" alt="{{ $post->title }}">
                                @endif
                                <div class="post-card__body">
                                    <div class="post-card__meta">
                                        <span class="badge badge-status {{ $post->status }}" data-status-badge>{{ $post->statusLabel() }}</span>
                                        <span class="muted small">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h2 class="h5 fw-black">{{ $post->title }}</h2>
                                    <p class="muted">{{ $post->short_description }}</p>
                                    <p class="mb-1"><strong>Fundraiser:</strong> {{ $post->fundraiser?->name ?? 'Unknown' }}</p>
                                    <p class="mb-1"><strong>Goal:</strong> Rs. {{ number_format((float) $post->goal_amount, 2) }}</p>
                                    <p class="mb-3"><strong>Location:</strong> {{ $post->location }}</p>
                                    <p class="small fw-bold status-reason {{ $post->status === \App\Models\FundraiserPost::STATUS_REJECTED ? 'text-danger' : 'text-warning-emphasis' }}" data-status-reason>
                                        @if ($post->status === \App\Models\FundraiserPost::STATUS_HOLD && $post->hold_reason)
                                            {{ $post->hold_reason }}
                                        @elseif ($post->status === \App\Models\FundraiserPost::STATUS_REJECTED && $post->rejected_reason)
                                            {{ $post->rejected_reason }}
                                        @endif
                                    </p>

                                    @if ($post->supporting_file)
                                        <a class="document-link mb-3" href="{{ asset('storage/'.$post->supporting_file) }}" target="_blank" rel="noopener">View supporting file</a>
                                    @endif

                                    <div class="post-card__actions">
                                        <form class="moderation-form {{ $canApprove ? '' : 'is-hidden' }}" action="{{ route('admin.fundraiser-posts.status', $post) }}" method="post" data-moderation-form data-action="approve">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ \App\Models\FundraiserPost::STATUS_APPROVED }}">
                                            <button class="moderation-btn moderation-btn--approve btn-sm" type="submit"><i class="fa-solid fa-circle-check"></i>Approve</button>
                                        </form>

                                        <button class="moderation-btn moderation-btn--hold btn-sm {{ $canHold ? '' : 'is-hidden' }}" type="button" data-action="hold" data-bs-toggle="modal" data-bs-target="#holdPost{{ $post->id }}">
                                            <i class="fa-solid fa-pause"></i>Hold
                                        </button>

                                        <button class="moderation-btn moderation-btn--reject btn-sm {{ $canReject ? '' : 'is-hidden' }}" type="button" data-action="reject" data-bs-toggle="modal" data-bs-target="#rejectPost{{ $post->id }}">
                                            <i class="fa-solid fa-circle-xmark"></i>Reject
                                        </button>

                                        <form class="moderation-form {{ $canDelete ? '' : 'is-hidden' }}" action="{{ route('admin.fundraiser-posts.destroy', $post) }}" method="post" data-delete-confirm data-action="delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="moderation-btn moderation-btn--delete btn-sm" type="submit"><i class="fa-solid fa-trash-can"></i>Delete</button>
                                        </form>

                                        <div class="modal fade moderation-modal" id="holdPost{{ $post->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form class="modal-content" action="{{ route('admin.fundraiser-posts.status', $post) }}" method="post" data-moderation-form data-modal-form data-action="hold">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ \App\Models\FundraiserPost::STATUS_HOLD }}">
                                                    <div class="modal-header border-0">
                                                        <h2 class="modal-title h5 fw-bold">Hold post</h2>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <label class="form-label fw-bold" for="post_hold_reason_{{ $post->id }}">Reason for holding</label>
                                                        <textarea class="form-control" id="post_hold_reason_{{ $post->id }}" name="reason" required>{{ old('reason') }}</textarea>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="moderation-btn moderation-btn--hold" type="submit">Hold</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="modal fade moderation-modal" id="rejectPost{{ $post->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form class="modal-content" action="{{ route('admin.fundraiser-posts.status', $post) }}" method="post" data-moderation-form data-modal-form data-action="reject">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ \App\Models\FundraiserPost::STATUS_REJECTED }}">
                                                    <div class="modal-header border-0">
                                                        <h2 class="modal-title h5 fw-bold">Reject post?</h2>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <p class="muted">Rejected posts stay hidden from the public site. You can approve the post again later if needed.</p>
                                                        <label class="form-label fw-bold" for="post_rejected_reason_{{ $post->id }}">Reason for rejection</label>
                                                        <textarea class="form-control" id="post_rejected_reason_{{ $post->id }}" name="reason" required>{{ old('reason') }}</textarea>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="moderation-btn moderation-btn--reject" type="submit">Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="panel empty-panel text-center">
                                <p class="mb-0 muted">No fundraiser posts found for this status.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                </div>
            </section>
        </main>
    </div>
    <div class="admin-toast-wrap" data-toast-wrap aria-live="polite" aria-atomic="true"></div>
    @include('partials.delete-confirm-modal')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (() => {
            const actionMap = {
                pending: ['approve', 'hold', 'reject'],
                approved: ['hold', 'reject'],
                hold: ['approve', 'reject'],
                rejected: ['approve', 'delete'],
            };

            const toastWrap = document.querySelector('[data-toast-wrap]');

            const showToast = (message, type = 'success') => {
                if (!toastWrap) {
                    return;
                }

                const toast = document.createElement('div');
                toast.className = `admin-toast ${type === 'error' ? 'admin-toast--error' : ''}`;
                toast.textContent = message;
                toastWrap.appendChild(toast);

                requestAnimationFrame(() => toast.classList.add('is-visible'));
                window.setTimeout(() => {
                    toast.classList.remove('is-visible');
                    window.setTimeout(() => toast.remove(), 260);
                }, 3200);
            };

            const setLoading = (form, isLoading) => {
                const button = form.querySelector('button[type="submit"]');

                if (!button) {
                    return;
                }

                button.disabled = isLoading;
                button.classList.toggle('is-loading', isLoading);
            };

            const closeModal = (form) => {
                const modal = form.closest('.modal');

                if (!modal || !window.bootstrap) {
                    return;
                }

                const instance = bootstrap.Modal.getInstance(modal) || bootstrap.Modal.getOrCreateInstance(modal);
                instance.hide();
            };

            const updateCounts = (counts) => {
                if (!counts) {
                    return;
                }

                Object.entries(counts).forEach(([status, count]) => {
                    document.querySelectorAll(`[data-status-count="${status}"]`).forEach((node) => {
                        node.textContent = count;
                    });
                });
            };

            const updateCard = (post) => {
                const card = document.querySelector(`[data-post-card="${post.id}"]`);

                if (!card) {
                    return;
                }

                card.dataset.currentStatus = post.status;

                const badge = card.querySelector('[data-status-badge]');
                if (badge) {
                    badge.className = `badge badge-status ${post.status}`;
                    badge.textContent = post.status_label;
                }

                const reason = card.querySelector('[data-status-reason]');
                if (reason) {
                    reason.textContent = post.status === 'hold'
                        ? (post.hold_reason || '')
                        : (post.status === 'rejected' ? (post.rejected_reason || '') : '');
                    reason.classList.toggle('text-danger', post.status === 'rejected');
                    reason.classList.toggle('text-warning-emphasis', post.status !== 'rejected');
                }

                const allowedActions = post.actions || actionMap[post.status] || [];

                card.querySelectorAll('[data-action]').forEach((node) => {
                    const action = node.dataset.action;
                    node.classList.toggle('is-hidden', !allowedActions.includes(action));
                });
            };

            document.querySelectorAll('[data-auto-dismiss]').forEach((alert) => {
                const delay = Number(alert.dataset.autoDismiss) || 3500;

                window.setTimeout(() => {
                    alert.classList.add('is-hiding');
                    window.setTimeout(() => alert.remove(), 400);
                }, delay);
            });

            document.addEventListener('submit', async (event) => {
                const form = event.target.closest('form[data-moderation-form]');

                if (!form) {
                    return;
                }

                event.preventDefault();
                setLoading(form, true);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: new FormData(form),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        const message = data.message || Object.values(data.errors || {})[0]?.[0] || 'Unable to update fundraiser post status.';
                        throw new Error(message);
                    }

                    updateCard(data.post);
                    updateCounts(data.counts);
                    closeModal(form);
                    form.reset();
                    showToast(data.message);
                } catch (error) {
                    showToast(error.message || 'Unable to update fundraiser post status.', 'error');
                } finally {
                    setLoading(form, false);
                }
            });
        })();
    </script>
</body>
</html>



