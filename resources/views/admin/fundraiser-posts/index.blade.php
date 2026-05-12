<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Fundraiser Posts | Karna Kabach Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #ffb33f;
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
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gold-soft);
            color: #ff7a00;
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
            padding: 18px clamp(16px, 3vw, 32px);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .content {
            padding: clamp(16px, 3vw, 32px);
        }

        .panel,
        .post-card {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            box-shadow: 0 8px 22px rgba(18, 24, 39, 0.08);
        }

        .post-card {
            height: 100%;
            overflow: hidden;
        }

        .post-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #eef1f5;
        }

        .muted {
            color: var(--muted);
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

        .badge-status {
            border: 0;
            background: var(--gold-soft);
            color: #a16207;
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
                <a class="nav-link active" href="{{ route('admin.fundraiser-posts.index') }}"><i class="fa-solid fa-rectangle-list"></i> Fundraiser Posts</a>
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
                        <h1 class="h4 fw-black mb-0">Fundraiser Posts</h1>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn btn-sm btn-warning fw-bold" type="submit">Logout</button>
                </form>
            </header>

            <section class="content">
                @if (session('status'))
                    <div class="alert alert-success border-0 mb-4">{{ session('status') }}</div>
                @endif

                <div class="panel p-3 p-md-4 mb-4">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $key => $label)
                            <a class="filter-link {{ $status === $key ? 'active' : '' }}" href="{{ route('admin.fundraiser-posts.index', ['status' => $key]) }}">
                                {{ $label }}
                                <span>{{ $counts[$key] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="row g-3">
                    @forelse ($posts as $post)
                        <div class="col-lg-6 col-xl-4">
                            <article class="post-card">
                                @if ($post->main_image)
                                    <img src="{{ asset('storage/'.$post->main_image) }}" alt="{{ $post->title }}">
                                @endif
                                <div class="p-3">
                                    <div class="d-flex justify-content-between gap-3 mb-2">
                                        <span class="badge badge-status">{{ ucfirst($post->status) }}</span>
                                        <span class="muted small">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h2 class="h5 fw-black">{{ $post->title }}</h2>
                                    <p class="muted">{{ $post->short_description }}</p>
                                    <p class="mb-1"><strong>Fundraiser:</strong> {{ $post->fundraiser?->name ?? 'Unknown' }}</p>
                                    <p class="mb-1"><strong>Goal:</strong> Rs. {{ number_format((float) $post->goal_amount, 2) }}</p>
                                    <p class="mb-3"><strong>Location:</strong> {{ $post->location }}</p>

                                    @if ($post->supporting_file)
                                        <a class="document-link mb-3" href="{{ asset('storage/'.$post->supporting_file) }}" target="_blank" rel="noopener">View supporting file</a>
                                    @endif

                                    <div class="d-flex flex-wrap gap-2">
                                        <form action="{{ route('admin.fundraiser-posts.approve', $post) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-warning btn-sm fw-bold" type="submit" @disabled($post->status === 'approved')>Approve</button>
                                        </form>
                                        <form action="{{ route('admin.fundraiser-posts.reject', $post) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-outline-light btn-sm fw-bold" type="submit" @disabled($post->status === 'rejected')>Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="panel p-4 text-center">
                                <p class="mb-0 muted">No fundraiser posts found for this status.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </main>
    </div>
</body>
</html>
