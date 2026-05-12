<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Fundraiser Profiles | Karna Kabach Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #ffb33f;
            --gold-dark: #f5a400;
            --gold-soft: #fff3dd;
            --bg: #f7f8fb;
            --panel: #ffffff;
            --line: #dde2ea;
            --ink: #121827;
            --muted: #647083;
            --green-soft: #e2f4e6;
            --green: #168231;
            --red-soft: #fde4e2;
            --red: #b42318;
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
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid var(--line);
            padding: 24px 18px;
            background: #ffffff;
        }

        .brand img {
            width: 142px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            padding: 12px 14px;
            color: #2f3a4c;
            font-weight: 800;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gold-soft);
            color: #ff7a00;
            transform: translateX(4px);
        }

        .main {
            min-width: 0;
            background: #f8f9fb;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid var(--line);
            padding: 18px clamp(16px, 3vw, 32px);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .content {
            padding: clamp(16px, 3vw, 32px);
        }

        .panel,
        .profile-card {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
        }

        .muted {
            color: var(--muted);
        }

        .badge-status {
            border: 0;
            background: var(--gold-soft);
            color: #a16207;
        }

        .filter-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 8px 14px;
            color: #2f3a4c;
            font-weight: 800;
            background: #ffffff;
        }

        .filter-link.active,
        .filter-link:hover {
            border-color: rgba(255, 179, 63, 0.5);
            color: #080808;
            background: var(--gold);
        }

        .profile-card {
            padding: 20px;
            height: 100%;
        }

        .document-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin: 0 6px 6px 0;
            border-radius: 999px;
            padding: 6px 10px;
            background: #f1f4f8;
            color: var(--ink);
            font-size: 12px;
            font-weight: 800;
        }

        .document-link:hover {
            color: #ff7a00;
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

        .mobile-toggle {
            display: none;
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
                <a class="nav-link active" href="{{ route('admin.fundraisers.index') }}"><i class="fa-solid fa-hand-holding-heart"></i> Fundraiser Profiles</a>
                <a class="nav-link" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-warning mobile-toggle" type="button" onclick="document.getElementById('sidebar').classList.toggle('show')" aria-label="Toggle sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div>
                        <p class="muted small mb-1">Admin review</p>
                        <h1 class="h4 fw-black mb-0">Fundraiser Profiles</h1>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-sm btn-warning fw-bold" type="submit">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>
                        Logout
                    </button>
                </form>
            </header>

            <section class="content">
                @if (session('status'))
                    <div class="alert alert-success border-0 mb-4" role="status">{{ session('status') }}</div>
                @endif

                <div class="panel p-3 p-md-4 mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $key => $label)
                            <a class="filter-link {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.fundraisers.index', ['status' => $key]) }}">
                                {{ $label }}
                                <span>{{ $counts[$key] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="row g-3">
                    @forelse ($fundraisers as $fundraiser)
                        <div class="col-lg-6 col-xl-4">
                            <article class="profile-card">
                                <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                                    <div>
                                        <h2 class="h5 mb-1">{{ $fundraiser->name }}</h2>
                                        <p class="muted mb-0">{{ ucfirst($fundraiser->cause) }} fundraiser</p>
                                    </div>
                                    <span class="badge badge-status">{{ ucfirst($fundraiser->status) }}</span>
                                </div>

                                <p class="mb-2"><i class="fa-solid fa-phone text-warning me-2"></i>{{ $fundraiser->full_phone }}</p>
                                <p class="mb-2"><i class="fa-regular fa-envelope text-warning me-2"></i>{{ $fundraiser->email ?? 'No email on file' }}</p>
                                <p class="muted small mb-3">Submitted {{ $fundraiser->created_at->diffForHumans() }}</p>

                                <div class="mb-3">
                                    <p class="small fw-bold mb-2">Documents</p>
                                    @forelse ($fundraiser->documents ?? [] as $document)
                                        <a class="document-link" href="{{ asset('storage/'.$document) }}" target="_blank" rel="noopener">
                                            <i class="fa-solid fa-file"></i>
                                            View file
                                        </a>
                                    @empty
                                        <span class="muted small">No documents uploaded.</span>
                                    @endforelse
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <form action="{{ route('admin.fundraisers.approve', $fundraiser) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-warning btn-sm fw-bold" type="submit" @disabled($fundraiser->status === 'approved')>
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.fundraisers.reject', $fundraiser) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-outline-light btn-sm fw-bold" type="submit" @disabled($fundraiser->status === 'rejected')>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="panel p-4 text-center">
                                <p class="mb-0 muted">No fundraiser profiles found for this status.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if ($fundraisers->hasPages())
                    <div class="d-flex justify-content-between align-items-center gap-3 mt-4">
                        <a class="btn btn-outline-warning {{ $fundraisers->onFirstPage() ? 'disabled' : '' }}" href="{{ $fundraisers->previousPageUrl() ?? '#' }}">Previous</a>
                        <span class="muted small">Page {{ $fundraisers->currentPage() }} of {{ $fundraisers->lastPage() }}</span>
                        <a class="btn btn-outline-warning {{ $fundraisers->hasMorePages() ? '' : 'disabled' }}" href="{{ $fundraisers->nextPageUrl() ?? '#' }}">Next</a>
                    </div>
                @endif
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
