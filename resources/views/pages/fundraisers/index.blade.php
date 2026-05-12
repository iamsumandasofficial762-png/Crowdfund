<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Fundraisers | Karna Kabach</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/all.min.css') }}">
    <style>
        :root {
            --gold: #ffb33f;
            --ink: #0a0a0a;
            --muted: #6c6c6c;
        }

        body {
            margin: 0;
            font-family: "Nunito", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #ffffff;
            background:
                radial-gradient(circle at 100% 20%, rgba(255, 179, 63, 0.26), transparent 30%),
                linear-gradient(135deg, #000000, #151515 62%, #3a2408);
        }

        .public-page {
            min-height: 100vh;
            padding: 34px 14px;
        }

        .shell {
            width: min(100%, 1120px);
            margin: 0 auto;
        }

        .topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 42px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .hero {
            margin-bottom: 32px;
        }

        .hero span {
            color: var(--gold);
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .hero h1 {
            max-width: 760px;
            margin: 10px 0 12px;
            color: #ffffff;
            font-size: clamp(34px, 5vw, 60px);
            font-weight: 900;
            line-height: 1.02;
        }

        .hero p {
            max-width: 650px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 17px;
            line-height: 1.7;
        }

        .fundraiser-card {
            height: 100%;
            border: 1px solid rgba(255, 179, 63, 0.22);
            border-radius: 14px;
            padding: 22px;
            background: rgba(255, 255, 255, 0.96);
            color: var(--ink);
            box-shadow: 0 18px 48px rgba(0, 0, 0, 0.24);
        }

        .badge-cause {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 10px;
            background: rgba(255, 179, 63, 0.2);
            color: #7a4700;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .fundraiser-card h2 {
            margin: 16px 0 8px;
            font-size: 22px;
            font-weight: 900;
        }

        .fundraiser-card p {
            color: var(--muted);
        }

        .empty-state {
            border: 1px solid rgba(255, 179, 63, 0.22);
            border-radius: 14px;
            padding: 28px;
            background: rgba(0, 0, 0, 0.34);
            color: rgba(255, 255, 255, 0.74);
        }
    </style>
</head>
<body>
    <main class="public-page">
        <div class="shell">
            <header class="topline">
                <a class="logo" href="{{ route('home') }}" aria-label="Karna Kabach home">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kabach">
                </a>
                <a class="btn btn-warning fw-bold" href="{{ route('fundraiser-details') }}">Start a fundraiser</a>
            </header>

            <section class="hero">
                <span>Approved fundraisers</span>
                <h1>Verified profiles ready for public support.</h1>
                <p>Only fundraiser profiles approved by the admin team appear here.</p>
            </section>

            <div class="row g-3">
                @forelse ($fundraisers as $fundraiser)
                    <div class="col-md-6 col-xl-4">
                        <article class="fundraiser-card">
                            <span class="badge-cause">{{ $fundraiser->cause }}</span>
                            <h2>{{ $fundraiser->name }}</h2>
                            <p class="mb-3">This fundraiser has been reviewed and approved for public visibility.</p>
                            <p class="mb-0"><i class="fa-solid fa-phone me-2 text-warning"></i>{{ $fundraiser->full_phone }}</p>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            No approved fundraiser profiles are available yet.
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($fundraisers->hasPages())
                <div class="d-flex justify-content-between align-items-center gap-3 mt-4">
                    <a class="btn btn-outline-warning {{ $fundraisers->onFirstPage() ? 'disabled' : '' }}" href="{{ $fundraisers->previousPageUrl() ?? '#' }}">Previous</a>
                    <span class="text-white-50 small">Page {{ $fundraisers->currentPage() }} of {{ $fundraisers->lastPage() }}</span>
                    <a class="btn btn-outline-warning {{ $fundraisers->hasMorePages() ? '' : 'disabled' }}" href="{{ $fundraisers->nextPageUrl() ?? '#' }}">Next</a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
