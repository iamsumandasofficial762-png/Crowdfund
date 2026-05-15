@extends('fundraiser.layout')

@section('title', $post->title)

@push('styles')
    <style>
        .supporter-table-anchor {
            scroll-margin-top: 110px;
        }

        .post-stat-progress {
            height: 8px;
            margin-bottom: 18px;
            border-radius: 999px;
            overflow: hidden;
            background: #eadbd8;
        }

        .post-stat-progress__fill {
            display: block;
            width: var(--progress-width, 0%);
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: inherit;
            background: linear-gradient(90deg, #a83220 0%, #8f2619 100%);
            box-shadow: 0 0 14px rgba(255, 31, 31, 0.75);
        }

        .post-stat-progress__fill::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 38, 38, 0.95) 48%, transparent 100%);
            transform: translateX(-100%);
            animation: postStatProgressGlow 1.8s ease-in-out infinite;
        }

        @keyframes postStatProgressGlow {
            to {
                transform: translateX(100%);
            }
        }
    </style>
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-4">
        <div>
            <p class="muted mb-1">Fundraiser ID #{{ $post->id }}</p>
            <h1 class="fw-black mb-2">{{ $post->title }}</h1>
            <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-soft" href="{{ route('fundraiser.posts.index') }}">Back to My Posts</a>
            @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                <a class="btn btn-gold" href="{{ route('fundraiser.posts.updates.index', $post) }}">Manage Post</a>
            @endif
            @if ($post->status === \App\Models\FundraiserPost::STATUS_PENDING)
                <a class="btn btn-gold" href="{{ route('fundraiser.posts.edit', $post) }}">Edit Pending Post</a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <section class="dashboard-panel overflow-hidden mb-4">
                <img class="w-100" style="height: 390px; object-fit: cover;" src="{{ $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png') }}" alt="{{ $post->title }}">
                <div class="p-3 p-md-4">
                    <h4 class="fw-black">Full Fundraiser Details</h4>
                    <p class="muted">{{ $post->short_description }}</p>
                    <p>{!! nl2br(e($post->full_description)) !!}</p>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6"><strong>Category/Cause:</strong><br>{{ $post->category }}</div>
                        <div class="col-md-6"><strong>Location:</strong><br>{{ $post->location }}</div>
                        <div class="col-md-6"><strong>Beneficiary:</strong><br>{{ $post->beneficiary_name }}</div>
                        <div class="col-md-6"><strong>Beneficiary Phone:</strong><br>{{ $post->beneficiary_phone }}</div>
                        <div class="col-md-6"><strong>Created Date:</strong><br>{{ $post->created_at->format('d M Y, h:i A') }}</div>
                        <div class="col-md-6"><strong>Approval Status:</strong><br><span class="status-badge {{ $post->status }}">{{ $post->status }}</span></div>
                    </div>
                </div>
            </section>

            <section class="dashboard-panel p-3 p-md-4 mb-4 supporter-table-anchor" id="supporter-table">
                <h4 class="fw-black mb-3">Donation History</h4>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Donor</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($donations as $donation)
                                <tr>
                                    <td>
                                        <strong>{{ $donation->donor_name }}</strong><br>
                                        <span class="small muted">{{ $donation->donor_email ?: 'No email' }}</span>
                                    </td>
                                    <td>Rs. {{ number_format((float) $donation->amount, 0) }}</td>
                                    <td>{{ $donation->payment_method ?: 'Not specified' }}</td>
                                    <td>{{ optional($donation->paid_at ?? $donation->created_at)->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center muted py-4">No donations received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($donations->hasPages())
                    {{ $donations->links() }}
                @endif
            </section>
        </div>

        <div class="col-lg-4">
            <section class="dashboard-panel p-3 p-md-4 mb-4">
                <h4 class="fw-black mb-3">Raised Amount Statistics</h4>
                <div class="post-stat-progress" aria-hidden="true">
                    <span class="post-stat-progress__fill" style="--progress-width: {{ $stats['progress'] }}%"></span>
                </div>
                <div class="row g-3">
                    <div class="col-6"><span class="muted">Progress</span><h5 class="fw-black">{{ $stats['progress'] }}%</h5></div>
                    <div class="col-6"><span class="muted">Donors</span><h5 class="fw-black">{{ number_format($stats['donors']) }}</h5></div>
                    <div class="col-6"><span class="muted">Raised</span><h5 class="fw-black">Rs. {{ number_format($stats['raised'], 0) }}</h5></div>
                    <div class="col-6"><span class="muted">Goal</span><h5 class="fw-black">Rs. {{ number_format($stats['goal'], 0) }}</h5></div>
                    <div class="col-12"><span class="muted">Remaining Amount</span><h5 class="fw-black">Rs. {{ number_format($stats['remaining'], 0) }}</h5></div>
                </div>
                @if ($post->status === \App\Models\FundraiserPost::STATUS_APPROVED)
                    <a class="btn btn-gold w-100 mt-3" href="#supporter-table">View Supporters</a>
                @endif
            </section>

            <section class="dashboard-panel p-3 p-md-4 mb-4">
                <h4 class="fw-black mb-3">Uploaded Documents/Images</h4>
                <div class="d-grid gap-2">
                    @if ($post->main_image)
                        <a class="btn btn-soft" href="{{ asset('storage/' . $post->main_image) }}" target="_blank" rel="noopener">View Main Image</a>
                    @endif
                    @if ($post->supporting_file)
                        <a class="btn btn-soft" href="{{ asset('storage/' . $post->supporting_file) }}" target="_blank" rel="noopener">View Supporting File</a>
                    @else
                        <p class="muted mb-0">No supporting document uploaded.</p>
                    @endif
                </div>
            </section>

            @if ($post->status === \App\Models\FundraiserPost::STATUS_REJECTED)
                <section class="dashboard-panel p-3 p-md-4">
                    <h4 class="fw-black mb-3">Admin Remarks</h4>
                    <p class="mb-0">{{ $post->admin_remarks ?: 'No admin remarks provided.' }}</p>
                </section>
            @endif
        </div>
    </div>
@endsection
