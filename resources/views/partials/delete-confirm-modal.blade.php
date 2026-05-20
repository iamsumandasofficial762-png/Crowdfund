@include('partials.auto-alerts')

<style>
    .delete-confirm-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: grid;
        place-items: center;
        padding: 18px;
        background: rgba(7, 18, 38, 0.44);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .delete-confirm-modal.is-open {
        opacity: 1;
        visibility: visible;
    }

    .delete-confirm-card {
        width: min(100%, 430px);
        border: 1px solid rgba(180, 35, 24, 0.28);
        border-radius: 18px;
        padding: 24px;
        color: #071226;
        background: #ffffff;
        box-shadow: 0 24px 70px rgba(7, 18, 38, 0.24);
        transform: translateY(12px) scale(0.98);
        transition: transform 0.2s ease;
    }

    .delete-confirm-modal.is-open .delete-confirm-card {
        transform: translateY(0) scale(1);
    }

    .delete-confirm-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        color: #b42318;
        background: #ffe1e1;
        font-size: 22px;
        margin-bottom: 16px;
    }

    .delete-confirm-card h3 {
        margin: 0 0 8px;
        color: #071226;
        font-size: 24px;
        font-weight: 900;
    }

    .delete-confirm-card p {
        margin: 0;
        color: #647083;
        line-height: 1.55;
    }

    .delete-confirm-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .delete-confirm-actions button {
        min-height: 42px;
        border-radius: 12px;
        padding: 9px 16px;
        font: inherit;
        font-weight: 900;
    }

    .delete-confirm-cancel {
        border: 1px solid #dde2ea;
        color: #071226;
        background: #ffffff;
    }

    .delete-confirm-submit {
        border: 1px solid #b42318;
        color: #ffffff;
        background: #b42318;
    }

    .delete-confirm-submit:hover,
    .delete-confirm-submit:focus {
        background: #8f1d14;
    }
</style>

<div class="delete-confirm-modal" data-delete-modal aria-hidden="true">
    <section class="delete-confirm-card" role="dialog" aria-modal="true" aria-labelledby="global-delete-confirm-title" aria-describedby="global-delete-confirm-copy">
        <span class="delete-confirm-icon" aria-hidden="true"><i class="fa-solid fa-triangle-exclamation"></i></span>
        <h3 id="global-delete-confirm-title">Are you sure?</h3>
        <p id="global-delete-confirm-copy">This action cannot be undone.</p>
        <div class="delete-confirm-actions">
            <button class="delete-confirm-cancel" type="button" data-delete-cancel>Cancel</button>
            <button class="delete-confirm-submit" type="button" data-delete-confirm-button>Confirm Delete</button>
        </div>
    </section>
</div>

<script>
    (() => {
        if (window.__karnaDeleteConfirmReady) {
            return;
        }

        window.__karnaDeleteConfirmReady = true;

        const ready = (callback) => {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', callback, { once: true });
                return;
            }

            callback();
        };

        ready(() => {
            const modal = document.querySelector('[data-delete-modal]');
            const cancelButton = document.querySelector('[data-delete-cancel]');
            const confirmButton = document.querySelector('[data-delete-confirm-button]');
            const title = document.getElementById('global-delete-confirm-title');
            const copy = document.getElementById('global-delete-confirm-copy');
            const defaultTitle = title?.textContent || 'Are you sure?';
            const defaultCopy = copy?.textContent || 'This action cannot be undone.';
            const defaultButton = confirmButton?.textContent || 'Confirm Delete';
            let pendingForm = null;

            if (!modal || !cancelButton || !confirmButton || !title || !copy) {
                return;
            }

            const openModal = (form) => {
                pendingForm = form;
                title.textContent = form.dataset.confirmTitle || defaultTitle;
                copy.textContent = form.dataset.confirmMessage || defaultCopy;
                confirmButton.textContent = form.dataset.confirmButton || defaultButton;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                confirmButton.focus();
            };

            const closeModal = () => {
                pendingForm = null;
                title.textContent = defaultTitle;
                copy.textContent = defaultCopy;
                confirmButton.textContent = defaultButton;
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            };

            document.addEventListener('submit', (event) => {
                const form = event.target.closest('form[data-delete-confirm], form.delete-confirm-form');

                if (!form || form.dataset.deleteConfirmed === 'true') {
                    return;
                }

                event.preventDefault();
                openModal(form);
            });

            document.addEventListener('click', (event) => {
                const trigger = event.target.closest('.delete-confirm-btn[data-delete-form]');

                if (!trigger) {
                    return;
                }

                event.preventDefault();
                const form = document.getElementById(trigger.dataset.deleteForm);

                if (form) {
                    openModal(form);
                }
            });

            cancelButton.addEventListener('click', closeModal);

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                    closeModal();
                }
            });

            confirmButton.addEventListener('click', () => {
                if (!pendingForm) {
                    return;
                }

                pendingForm.dataset.deleteConfirmed = 'true';
                pendingForm.submit();
            });
        });
    })();
</script>
