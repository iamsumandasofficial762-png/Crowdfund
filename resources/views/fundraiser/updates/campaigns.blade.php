@extends('fundraiser.layout')

@section('title', 'Story Updates')

@push('styles')
    <style>
        .campaign-progress {
            margin: 18px 0 18px;
            padding: 18px 22px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fff7f5 0%, #f8f9fc 100%);
        }

        .campaign-progress__header,
        .campaign-progress__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .campaign-progress__title {
            margin: 0;
            color: #183153;
            font-size: 18px;
            font-weight: 800;
        }

        .campaign-progress__percent {
            color: #263c5d;
            font-weight: 900;
        }

        .campaign-progress__track {
            height: 7px;
            margin: 9px 0 13px;
            border-radius: 999px;
            background: #eadcda;
            overflow: hidden;
        }

        .campaign-progress__bar {
            height: 100%;
            border-radius: inherit;
            background: #b53a2d;
        }

        .campaign-progress__meta {
            color: #65728a;
            font-size: 14px;
            line-height: 1.35;
        }

        .campaign-progress__meta strong {
            color: #c44737;
            font-weight: 500;
        }

        @media (max-width: 420px) {
            .campaign-progress {
                padding: 16px;
            }

            .campaign-progress__meta {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="dashboard-panel p-3 p-md-4 mb-4">
        <div class="posts-panel-header d-flex justify-content-between gap-3 flex-wrap">
            <div>
                <p class="muted mb-1">Story Updates</p>
                <h1 class="fw-black mb-2">Choose a campaign to update</h1>
                <p class="muted mb-0">Post treatment progress, urgent announcements, thank-you notes, and other campaign updates.</p>
            </div>
            <a class="btn btn-gold" href="{{ route('fundraiser.posts.create') }}"><i class="fa-solid fa-plus"></i>Create Post</a>
        </div>
    </section>

    <div class="row g-4">
        @forelse ($posts as $post)
            @php
                $donationTotal = (float) ($post->paid_donations_sum_amount ?? 0);
                $raised = max((float) $post->raised_amount, $donationTotal);
                $goal = max((float) $post->goal_amount, 1);
                $progress = min(100, (int) round(($raised / $goal) * 100));
            @endphp
            <div class="col-md-6 col-xl-4">
                <article class="dashboard-card overflow-hidden">
                    <img class="fundraiser-image" src="{{ $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png') }}" alt="{{ $post->title }}">
                    <div class="p-3 p-lg-4">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
                            <span class="small muted">{{ number_format($post->published_updates_count) }} published</span>
                        </div>
                        <h4 class="fw-black">{{ $post->title }}</h4>
                        <p class="muted">{{ \Illuminate\Support\Str::limit($post->short_description, 105) }}</p>
                        <div class="campaign-progress">
                            <div class="campaign-progress__header">
                                <h5 class="campaign-progress__title">Donation Progress</h5>
                                <span class="campaign-progress__percent">{{ $progress }}%</span>
                            </div>
                            <div class="campaign-progress__track" aria-hidden="true">
                                <div class="campaign-progress__bar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="campaign-progress__meta">
                                <span>Raised: <strong>Rs. {{ number_format($raised, 0) }}</strong></span>
                                <span>Goal: <strong>Rs. {{ number_format($goal, 0) }}</strong></span>
                            </div>
                        </div>
                        <a class="btn btn-gold w-100" href="{{ route('fundraiser.posts.updates.index', $post) }}">
                            <i class="fa-solid fa-pen-to-square"></i>Manage Updates
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <section class="dashboard-panel p-5 text-center">
                    <h4 class="fw-black">No fundraiser posts yet.</h4>
                    <p class="muted">Create your first campaign before posting story updates.</p>
                    <a class="btn btn-gold" href="{{ route('fundraiser.posts.create') }}">Create Post</a>
                </section>
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div class="dashboard-panel p-3 mt-4">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
