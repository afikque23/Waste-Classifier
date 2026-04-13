<x-layouts.app :title="'Result'">
    @php
        $confidence = (float) $analysis->confidence;
        $confidencePct = round($confidence * 100, 2);

        $predText = (string) $analysis->prediction;
        $predLower = strtolower($predText);
        $isOrganic = str_contains($predLower, 'organic');
        $isRecyclable = str_contains($predLower, 'recyclable');

        $accentClass = 'accent-uncertain';
        $accentLabel = 'Uncertain';
        if ($isOrganic) {
            $accentClass = 'accent-organic';
            $accentLabel = 'Organic';
        } elseif ($isRecyclable) {
            $accentClass = 'accent-recyclable';
            $accentLabel = 'Recyclable';
        }

        $badgeClass = 'text-slate-700 border-slate-200';
        if ($confidence < 0.6) $badgeClass = 'text-red-700 border-red-200';
        elseif ($confidence < 0.8) $badgeClass = 'text-amber-700 border-amber-200';

        $analysisObj = is_array($analysis->analysis_json) ? $analysis->analysis_json : [];
        $method = $analysisObj['method'] ?? 'CNN-based Image Classification';
        $steps = $analysisObj['steps'] ?? [
            'Image resized to 150x150',
            'Normalized pixel values',
            'Feature extraction using convolution layers',
            'Classification using dense layer',
        ];
        $interpretation = $analysisObj['interpretation'] ?? 'The system analyzes visual features such as texture, color, and shape to classify the waste.';
    @endphp

    <div class="mb-8 flex items-start justify-between gap-4 {{ $accentClass }}">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-4 h-4"
                    style="color: var(--accent);"
                    aria-hidden="true"
                >
                    <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                    <path d="M18 17V9" />
                    <path d="M13 17V5" />
                    <path d="M8 17v-3" />
                </svg>
                <span class="text-xs uppercase tracking-widest" style="color: var(--accent); font-weight: 600;">Analysis Complete</span>
            </div>
            <h1 class="text-slate-800" style="font-size: 1.75rem; font-weight: 700;">Classification Result</h1>
            <p class="text-slate-500 text-sm mt-1">
                ID #{{ $analysis->id }} · {{ $analysis->created_at }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl text-sm flex items-center gap-2" style="background: rgba(255,255,255,0.9); border: 1px solid rgba(15,23,42,0.10); box-shadow: 0 2px 12px rgba(15,23,42,0.06); font-weight: 600;">
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
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                    <path d="M21 3v5h-5" />
                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                    <path d="M8 16H3v5" />
                </svg>
                Analyze Again
            </a>
            <a href="{{ route('download', ['analysis' => $analysis->id]) }}" class="px-5 py-2.5 rounded-xl text-sm flex items-center gap-2" style="background: linear-gradient(135deg, #0F172A, #1E40AF); color: #fff; font-weight: 600; box-shadow: 0 4px 16px rgba(15,23,42,0.25);">
                Download PDF
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
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
            </a>

            <div class="hidden sm:flex shrink-0 w-14 h-14 rounded-2xl items-center justify-center" style="background: linear-gradient(135deg, var(--accent-20), var(--accent-10)); border: 2px solid var(--accent-border);">
                <span style="color: var(--accent); font-weight: 800; font-size: 1.1rem;">{{ strtoupper(substr($accentLabel, 0, 1)) }}</span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="rounded-2xl overflow-hidden" style="background: #fff; box-shadow: 0 8px 32px rgba(15,23,42,0.12); border: 1px solid var(--accent-border);">
            <div class="px-5 py-3 flex items-center gap-3" style="background: linear-gradient(135deg, var(--accent-08), transparent); border-bottom: 1px solid var(--accent-border);">
                <div class="w-2 h-2 rounded-full animate-pulse" style="background: var(--accent);"></div>
                <span class="text-xs text-slate-500" style="font-weight: 500;">Analyzed Image</span>
                <span class="ml-auto text-xs px-2.5 py-0.5 rounded-full" style="background: var(--accent-bg); color: var(--accent); border: 1px solid var(--accent-border); font-weight: 600;">
                    {{ $accentLabel }}
                </span>
            </div>

            <div class="p-4" style="background: rgba(241,245,249,0.4);">
                <div class="relative rounded-xl overflow-hidden" style="box-shadow: 0 4px 20px rgba(15,23,42,0.10);">
                    <img src="{{ $imageUrl }}" alt="Uploaded" class="w-full object-cover bg-white" style="max-height: 320px;" />
                    <div class="absolute bottom-3 left-3 flex items-center gap-2 px-3 py-1.5 rounded-xl" style="background: rgba(15,23,42,0.55); border: 1px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.9);">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: var(--accent);"></span>
                        <span class="text-xs" style="font-weight: 600;">{{ $predText }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="fg-card rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-slate-800" style="font-size: 1rem; font-weight: 700;">Classification Summary</h2>
                    <p class="text-slate-400 text-xs mt-1">Confidence & explanation</p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full" style="background: var(--accent-bg); color: var(--accent); border: 1px solid var(--accent-border); font-weight: 700;">
                    {{ $confidencePct }}%
                </span>
            </div>

            <div class="mt-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm" style="font-weight: 600; color: #0f172a;">{{ $predText }}</span>
                    <span class="text-xs px-2.5 py-0.5 rounded-full border {{ $badgeClass }}" style="background: rgba(241,245,249,0.6); font-weight: 700;">
                        {{ $confidence < 0.6 ? 'Low' : ($confidence < 0.8 ? 'Medium' : 'High') }}
                    </span>
                </div>

                <div class="mt-3 flex items-center gap-2">
                    <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 700;">Confidence</div>
                    <x-ui.tooltip text="Confidence menunjukkan seberapa yakin model terhadap prediksinya.">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition"
                            data-modal-open="howAnalysisWorks"
                            aria-label="Confidence info"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4" aria-hidden="true">
                                <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-.999 2.575-2.414 2.92-.417.102-.586.405-.586.833V15m0 3h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                            </svg>
                        </button>
                    </x-ui.tooltip>
                </div>
                <div class="mt-3 h-2 w-full rounded-full overflow-hidden" style="background: rgba(241,245,249,0.9); border: 1px solid rgba(203,213,225,0.5);">
                    <div id="confidenceBar" class="h-full" data-width="{{ max(0, min(100, $confidencePct)) }}" style="background: var(--accent);"></div>
                </div>
                <div class="mt-2 text-xs text-slate-400">Indikator: rendah (&lt;60%), sedang (60–80%), tinggi (≥80%).</div>
            </div>

            <div class="mt-5 rounded-2xl p-5" style="background: rgba(241,245,249,0.6); border: 1px solid rgba(203,213,225,0.5);">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 800;">Penjelasan Analisis Gambar</div>
                        <x-ui.tooltip text="Analisis gambar dilakukan menggunakan model CNN melalui resize, normalisasi, ekstraksi fitur, dan klasifikasi.">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition"
                                data-modal-open="howAnalysisWorks"
                                aria-label="Explanation info"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4" aria-hidden="true">
                                    <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-.999 2.575-2.414 2.92-.417.102-.586.405-.586.833V15m0 3h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                </svg>
                            </button>
                        </x-ui.tooltip>
                    </div>
                    <button
                        type="button"
                        class="text-xs px-3 py-1 rounded-full"
                        style="background: rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.10); font-weight: 700;"
                        data-modal-open="howAnalysisWorks"
                    >
                        Lihat detail
                    </button>
                </div>

                <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 700;">Method</div>
                <div class="mt-1 text-sm text-slate-700" style="font-weight: 600;">{{ $method }}</div>

                <div class="mt-4">
                    <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 700;">Process (summary)</div>
                    <div class="mt-2 grid sm:grid-cols-2 gap-2">
                        <div class="rounded-xl px-3 py-2 fg-step-1">
                            <div class="text-xs text-slate-400">Step 1</div>
                            <div class="text-sm text-slate-700" style="font-weight: 700;">Resize 150×150</div>
                        </div>
                        <div class="rounded-xl px-3 py-2 fg-step-2">
                            <div class="text-xs text-slate-400">Step 2</div>
                            <div class="text-sm text-slate-700" style="font-weight: 700;">Normalize [0,1]</div>
                        </div>
                        <div class="rounded-xl px-3 py-2 fg-step-3">
                            <div class="text-xs text-slate-400">Step 3</div>
                            <div class="text-sm text-slate-700" style="font-weight: 700;">Feature Extract (CNN)</div>
                        </div>
                        <div class="rounded-xl px-3 py-2 fg-step-4">
                            <div class="text-xs text-slate-400">Step 4</div>
                            <div class="text-sm text-slate-700" style="font-weight: 700;">Classification</div>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-slate-400">
                        Buka <span class="text-slate-600" style="font-weight: 700;">Lihat detail</span> untuk membaca penjelasan lengkap.
                    </div>
                </div>

                <div class="mt-3 text-xs text-slate-400">
                    Jika confidence &lt; 60%, sistem bisa menampilkan <span class="text-slate-600" style="font-weight: 700;">Low confidence prediction</span>.
                </div>
            </div>
        </div>
    </div>

    <x-ui.modal id="howAnalysisWorks" title="Cara Kerja Analisis Gambar">
        <div class="space-y-5">
            <div>
                <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 800;">Metode</div>
                <div class="mt-1 text-slate-800" style="font-weight: 700;">Klasifikasi gambar berbasis CNN dengan tahap preprocessing</div>
            </div>

            <div>
                <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 800;">Langkah-langkah Proses</div>
                <div class="mt-3 space-y-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-sm text-slate-900" style="font-weight: 800;">1. Resize Gambar</div>
                        <div class="text-sm text-slate-600 mt-1">Gambar diubah ukurannya menjadi 150×150 piksel agar sesuai dengan ukuran input model.</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-sm text-slate-900" style="font-weight: 800;">2. Normalisasi</div>
                        <div class="text-sm text-slate-600 mt-1">Nilai piksel diskalakan dari 0–255 menjadi 0–1 agar model lebih stabil dan performanya lebih baik.</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-sm text-slate-900" style="font-weight: 800;">3. Ekstraksi Fitur (CNN)</div>
                        <div class="text-sm text-slate-600 mt-1">Model mengekstraksi pola visual seperti tekstur, warna, dan bentuk menggunakan layer konvolusi.</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-sm text-slate-900" style="font-weight: 800;">4. Klasifikasi</div>
                        <div class="text-sm text-slate-600 mt-1">Model mengklasifikasikan gambar menjadi Organic atau Recyclable.</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 800;">Interpretasi</div>
                <div class="mt-2 text-sm text-slate-600">
                    Sistem tidak “memahami” gambar seperti manusia, tetapi mendeteksi pola statistik dari data piksel.
                </div>
                <div class="mt-2 text-sm text-slate-600">
                    Sampah organic cenderung memiliki bentuk yang tidak beraturan dan warna alami, sedangkan sampah recyclable sering memiliki bentuk yang lebih terstruktur dan warna buatan.
                </div>
            </div>

            <div>
                <div class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 800;">Penjelasan Confidence</div>
                <div class="mt-2 text-sm text-slate-600">Confidence merepresentasikan probabilitas/tingkat keyakinan dari prediksi model.</div>
                <div class="mt-3 grid sm:grid-cols-3 gap-3">
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <div class="text-xs text-slate-400" style="font-weight: 800;">Low</div>
                        <div class="text-sm text-slate-700 mt-1" style="font-weight: 700;">&lt; 60%</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <div class="text-xs text-slate-400" style="font-weight: 800;">Medium</div>
                        <div class="text-sm text-slate-700 mt-1" style="font-weight: 700;">60–80%</div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <div class="text-xs text-slate-400" style="font-weight: 800;">High</div>
                        <div class="text-sm text-slate-700 mt-1" style="font-weight: 700;">&gt; 80%</div>
                    </div>
                </div>
            </div>
        </div>
    </x-ui.modal>

    <script>
        const bar = document.getElementById('confidenceBar');
        if (bar) {
            const width = Math.max(0, Math.min(100, Number(bar.getAttribute('data-width') || 0)));
            bar.style.width = width + '%';
        }
    </script>
</x-layouts.app>
