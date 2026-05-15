@extends('fundraiser.layout')

@section('title', 'My Fundraiser Posts')

@section('content')
    <section class="dashboard-panel p-3 p-md-4 mb-4">
        <div class="posts-panel-header d-flex justify-content-between gap-3 flex-wrap mb-4">
            <div>
                <p class="muted mb-1">My Posts</p>
                <h1 class="fw-black mb-2">Your Fundraiser Campaigns</h1>
                <p class="muted mb-0">Search, filter, and manage every campaign created by your account.</p>
            </div>
            <a class="btn btn-gold" href="{{ route('fundraiser.posts.create') }}"><i class="fa-solid fa-plus"></i>Create Post</a>
        </div>

        <form action="{{ route('fundraiser.posts.index') }}" method="get" class="row g-3 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-bold" for="search">Search posts</label>
                <input class="form-control" id="search" type="search" name="search" value="{{ $search }}" placeholder="Search by title, cause, beneficiary, or location">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="status">Filter by status</label>
                <select class="form-select" id="status" name="status">
                    <option value="all" @selected($status === 'all')>All ({{ $counts['all'] }})</option>
                    <option value="pending" @selected($status === 'pending')>Pending ({{ $counts['pending'] }})</option>
                    <option value="approved" @selected($status === 'approved')>Approved ({{ $counts['approved'] }})</option>
                    <option value="rejected" @selected($status === 'rejected')>Rejected ({{ $counts['rejected'] }})</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-gold w-100" type="submit">Apply</button>
            </div>
        </form>
    </section>

    <div class="row g-4">
        @forelse ($posts as $post)
            @php
                $donationTotal = (float) ($post->paid_donations_main_sum_amount ?? 0);
                $raised = max((float) $post->raised_amount, $donationTotal);
                $goal = max((float) $post->goal_amount, 1);
                $remaining = max($goal - $raised, 0);
                $progress = min(100, (int) round(($raised / $goal) * 100));
            @endphp
            <div class="col-md-6 col-xl-4">
                <article class="dashboard-card overflow-hidden">
                    <img class="fundraiser-image" src="{{ $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png') }}" alt="{{ $post->title }}">
                    <div class="p-3 p-lg-4">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                            <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
                            <span class="small muted">ID #{{ $post->id }}</span>
                        </div>
                        <h4 class="fw-black">{{ $post->title }}</h4>
                        <p class="muted">{{ \Illuminate\Support\Str::limit($post->short_description, 105) }}</p>

                        @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                            <div class="approved-progress mb-2" aria-hidden="true">
                                <span class="approved-progress__fill" style="--progress-width: {{ $progress }}%"></span>
                            </div>
                        @else
                            <div class="progress mb-2">
                                <div class="progress-bar" style="width: {{ $progress }}%"></div>
                            </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between small fw-bold mb-3">
                            <span>{{ $progress }}%</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="row g-2 small mb-3">
                            <div class="col-6"><strong>Goal:</strong><br>Rs. {{ number_format($goal, 0) }}</div>
                            <div class="col-6"><strong>Donations:</strong><br>Rs. {{ number_format($donationTotal, 0) }}</div>
                            <div class="col-6"><strong>Raised:</strong><br>Rs. {{ number_format($raised, 0) }}</div>
                            <div class="col-6"><strong>Remaining:</strong><br>Rs. {{ number_format($remaining, 0) }}</div>
                            <div class="col-6"><strong>Donors:</strong><br>{{ number_format($post->paid_donations_count) }}</div>
                            <div class="col-6"><strong>Cause:</strong><br>{{ $post->category }}</div>
                        </div>

                        <div class="post-card-actions">
                            <a class="btn btn-sm btn-soft post-action-primary" href="{{ route('fundraiser.posts.show', $post) }}">View Details</a>
                            @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                                <a class="btn btn-sm btn-gold" href="{{ route('fundraiser.posts.updates.index', $post) }}">Manage Post</a>
                            @endif
                            @if ($post->status === \App\Models\FundraiserPost::STATUS_PENDING)
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('fundraiser.posts.edit', $post) }}">Edit</a>
                            @endif
                            <form class="post-action-form" action="{{ route('fundraiser.posts.destroy', $post) }}" method="post" data-delete-confirm>
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <section class="dashboard-panel p-5 text-center">
                    <h4 class="fw-black">No fundraiser posts found.</h4>
                    <p class="muted">Try changing your filters or create your first fundraiser campaign.</p>
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
