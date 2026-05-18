@once
    <style>
        .auto-alert,
        [data-auto-dismiss],
        .alert,
        .invalid-feedback {
            position: relative;
            transition: opacity .35s ease, transform .35s ease, visibility .35s ease, margin .35s ease, padding .35s ease, border-width .35s ease;
        }

        .auto-alert.is-hiding,
        [data-auto-dismiss].is-hiding,
        .alert.is-hiding,
        .invalid-feedback.is-hiding {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            border-width: 0 !important;
            overflow: hidden;
        }

        .auto-alert__close {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 8px;
            right: 10px;
            border: 0;
            border-radius: 999px;
            color: inherit;
            background: transparent;
            font-size: 18px;
            font-weight: 900;
            line-height: 1;
            opacity: .72;
            cursor: pointer;
        }

        .auto-alert__close:hover,
        .auto-alert__close:focus {
            opacity: 1;
            background: rgba(7, 18, 38, .08);
        }

        .auto-alert.has-auto-close,
        .alert.has-auto-close {
            padding-right: 46px;
        }
    </style>

    <script>
        (() => {
            if (window.__karnaAutoAlertsReady) {
                return;
            }

            window.__karnaAutoAlertsReady = true;

            const ready = (callback) => {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', callback, { once: true });
                    return;
                }

                callback();
            };

            ready(() => {
                const alerts = document.querySelectorAll('.auto-alert, [data-auto-dismiss], .alert, .invalid-feedback, .refer-alert, .resource-alert, .fundraiser-alert, .admin-login__status, .admin-login__errors');

                alerts.forEach((alert) => {
                    if (alert.dataset.autoAlertReady === 'true') {
                        return;
                    }

                    alert.dataset.autoAlertReady = 'true';

                    const hide = () => {
                        if (!alert.isConnected || alert.classList.contains('is-hiding')) {
                            return;
                        }

                        alert.classList.add('is-hiding');
                        window.setTimeout(() => alert.remove(), 400);
                    };

                    if (!alert.classList.contains('invalid-feedback') && !alert.querySelector('[data-auto-alert-close]')) {
                        const closeButton = document.createElement('button');
                        closeButton.type = 'button';
                        closeButton.className = 'auto-alert__close';
                        closeButton.setAttribute('aria-label', 'Close message');
                        closeButton.setAttribute('data-auto-alert-close', '');
                        closeButton.innerHTML = '&times;';
                        closeButton.addEventListener('click', hide);
                        alert.classList.add('has-auto-close');
                        alert.appendChild(closeButton);
                    }

                    const delay = Number(alert.dataset.autoDismiss) || Number(alert.dataset.autoAlertDelay) || 4000;
                    window.setTimeout(hide, Math.max(3000, Math.min(delay, 5000)));
                });
            });
        })();
    </script>
@endonce
