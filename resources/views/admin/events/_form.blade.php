@csrf
@php
    $hasEventImage = $event->exists && filled($event->event_image);
@endphp
@if ($errors->any())
    <div class="alert alert-danger"><strong>Please fix the highlighted fields.</strong></div>
@endif
<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel p-4">
            <div class="mb-3">
                <label class="form-label fw-bold" for="title">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title', $event->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="short_description">Short Description</label>
                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="4" maxlength="1000">{{ old('short_description', $event->short_description) }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label fw-bold" for="full_description">Full Description</label>
                <textarea class="form-control @error('full_description') is-invalid @enderror" id="full_description" name="full_description" rows="12">{{ old('full_description', $event->full_description) }}</textarea>
                @error('full_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel p-4 mb-4">
            <div class="mb-3">
                <label class="form-label fw-bold" for="status">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" @selected(old('status', $event->status ?: 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $event->status) === 'published')>Published</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="category">Category</label>
                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                    <option value="">Select category</option>
                    @foreach ($categories as $categorySlug => $categoryName)
                        <option value="{{ $categorySlug }}" @selected(old('category', $event->category) === $categorySlug)>{{ $categoryName }}</option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="event_date">Event Date</label>
                <input class="form-control @error('event_date') is-invalid @enderror" id="event_date" type="date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}">
                @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="event_time">Event Time</label>
                <input class="form-control @error('event_time') is-invalid @enderror" id="event_time" type="time" name="event_time" value="{{ old('event_time', $event->event_time?->format('H:i')) }}">
                @error('event_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label fw-bold" for="location">Location</label>
                <input class="form-control @error('location') is-invalid @enderror" id="location" type="text" name="location" value="{{ old('location', $event->location) }}">
                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="panel p-4 mb-4">
            <div class="mb-3">
                <label class="form-label fw-bold" for="organizer_name">Organizer Name</label>
                <input class="form-control @error('organizer_name') is-invalid @enderror" id="organizer_name" type="text" name="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}">
                @error('organizer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="contact_email">Contact Email</label>
                <input class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $event->contact_email) }}">
                @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label fw-bold" for="contact_phone">Contact Phone</label>
                <input class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $event->contact_phone) }}">
                @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="panel p-4">
            <label class="form-label fw-bold" for="event_image">Event Image</label>
            <label class="upload-box" for="event_image">
                <input class="@error('event_image') is-invalid @enderror" id="event_image" type="file" name="event_image" accept=".jpg,.jpeg,.png,.webp" data-image-input="event-image">
                <span class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span class="upload-title">Upload image</span>
                <span class="upload-help">JPG, PNG, JPEG, or WEBP up to 5 MB</span>
                <span class="upload-selected" data-file-label>No file chosen</span>
            </label>
            @error('event_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <img
                class="preview mt-3 {{ $hasEventImage ? '' : 'd-none' }}"
                src="{{ $hasEventImage ? $event->imageUrl() : '' }}"
                alt="{{ $event->title ?: 'Event image preview' }}"
                data-image-preview="event-image"
            >
        </div>
    </div>
</div>
<div class="mt-4 d-flex gap-2 flex-wrap">
    <button class="btn btn-warning fw-bold px-4" type="submit">{{ $buttonLabel }}</button>
    <a class="btn btn-soft" href="{{ route('admin.events.index') }}">Cancel</a>
</div>
