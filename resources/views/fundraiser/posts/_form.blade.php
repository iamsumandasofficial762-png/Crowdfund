@php
    $isEdit = (bool) $post;
@endphp

<form action="{{ $isEdit ? route('fundraiser.posts.update', $post) : route('fundraiser.posts.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-12">
            <label class="form-label fw-bold" for="title">Fundraiser Title</label>
            <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $post?->title) }}" required>
        </div>
        <div class="col-12">
            <label class="form-label fw-bold" for="short_description">Short Description</label>
            <input class="form-control" id="short_description" type="text" name="short_description" value="{{ old('short_description', $post?->short_description) }}" required>
        </div>
        <div class="col-12">
            <label class="form-label fw-bold" for="full_description">Full Description</label>
            <textarea class="form-control" id="full_description" name="full_description" rows="7" required>{{ old('full_description', $post?->full_description) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="goal_amount">Goal Amount</label>
            <input class="form-control" id="goal_amount" type="number" name="goal_amount" value="{{ old('goal_amount', $post?->goal_amount) }}" min="1" step="0.01" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="category">Category/Cause</label>
            <input class="form-control" id="category" type="text" name="category" value="{{ old('category', $post?->category ?? $fundraiser->cause) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="beneficiary_name">Beneficiary Name</label>
            <input class="form-control" id="beneficiary_name" type="text" name="beneficiary_name" value="{{ old('beneficiary_name', $post?->beneficiary_name) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="beneficiary_phone">Beneficiary Phone</label>
            <input class="form-control" id="beneficiary_phone" type="tel" name="beneficiary_phone" value="{{ old('beneficiary_phone', $post?->beneficiary_phone) }}" required>
        </div>
        <div class="col-12">
            <label class="form-label fw-bold" for="location">Location</label>
            <input class="form-control" id="location" type="text" name="location" value="{{ old('location', $post?->location) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="main_image">Main Image Upload</label>
            <div class="file-input-row">
                <input class="form-control" id="main_image" type="file" name="main_image" accept=".jpg,.jpeg,.png,.webp" data-retain-file @required(! $isEdit)>
                <button class="btn btn-soft file-clear-button d-none" type="button" data-clear-file="main_image">Remove</button>
            </div>
            @if ($isEdit && $post->main_image)
                <p class="small muted mt-2 mb-0">Current: {{ basename($post->main_image) }}</p>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label fw-bold" for="supporting_file">Supporting Document Upload</label>
            <div class="file-input-row">
                <input class="form-control" id="supporting_file" type="file" name="supporting_file" accept=".pdf,.jpg,.jpeg,.png,.webp" data-retain-file>
                <button class="btn btn-soft file-clear-button d-none" type="button" data-clear-file="supporting_file">Remove</button>
            </div>
            @if ($isEdit && $post->supporting_file)
                <p class="small muted mt-2 mb-0">Current: {{ basename($post->supporting_file) }}</p>
            @endif
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap mt-4">
        <button class="btn btn-gold px-4" type="submit">{{ $isEdit ? 'Update Post' : 'Submit Post' }}</button>
        <a class="btn btn-soft" href="{{ route('fundraiser.posts.index') }}">Cancel</a>
    </div>
</form>
