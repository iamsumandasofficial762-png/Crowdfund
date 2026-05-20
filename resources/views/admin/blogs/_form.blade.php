@csrf
@php
    $hasFeaturedImage = $blog->exists && filled($blog->featured_image);
    $selectedCategoryId = old('blog_category_id', $blog->blog_category_id);

    if (! $selectedCategoryId && $blog->category) {
        $selectedCategoryId = $categories->firstWhere('slug', $blog->category)?->id;
    }
@endphp
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the highlighted fields.</strong>
    </div>
@endif
<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel p-4">
            <div class="mb-3">
                <label class="form-label fw-bold" for="title">Title</label>
                <input class="form-control @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title', $blog->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="short_description">Short Description</label>
                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="4" maxlength="1000">{{ old('short_description', $blog->short_description) }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label fw-bold" for="full_description">Full Description / Content</label>
                <textarea class="form-control @error('full_description') is-invalid @enderror" id="full_description" name="full_description" rows="14" required>{{ old('full_description', $blog->full_description) }}</textarea>
                @error('full_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel p-4 mb-4">
            <div class="mb-3">
                <label class="form-label fw-bold" for="status">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" @selected(old('status', $blog->status ?: 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $blog->status) === 'published')>Published</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="blog_category_id">Category</label>
                <select class="form-select @error('blog_category_id') is-invalid @enderror" id="blog_category_id" name="blog_category_id" required>
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $selectedCategoryId === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('blog_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="tags">Hashtags</label>
                <textarea class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" rows="3" placeholder="#donation, #childcare, #health">{{ old('tags', $blog->tagsForInput()) }}</textarea>
                <div class="form-text">Separate tags with commas or spaces. Example: #donation, #childcare, #health</div>
                @error('tags')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="form-label fw-bold" for="published_at">Published At</label>
                <input class="form-control @error('published_at') is-invalid @enderror" id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                <div class="form-text">Published blogs without a date use the current time.</div>
                @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="panel p-4">
            <label class="form-label fw-bold" for="featured_image">Featured Image</label>
            <label class="upload-box" for="featured_image">
                <input class="@error('featured_image') is-invalid @enderror" id="featured_image" type="file" name="featured_image" accept=".jpg,.jpeg,.png,.webp" data-image-input="blog-featured-image">
                <span class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span class="upload-title">Upload image</span>
                <span class="upload-help">JPG, PNG, JPEG, or WEBP up to 5 MB</span>
                <span class="upload-selected" data-file-label>No file chosen</span>
            </label>
            @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <img
                class="preview mt-3 {{ $hasFeaturedImage ? '' : 'd-none' }}"
                src="{{ $hasFeaturedImage ? $blog->imageUrl() : '' }}"
                alt="{{ $blog->title ?: 'Blog image preview' }}"
                data-image-preview="blog-featured-image"
            >
        </div>
    </div>
</div>
<div class="mt-4 d-flex gap-2 flex-wrap">
    <button class="btn btn-warning fw-bold px-4" type="submit">{{ $buttonLabel }}</button>
    <a class="btn btn-soft" href="{{ route('admin.blogs.index') }}">Cancel</a>
</div>
