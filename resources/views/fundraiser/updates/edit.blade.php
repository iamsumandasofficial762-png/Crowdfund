@extends('fundraiser.layout')

@section('title', 'Edit Story Update')

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-4">
        <div>
            <p class="muted mb-1">Story Updates</p>
            <h1 class="fw-black mb-2">Edit update</h1>
            <p class="muted mb-0">{{ $post->title }}</p>
        </div>
        <a class="btn btn-soft" href="{{ route('fundraiser.posts.updates.index', $post) }}">Back to Updates</a>
    </div>

    <section class="dashboard-panel p-3 p-md-4">
        <form action="{{ route('fundraiser.posts.updates.update', [$post, $update]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold" for="title">Update Title</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $update->title) }}" maxlength="255">
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-between gap-3 flex-wrap">
                        <label class="form-label fw-bold" for="update_text">Update Description</label>
                        <span class="small muted"><span data-character-count>0</span>/10000</span>
                    </div>
                    <textarea class="form-control" id="update_text" name="update_text" rows="9" maxlength="10000" required data-character-source>{{ old('update_text', $update->update_text) }}</textarea>
                </div>
                <div class="col-lg-7">
                    <label class="form-label fw-bold" for="update_image">Replace Image (optional)</label>
                    <label class="upload-box" for="update_image">
                        <input id="update_image" type="file" name="update_image" accept=".jpg,.jpeg,.png,.webp" data-image-preview-source data-retain-file>
                        <span class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                        <span class="upload-title">Upload image</span>
                        <span class="upload-help">JPG, PNG, JPEG, or WEBP up to 5 MB</span>
                        <span class="upload-selected" data-file-label>No file chosen</span>
                        <button class="upload-clear d-none" type="button" data-clear-file="update_image">Remove</button>
                    </label>
                    <p class="small muted mb-0 mt-2">Leave empty to keep the current image.</p>
                    <div class="form-check mt-3">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" id="is_published" type="checkbox" name="is_published" value="1" @checked(old('is_published', $update->is_published))>
                        <label class="form-check-label fw-bold" for="is_published">Published</label>
                    </div>
                    <div class="form-check mt-2">
                        <input type="hidden" name="is_pinned" value="0">
                        <input class="form-check-input" id="is_pinned" type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $update->is_pinned))>
                        <label class="form-check-label fw-bold" for="is_pinned">Pin this update</label>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="update-image-preview {{ $update->update_image ? 'has-image' : '' }}" data-image-preview role="button" tabindex="0" aria-label="Open uploaded image preview">
                        @if ($update->update_image)
                            <img src="{{ asset('storage/' . $update->update_image) }}" alt="{{ $update->title ?: 'Current update image' }}">
                        @else
                            <i class="fa-regular fa-image"></i>
                            <span>Image preview</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-4">
                <button class="btn btn-gold" type="submit"><i class="fa-solid fa-floppy-disk"></i>Save Update</button>
                <a class="btn btn-soft" href="{{ route('fundraiser.posts.updates.index', $post) }}">Cancel</a>
            </div>
        </form>
    </section>

    <div class="image-preview-modal" data-image-preview-modal aria-hidden="true">
        <div class="image-preview-modal__dialog" role="dialog" aria-modal="true" aria-label="Uploaded image preview">
            <button class="image-preview-modal__close" type="button" data-image-preview-close aria-label="Close image preview">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img class="image-preview-modal__image" src="" alt="Uploaded image full preview" data-image-preview-full>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const text = document.querySelector('[data-character-source]');
            const count = document.querySelector('[data-character-count]');
            const file = document.querySelector('[data-image-preview-source]');
            const preview = document.querySelector('[data-image-preview]');
            const modal = document.querySelector('[data-image-preview-modal]');
            const modalImage = document.querySelector('[data-image-preview-full]');
            const modalClose = document.querySelector('[data-image-preview-close]');
            const fallbackPreviewHtml = preview?.innerHTML ?? '';
            const fallbackHasImage = preview?.classList.contains('has-image') ?? false;

            const refreshCount = () => {
                if (text && count) {
                    count.textContent = text.value.length;
                }
            };

            const openPreviewModal = () => {
                const image = preview?.querySelector('img');

                if (!modal || !modalImage || !image?.src) {
                    return;
                }

                modalImage.src = image.src;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                modalClose?.focus();
            };

            const closePreviewModal = () => {
                if (!modal || !modalImage) {
                    return;
                }

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                modalImage.src = '';
            };

            text?.addEventListener('input', refreshCount);
            refreshCount();

            file?.addEventListener('change', () => {
                const selectedFile = file.files?.[0];

                if (!preview) {
                    return;
                }

                if (!selectedFile && file.dataset.uploadClearing === 'true') {
                    preview.innerHTML = fallbackPreviewHtml;
                    preview.classList.toggle('has-image', fallbackHasImage);
                    return;
                }

                if (!selectedFile) {
                    return;
                }

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    preview.innerHTML = `<img src="${reader.result}" alt="Selected update image preview">`;
                    preview.classList.add('has-image');
                });
                reader.readAsDataURL(selectedFile);
            });

            preview?.addEventListener('click', openPreviewModal);
            preview?.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openPreviewModal();
                }
            });

            modalClose?.addEventListener('click', closePreviewModal);
            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closePreviewModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
                    closePreviewModal();
                }
            });
        })();
    </script>
@endpush
