<x-layouts.app :title="'Home'">
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-lg" style="background: rgba(34,197,94,0.10); border: 1px solid rgba(34,197,94,0.18);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-4 h-4"
                    style="color: var(--fg-green);"
                    aria-hidden="true"
                >
                    <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z" />
                    <path d="M20 2v4" />
                    <path d="M22 4h-4" />
                    <circle cx="4" cy="20" r="2" />
                </svg>
            </span>
            <span class="text-xs uppercase tracking-widest" style="color: var(--fg-green); font-weight: 600;">
                AI-Powered Analysis
            </span>
        </div>
        <h1 class="text-slate-800" style="font-size: 1.75rem; font-weight: 700; line-height: 1.2;">Waste Classification</h1>
        <p class="text-slate-500 mt-1 text-sm max-w-2xl">
            Upload gambar, sistem akan mengirimnya ke Flask AI API untuk mengklasifikasikan sampah sebagai <span class="font-medium text-slate-700">Organic</span> atau <span class="font-medium text-slate-700">Recyclable</span>.
        </p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="fg-card rounded-2xl p-6 h-full">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #0F172A, #1E293B);">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-4 h-4"
                        aria-hidden="true"
                    >
                        <path d="M12 3v12" />
                        <path d="m17 8-5-5-5 5" />
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-slate-800" style="font-size: 1rem; font-weight: 600;">Upload Image</h2>
                    <p class="text-slate-400 text-xs">JPG, PNG, WebP supported · max 5MB</p>
                </div>
            </div>

            <form id="analyzeForm" class="space-y-4" action="{{ route('analyze') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input id="imageInput" name="image" type="file" accept="image/*" class="hidden" required>

                <div
                    id="dropZone"
                    class="relative rounded-xl border-2 border-dashed transition-all duration-300 p-8 flex flex-col items-center justify-center text-center cursor-pointer"
                    style="min-height: 180px; border-color: rgba(203,213,225,1); background: rgba(241,245,249,0.5);"
                >
                    <div id="dropEmpty" class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(15,23,42,0.06);">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-7 h-7 text-slate-400"
                                aria-hidden="true"
                            >
                                <path d="M12 3v12" />
                                <path d="m17 8-5-5-5 5" />
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm" style="font-weight: 500;">Drag & drop your image here</p>
                            <p class="text-slate-400 text-xs mt-1">or click to browse files</p>
                        </div>
                    </div>

                    <div id="dropFilled" class="hidden flex-col items-center gap-3">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(59,130,246,0.10);">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-7 h-7"
                                style="color: var(--fg-blue);"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <p id="fileName" class="text-slate-700 text-sm" style="font-weight: 500;"></p>
                            <p id="fileMeta" class="text-slate-400 text-xs mt-0.5"></p>
                        </div>
                    </div>

                    @error('image')
                        <div class="absolute inset-x-6 bottom-4 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full px-5 py-3 rounded-xl text-sm flex items-center justify-center gap-2"
                    style="background: linear-gradient(135deg, #0F172A, #1E40AF); color: #fff; font-weight: 600; box-shadow: 0 4px 16px rgba(15,23,42,0.25);"
                >
                    Analyze Image
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-4 h-4"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </button>

                <div class="text-xs text-slate-400">
                    Output: <span class="text-slate-600" style="font-weight: 600;">prediction</span>, <span class="text-slate-600" style="font-weight: 600;">confidence</span>, dan <span class="text-slate-600" style="font-weight: 600;">explanation</span>.
                </div>
            </form>
        </div>

        <div class="fg-card rounded-2xl p-6 h-full">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(15,23,42,0.06);">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-4 h-4 text-slate-700"
                        aria-hidden="true"
                    >
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-slate-800" style="font-size: 1rem; font-weight: 600;">Preview</h2>
                    <p class="text-slate-400 text-xs">Pastikan gambar sudah benar sebelum dianalisis</p>
                </div>
            </div>

            <div class="rounded-2xl overflow-hidden" style="background: rgba(241,245,249,0.4); border: 1px solid rgba(15,23,42,0.06);">
                <img id="previewImg" src="" alt="Preview" class="hidden w-full object-cover" style="max-height: 320px;" />
                <div id="previewPlaceholder" class="h-72 flex items-center justify-center text-sm text-slate-400">
                    Belum ada gambar.
                </div>
            </div>

            <div class="mt-5 rounded-2xl p-5" style="background: #fff; border: 1px solid rgba(15,23,42,0.06); box-shadow: 0 2px 12px rgba(15,23,42,0.06);">
                <div class="text-sm text-slate-700" style="font-weight: 600;">Image Analysis (ringkas)</div>
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="rounded-xl p-3" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.18);">
                        <div class="text-xs text-slate-400">Step 1</div>
                        <div class="text-slate-700" style="font-weight: 600;">Resize 150×150</div>
                    </div>
                    <div class="rounded-xl p-3" style="background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.18);">
                        <div class="text-xs text-slate-400">Step 2</div>
                        <div class="text-slate-700" style="font-weight: 600;">Normalize [0,1]</div>
                    </div>
                    <div class="rounded-xl p-3" style="background: rgba(139,92,246,0.08); border: 1px solid rgba(139,92,246,0.18);">
                        <div class="text-xs text-slate-400">Step 3</div>
                        <div class="text-slate-700" style="font-weight: 600;">Feature Extract (CNN)</div>
                    </div>
                    <div class="rounded-xl p-3" style="background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.18);">
                        <div class="text-xs text-slate-400">Step 4</div>
                        <div class="text-slate-700" style="font-weight: 600;">Classify (Sigmoid)</div>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-400">
                    Sistem menganalisis fitur visual seperti <span class="text-slate-600" style="font-weight: 600;">tekstur</span>, <span class="text-slate-600" style="font-weight: 600;">warna</span>, dan <span class="text-slate-600" style="font-weight: 600;">bentuk</span>.
                </div>
            </div>
        </div>
    </div>

    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black/40">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="rounded-3xl bg-white px-6 py-5 shadow-sm border border-black/5 w-[340px] text-center">
                <div class="text-lg font-semibold">Analyzing...</div>
                <div class="mt-1 text-sm text-gray-600">Mohon tunggu, sistem sedang memproses gambar.</div>
                <div class="mt-4 h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-1/2 bg-gray-900 animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('imageInput');
        const previewImg = document.getElementById('previewImg');
        const placeholder = document.getElementById('previewPlaceholder');
        const overlay = document.getElementById('loadingOverlay');
        const form = document.getElementById('analyzeForm');

        const dropZone = document.getElementById('dropZone');
        const dropEmpty = document.getElementById('dropEmpty');
        const dropFilled = document.getElementById('dropFilled');
        const fileName = document.getElementById('fileName');
        const fileMeta = document.getElementById('fileMeta');

        const setDropState = (file) => {
            if (!file) {
                dropFilled?.classList.add('hidden');
                dropFilled?.classList.remove('flex');
                dropEmpty?.classList.remove('hidden');
                if (fileName) fileName.textContent = '';
                if (fileMeta) fileMeta.textContent = '';
                return;
            }
            dropEmpty?.classList.add('hidden');
            dropFilled?.classList.remove('hidden');
            dropFilled?.classList.add('flex');
            if (fileName) fileName.textContent = file.name;
            if (fileMeta) fileMeta.textContent = `${(file.size / 1024).toFixed(1)} KB · Click to change`;
        };

        const setPreview = (file) => {
            if (!file) {
                previewImg.classList.add('hidden');
                placeholder.classList.remove('hidden');
                previewImg.src = '';
                return;
            }
            const url = URL.createObjectURL(file);
            previewImg.src = url;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        dropZone?.addEventListener('click', () => input?.click());

        dropZone?.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--fg-green)';
            dropZone.style.background = 'rgba(34,197,94,0.04)';
        });

        dropZone?.addEventListener('dragleave', () => {
            const hasFile = !!input?.files?.[0];
            dropZone.style.borderColor = hasFile ? 'var(--fg-blue)' : 'rgba(203,213,225,1)';
            dropZone.style.background = hasFile ? 'rgba(59,130,246,0.04)' : 'rgba(241,245,249,0.5)';
        });

        dropZone?.addEventListener('drop', (e) => {
            e.preventDefault();
            const file = e.dataTransfer?.files?.[0];
            if (!file) return;
            if (!file.type?.startsWith('image/')) return;

            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            setDropState(file);
            setPreview(file);

            dropZone.style.borderColor = 'var(--fg-blue)';
            dropZone.style.background = 'rgba(59,130,246,0.04)';
        });

        input?.addEventListener('change', () => {
            const file = input.files?.[0];
            setDropState(file);
            setPreview(file);
            dropZone.style.borderColor = file ? 'var(--fg-blue)' : 'rgba(203,213,225,1)';
            dropZone.style.background = file ? 'rgba(59,130,246,0.04)' : 'rgba(241,245,249,0.5)';
        });

        form?.addEventListener('submit', () => {
            overlay.classList.remove('hidden');
        });

        setDropState(null);
    </script>
</x-layouts.app>
