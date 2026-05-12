@extends('fundraiser.layout')

@section('title', 'Edit Fundraiser Post')

@section('content')
    <section class="dashboard-panel p-3 p-md-5">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-4">
            <div>
                <p class="muted mb-1">Only pending posts can be edited</p>
                <h1 class="fw-black mb-2">Edit Fundraiser Post</h1>
                <p class="muted mb-0">Update your campaign details before it is reviewed by admin.</p>
            </div>
            <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
        </div>

        @include('fundraiser.posts._form', ['post' => $post])
    </section>
@endsection
