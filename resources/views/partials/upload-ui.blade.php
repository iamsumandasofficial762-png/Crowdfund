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
            const uploadState = new WeakMap();

            function cloneFileList(files) {
                const fileArray = Array.from(files || []);

                if (!fileArray.length || typeof DataTransfer === 'undefined') {
                    return null;
                }

                const transfer = new DataTransfer();
                fileArray.forEach((file) => transfer.items.add(file));

                return transfer.files;
            }

            function filesLabel(files) {
                const fileArray = Array.from(files || []);

                if (fileArray.length === 0) {
                    return 'No file chosen';
                }

                return fileArray.length === 1 ? fileArray[0].name : `${fileArray.length} files selected`;
            }

            function findPreview(input) {
                if (!input.dataset.imageInput) {
                    return null;
                }

                return document.querySelector(`[data-image-preview="${input.dataset.imageInput}"]`);
            }

            function initialState(input) {
                if (uploadState.has(input)) {
                    return uploadState.get(input);
                }

                const box = input.closest('.upload-box');
                const label = box ? box.querySelector('[data-file-label]') : null;
                const clearButton = box ? box.querySelector('[data-clear-file]') : null;
                const preview = findPreview(input);
                const state = {
                    box,
                    label,
                    clearButton,
                    preview,
                    files: cloneFileList(input.files),
                    initialLabel: label?.textContent || 'No file chosen',
                    initialPreviewSrc: preview?.getAttribute('src') || '',
                    initialPreviewHidden: preview?.classList.contains('d-none') ?? true,
                };

                uploadState.set(input, state);

                return state;
            }

            function renderSelected(input, files) {
                const state = initialState(input);
                const hasFiles = files && files.length > 0;

                if (state.label) {
                    state.label.textContent = hasFiles ? filesLabel(files) : state.initialLabel;
                }

                if (state.box) {
                    state.box.classList.toggle('has-selected-file', hasFiles);
                }

                if (state.clearButton) {
                    state.clearButton.classList.toggle('d-none', !hasFiles);
                }

                if (state.preview && hasFiles && files[0]?.type?.startsWith('image/')) {
                    state.preview.src = URL.createObjectURL(files[0]);
                    state.preview.classList.remove('d-none');
                }
            }

            function resetSelected(input) {
                const state = initialState(input);

                if (state.label) {
                    state.label.textContent = state.initialLabel;
                }

                if (state.box) {
                    state.box.classList.remove('has-selected-file');
                }

                if (state.clearButton) {
                    state.clearButton.classList.add('d-none');
                }

                if (state.preview) {
                    if (state.initialPreviewSrc) {
                        state.preview.src = state.initialPreviewSrc;
                    } else {
                        state.preview.removeAttribute('src');
                    }

                    state.preview.classList.toggle('d-none', state.initialPreviewHidden);
                }
            }

            function handleFileChange(input) {
                const state = initialState(input);
                const files = input.files;

                if (files && files.length > 0) {
                    state.files = cloneFileList(files);
                    renderSelected(input, files);
                    return;
                }

                if (input.dataset.uploadClearing === 'true') {
                    state.files = null;
                    resetSelected(input);
                    return;
                }

                if (state.files && state.files.length) {
                    const restoredFiles = cloneFileList(state.files);

                    if (restoredFiles) {
                        input.files = restoredFiles;
                    }

                    renderSelected(input, restoredFiles || state.files);
                }
            }

            function clearFile(input) {
                const state = initialState(input);

                input.dataset.uploadClearing = 'true';
                state.files = null;
                input.value = '';
                resetSelected(input);
                input.dispatchEvent(new CustomEvent('upload:clear', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
                delete input.dataset.uploadClearing;
            }

            function initUploads(root = document) {
                root.querySelectorAll('.upload-box input[type="file"], input[type="file"][data-image-input]').forEach((input) => {
                    initialState(input);
                    renderSelected(input, input.files);
                    input.addEventListener('change', () => handleFileChange(input));
                });

                root.querySelectorAll('.upload-box [data-clear-file]').forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();

                        const input = document.getElementById(button.dataset.clearFile);

                        if (input) {
                            clearFile(input);
                        }
                    });
                });
            }

            window.KarnaUploadKeeper = {
                init: initUploads,
                clear: clearFile,
                refresh: handleFileChange,
            };

            initUploads();
        });
    </script>
@endonce
