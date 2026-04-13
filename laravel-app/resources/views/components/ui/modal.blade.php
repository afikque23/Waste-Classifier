@props([
    'id',
    'title' => null,
])

<div
    id="{{ $id }}"
    class="fixed inset-0 z-60 hidden items-start justify-center px-6 pb-6 pt-20 sm:px-8 sm:pb-8 sm:pt-24"
    data-modal-root
    aria-hidden="true"
>
    <div
        class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-200"
        data-modal-backdrop
    ></div>

    <div
        class="relative z-10 w-full max-w-2xl max-h-[calc(100vh-7rem)] sm:max-h-[calc(100vh-8rem)] overflow-hidden flex flex-col rounded-xl bg-white shadow-2xl opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95 transition duration-200"
        role="dialog"
        aria-modal="true"
        aria-labelledby="{{ $id }}_title"
        data-modal-panel
    >
        <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-slate-100">
            <div>
                @if ($title)
                    <h2 id="{{ $id }}_title" class="text-slate-900" style="font-weight: 800; font-size: 1.05rem; letter-spacing: -0.01em;">
                        {{ $title }}
                    </h2>
                @endif
            </div>

            <button
                type="button"
                class="shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition"
                data-modal-close
                aria-label="Close"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5" aria-hidden="true">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 flex-1 overflow-y-auto">
            {{ $slot }}
        </div>

        <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
            <button
                type="button"
                class="px-4 py-2 rounded-xl text-sm"
                style="background: rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.10); font-weight: 700;"
                data-modal-close
            >
                Tutup
            </button>
        </div>
    </div>
</div>
