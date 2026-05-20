@extends('fundraiser.layout')

@section('title', 'Fundraiser Dashboard')

@section('content')
    <section class="dashboard-panel p-3 p-md-5 mb-4">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div>
                <p class="muted mb-1">Logged in as {{ $fundraiser->name }}</p>
                <h1 class="fw-black mb-2">Fundraiser Dashboard</h1>
                <p class="muted mb-0">Create campaigns, track approval status, and monitor donation progress.</p>
            </div>
            <span class="status-badge {{ $fundraiser->status }}">
                <i class="fa-solid {{ $fundraiser->status === \App\Models\Fundraiser::STATUS_APPROVED ? 'fa-circle-check' : 'fa-circle-info' }}"></i>
                {{ $fundraiser->status === \App\Models\Fundraiser::STATUS_APPROVED ? 'Active Account' : ucfirst($fundraiser->status).' Account' }}
            </span>
        </div>
    </section>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a class="dashboard-card d-block p-4 {{ $fundraiser->canManagePosts() ? '' : 'pe-none opacity-75' }}" href="{{ $fundraiser->canManagePosts() ? route('fundraiser.posts.create') : '#' }}" aria-disabled="{{ $fundraiser->canManagePosts() ? 'false' : 'true' }}">
                <span class="icon-pill mb-3"><i class="fa-solid fa-plus"></i></span>
                <h3 class="fw-black">Create Post</h3>
                <p class="muted mb-4">Submit a new fundraiser campaign for admin approval with images, documents, and beneficiary details.</p>
                <span class="btn btn-gold">{{ $fundraiser->canManagePosts() ? 'Create fundraiser post' : 'Post creation blocked' }}</span>
            </a>
        </div>
        <div class="col-md-6">
            <a class="dashboard-card d-block p-4" href="{{ route('fundraiser.posts.index') }}">
                <span class="icon-pill mb-3"><i class="fa-solid fa-rectangle-list"></i></span>
                <h3 class="fw-black">My Posts</h3>
                <p class="muted mb-4">View all campaigns created by you, filter by status, review donors, and edit pending posts.</p>
                <span class="btn btn-soft">View my posts</span>
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="dashboard-card p-4">
                <p class="muted mb-1">Total posts</p>
                <h3 class="fw-black mb-0">{{ number_format($stats['total_posts']) }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dashboard-card p-4">
                <p class="muted mb-1">Pending</p>
                <h3 class="fw-black mb-0">{{ number_format($stats['pending_posts']) }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dashboard-card p-4">
                <p class="muted mb-1">Total raised</p>
                <h3 class="fw-black mb-0">Rs. {{ number_format($stats['total_raised'], 0) }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dashboard-card p-4">
                <p class="muted mb-1">Donors</p>
                <h3 class="fw-black mb-0">{{ number_format($stats['total_donors']) }}</h3>
            </div>
        </div>
    </div>

    <section class="dashboard-panel p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
            <div>
                <h4 class="fw-black mb-1">Recent Posts</h4>
                <p class="muted mb-0">A quick look at your latest fundraiser campaigns.</p>
            </div>
            <a href="{{ route('fundraiser.posts.index') }}" class="btn btn-soft">Open My Posts</a>
        </div>

        <div class="row g-3">
            @forelse ($recentPosts as $post)
                @php
                    $raised = max((float) $post->raised_amount, (float) ($post->paid_donations_main_sum_amount ?? 0));
                    $goal = max((float) $post->goal_amount, 1);
                    $progress = min(100, (int) round(($raised / $goal) * 100));
                @endphp
                <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card overflow-hidden">
                        <img class="fundraiser-image" src="{{ $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png') }}" alt="{{ $post->title }}">
                        <div class="p-3">
                            <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
                            <h6 class="fw-black mt-3">{{ $post->title }}</h6>
                            @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                                <div class="approved-progress my-2" aria-hidden="true">
                                    <span class="approved-progress__fill" style="--progress-width: {{ $progress }}%"></span>
                                </div>
                            @else
                                <div class="progress my-2">
                                    <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                </div>
                            @endif
                            <p class="small muted mb-3">Rs. {{ number_format($raised, 0) }} raised of Rs. {{ number_format($goal, 0) }}</p>
                            <a href="{{ route('fundraiser.posts.show', $post) }}" class="btn btn-sm btn-soft w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-4">
                        <h5 class="fw-black">No fundraiser posts yet.</h5>
                        <p class="muted">Create your first campaign and submit it for approval.</p>
                        @if ($fundraiser->canManagePosts())
                            <a href="{{ route('fundraiser.posts.create') }}" class="btn btn-gold">Create Post</a>
                        @else
                            <span class="btn btn-gold opacity-75 pe-none" aria-disabled="true">Post creation blocked</span>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection
