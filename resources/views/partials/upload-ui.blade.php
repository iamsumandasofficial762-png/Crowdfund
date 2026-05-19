@once
    <style>
        .upload-box {
            position: relative;
            display: grid;
            place-items: center;
            width: 100%;
            min-height: 112px;
            border: 1.5px dashed #b21f17;
            border-radius: 10px;
            padding: 14px 16px;
            background: #fff8ec;
            color: #071226;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .upload-box:hover,
        .upload-box:focus-within {
            border-color: #932a19;
            background: #fff2df;
            box-shadow: 0 12px 24px rgba(147, 42, 25, 0.12);
            transform: translateY(-1px);
        }

        .upload-box input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            width: 26px;
            height: 26px;
            display: inline-grid;
            place-items: center;
            margin-bottom: 6px;
            border-radius: 50%;
            color: #ffffff;
            background: #b21f17;
            font-size: 13px;
            line-height: 1;
        }

        .upload-title {
            display: block;
            margin-bottom: 2px;
            color: #071226;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.2;
        }

        .upload-help,
        .upload-selected {
            display: block;
            color: #647083;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.25;
        }

        .upload-selected {
            width: 100%;
            margin-top: 4px;
            color: #9a4f00;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .upload-clear {
            position: absolute;
            right: 12px;
            bottom: 10px;
            z-index: 2;
            border: 0;
            border-radius: 999px;
            padding: 4px 12px;
            color: #8a5400;
            background: #ffffff;
            font-size: 11px;
            font-weight: 900;
            box-shadow: 0 6px 14px rgba(147, 42, 25, 0.18);
        }

        .upload-clear:hover,
        .upload-clear:focus {
            color: #000000;
            background: #ffe6b7;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function updateUploadBox(input) {
                const box = input.closest('.upload-box');

                if (!box) {
                    return;
                }

                const label = box.querySelector('[data-file-label]');
                const clearButton = box.querySelector('[data-clear-file]');
                const files = Array.from(input.files || []);

                if (label) {
                    label.textContent = files.length === 0
                        ? 'No file chosen'
                        : files.length === 1
                            ? files[0].name
                            : `${files.length} files selected`;
                }

                box.classList.toggle('has-selected-file', files.length > 0);

                if (clearButton) {
                    clearButton.classList.toggle('d-none', files.length === 0);
                }
            }

            document.querySelectorAll('.upload-box input[type="file"]').forEach((input) => {
                updateUploadBox(input);

                input.addEventListener('change', () => updateUploadBox(input));
            });

            document.querySelectorAll('.upload-box [data-clear-file]').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const input = document.getElementById(button.dataset.clearFile);

                    if (!input) {
                        return;
                    }

                    input.value = '';
                    updateUploadBox(input);
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });
        });
    </script>
@endonce
