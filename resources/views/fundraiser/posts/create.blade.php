@extends('fundraiser.layout')

@section('title', 'Create Fundraiser Post')

@section('content')
    <section class="dashboard-panel p-3 p-md-5">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-4">
            <div>
                <p class="muted mb-1">Logged in as {{ $fundraiser->name }}</p>
                <h1 class="fw-black mb-2">Create Fundraiser Post</h1>
                <p class="muted mb-0">Submit a new campaign. It will stay pending until admin approval.</p>
            </div>
            <a class="btn btn-soft" href="{{ route('fundraiser.posts.index') }}">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
        </div>

        @include('fundraiser.posts._form', ['post' => null])
    </section>
@endsection
