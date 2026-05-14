@extends('fundraiser.layout')

@section('title', 'Manage Story Updates')

@section('content')
    @php
        $supporters = (int) ($post->paid_donations_count ?? 0);
        $shareUrl = route('donate-us', $post);
    @endphp

    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-4">
        <div>
            <p class="muted mb-1">Story Updates</p>
            <h1 class="fw-black mb-2">Manage updates</h1>
            <p class="muted mb-0">Keep supporters informed with concise, timely campaign updates.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a class="btn btn-soft" href="{{ route('fundraiser.updates.campaigns') }}">All Update Campaigns</a>
            <a class="btn btn-soft" href="{{ route('fundraiser.posts.show', $post) }}">Campaign Details</a>
        </div>
    </div>

    <section class="dashboard-panel overflow-hidden mb-4">
        <div class="update-hero">
            <img src="{{ $post->main_image ? asset('storage/' . $post->main_image) : asset('assets/images/cause/one.png') }}" alt="{{ $post->title }}">
            <div class="update-hero__body">
                <span class="status-badge {{ $post->status }}">{{ $post->status }}</span>
                <h2 class="fw-black mb-3">{{ $post->title }}</h2>
                <div class="update-hero__stats">
                    <span><strong>Rs. {{ number_format($raisedAmount, 0) }}</strong> raised</span>
                    <span><strong>{{ number_format($supporters) }}</strong> {{ $supporters === 1 ? 'supporter' : 'supporters' }}</span>
                    <span><strong>{{ number_format($updates->total()) }}</strong> updates</span>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-panel p-3 p-md-4 mb-4" id="add-update">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
            <div>
                <p class="muted mb-1">Add Story Update</p>
                <h3 class="fw-black mb-0">Publish a new campaign update</h3>
            </div>
        </div>

        <form action="{{ route('fundraiser.posts.updates.store', $post) }}" method="post" enctype="multipart/form-data" data-update-form>
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold" for="title">Update Title</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}" maxlength="255" placeholder="Example: Treatment progress update">
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-between gap-3 flex-wrap">
                        <label class="form-label fw-bold" for="update_text">Update Description</label>
                        <span class="small muted"><span data-character-count>0</span>/10000</span>
                    </div>
                    <textarea class="form-control" id="update_text" name="update_text" rows="8" maxlength="10000" placeholder="Write the latest progress, next steps, or a note to supporters..." required data-character-source>{{ old('update_text') }}</textarea>
                </div>
                <div class="col-lg-7">
                    <label class="form-label fw-bold" for="update_image">Upload Image (optional)</label>
                    <input class="form-control" id="update_image" type="file" name="update_image" accept=".jpg,.jpeg,.png,.webp" data-image-preview-source>
                    <p class="small muted mb-0 mt-2">JPG, PNG, JPEG, or WEBP up to 5 MB.</p>
                    <div class="form-check mt-3">
                        <input type="hidden" name="is_pinned" value="0">
                        <input class="form-check-input" id="is_pinned" type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned'))>
                        <label class="form-check-label fw-bold" for="is_pinned">Pin this update</label>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="update-image-preview" data-image-preview role="button" tabindex="0" aria-label="Open uploaded image preview">
                        <i class="fa-regular fa-image"></i>
                        <span>Image preview</span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-4">
                <button class="btn btn-gold" type="submit"><i class="fa-solid fa-paper-plane"></i>Publish Update</button>
                <a class="btn btn-soft" href="{{ route('fundraiser.updates.campaigns') }}">Cancel</a>
            </div>
        </form>
    </section>

    <section class="dashboard-panel p-3 p-md-4">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-4">
            <div>
                <p class="muted mb-1">Timeline</p>
                <h3 class="fw-black mb-0">Latest updates first</h3>
            </div>
        </div>

        <div class="update-timeline">
            @forelse ($updates as $update)
                <article class="update-card">
                    <div class="update-card__date">
                        <strong>{{ $update->created_at->format('d M Y') }}</strong>
                        <span>{{ $update->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="update-card__content">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-2">
                            <div>
                                @if ($update->title)
                                    <h4 class="fw-black mb-1">{{ $update->title }}</h4>
                                @else
                                    <h4 class="fw-black mb-1">Campaign update</h4>
                                @endif
                                <p class="small muted mb-0">
                                    Posted {{ $update->created_at->format('d M Y, h:i A') }}
                                    @if ($update->updated_at->gt($update->created_at->copy()->addMinute()))
                                        <span class="edited-badge">Edited</span>
                                    @endif
                                </p>
                            </div>
                            @unless ($update->is_published)
                                <span class="status-badge pending">Draft</span>
                            @endunless
                            @if ($update->is_pinned)
                                <span class="pinned-badge"><i class="fa-solid fa-thumbtack"></i>Pinned</span>
                            @endif
                        </div>
                        <p>{!! nl2br(e($update->update_text)) !!}</p>
                        @if ($update->update_image)
                            <img class="update-card__image" src="{{ asset('storage/' . $update->update_image) }}" alt="{{ $update->title ?: 'Story update image' }}">
                        @endif
                        <div class="update-card__actions">
                            <button class="btn btn-sm btn-soft" type="button" data-share-url="{{ $shareUrl }}"><i class="fa-solid fa-share-nodes"></i>Share</button>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('fundraiser.posts.updates.edit', [$post, $update]) }}">Edit</a>
                            <form class="post-action-form" action="{{ route('fundraiser.posts.updates.destroy', [$post, $update]) }}" method="post" data-delete-confirm>
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-5">
                    <h4 class="fw-black">No story updates yet.</h4>
                    <p class="muted mb-0">Your published updates will appear here immediately after posting.</p>
                </div>
            @endforelse
        </div>

        @if ($updates->hasPages())
            <div class="mt-4">
                {{ $updates->links() }}
            </div>
        @endif
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

                if (!preview || !selectedFile) {
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

            document.querySelectorAll('[data-share-url]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const url = button.dataset.shareUrl;

                    if (navigator.share) {
                        await navigator.share({ title: document.title, url });
                        return;
                    }

                    await navigator.clipboard.writeText(url);
                    button.textContent = 'Link copied';
                });
            });
        })();
    </script>
@endpush
