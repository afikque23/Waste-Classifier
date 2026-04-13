<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Waste Classification Demo' }}</title>
    <link rel="stylesheet" href="{{ asset('css/figma.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
    @php
        $navItems = [
            [
                'route' => 'home',
                'label' => 'Home',
                'icon' => 'house',
                'active' => request()->routeIs('home'),
            ],
            [
                'route' => 'result',
                'label' => 'Result',
                'icon' => 'chart-no-axes-column',
                'active' => request()->routeIs('result') || request()->routeIs('result.show'),
            ],
            [
                'route' => 'history',
                'label' => 'History',
                'icon' => 'clock',
                'active' => request()->routeIs('history'),
            ],
            [
                'route' => 'team',
                'label' => 'Team',
                'icon' => 'users',
                'active' => request()->routeIs('team'),
            ],
        ];
    @endphp

    <header id="topNav" class="fg-navbar sticky top-0 z-50 w-full transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center h-16 gap-8">
            <a href="{{ route('home') }}" class="flex flex-col justify-center select-none">
                <span class="text-white" style="font-weight: 700; font-size: 0.95rem; letter-spacing: -0.01em;">
                    Waste Classifier
                </span>
                <span class="hidden sm:block" style="color: rgba(255,255,255,0.35); font-size: 0.65rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase;">
                    Image Analysis · AI
                </span>
            </a>

            <nav class="hidden md:flex items-center gap-1 flex-1 justify-center">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="group relative px-4 py-2 rounded-xl flex items-center gap-2 transition-colors duration-200 {{ $item['active'] ? 'text-white fg-nav-pill' : 'text-white/50 hover:text-white/80' }}"
                    >
                        @if ($item['icon'] === 'house')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 relative z-10 transition-colors duration-200 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                                <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            </svg>
                        @elseif ($item['icon'] === 'chart-no-axes-column')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 relative z-10 transition-colors duration-200 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M5 21v-6" />
                                <path d="M12 21V3" />
                                <path d="M19 21V9" />
                            </svg>
                        @elseif ($item['icon'] === 'clock')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 relative z-10 transition-colors duration-200 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-inactive' }}"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        @elseif ($item['icon'] === 'users')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 relative z-10 transition-colors duration-200 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                        @endif
                        <span class="relative z-10 text-sm {{ $item['active'] ? 'font-semibold' : 'font-normal' }}">
                            {{ $item['label'] }}
                        </span>

                        @if (! $item['active'])
                            <span
                                class="absolute bottom-1 left-4 right-4 h-px rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                style="background: rgba(255,255,255,0.2);"
                                aria-hidden="true"
                            ></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="hidden md:flex items-center gap-2 ml-auto">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs" style="background: rgba(34,197,94,0.12); color: #4ADE80; border: 1px solid rgba(34,197,94,0.22); font-weight: 500;">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    Model Ready
                </div>
            </div>

            <button
                id="mobileToggle"
                class="md:hidden ml-auto p-2 rounded-xl transition-colors duration-200"
                style="color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.07);"
                aria-label="Toggle menu"
                type="button"
            >
                <span id="mobileIconOpen" class="block" aria-hidden="true">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-5 h-5"
                    >
                        <path d="M4 5h16" />
                        <path d="M4 12h16" />
                        <path d="M4 19h16" />
                    </svg>
                </span>
                <span id="mobileIconClose" class="hidden" aria-hidden="true">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="w-5 h-5"
                    >
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </span>
            </button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden border-t" style="border-color: rgba(255,255,255,0.06);">
            <nav class="flex flex-col px-4 py-3 gap-1">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors duration-200 {{ $item['active'] ? 'text-white fg-mobile-active-bg' : 'text-white/50' }}"
                    >
                        @if ($item['icon'] === 'house')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-mobile-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                                <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            </svg>
                        @elseif ($item['icon'] === 'chart-no-axes-column')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-mobile-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M5 21v-6" />
                                <path d="M12 21V3" />
                                <path d="M19 21V9" />
                            </svg>
                        @elseif ($item['icon'] === 'clock')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-mobile-inactive' }}"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        @elseif ($item['icon'] === 'users')
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 {{ $item['active'] ? 'fg-icon-active' : 'fg-icon-mobile-inactive' }}"
                                aria-hidden="true"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                        @endif
                        <span class="text-sm {{ $item['active'] ? 'font-semibold' : 'font-normal' }}">{{ $item['label'] }}</span>
                        @if ($item['active'])
                            <span class="ml-auto w-1.5 h-1.5 rounded-full" style="background: var(--fg-green);"></span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                <div class="font-semibold">Terjadi kesalahan</div>
                <div class="text-sm">{{ session('error') }}</div>
            </div>
        @endif
        @if (session('info'))
            <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-blue-700 shadow-sm">
                <div class="font-semibold">Info</div>
                <div class="text-sm">{{ session('info') }}</div>
            </div>
        @endif

        {{ $slot }}
        </div>
    </main>

    <footer class="py-10 text-center text-xs text-gray-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="inline-flex items-center gap-2 rounded-full border border-black/5 bg-white px-4 py-2 shadow-sm">
                <span class="text-gray-600">University Demo</span>
                <span class="text-gray-300">•</span>
                <span class="text-gray-600">Flask AI API</span>
                <span class="font-medium text-gray-900">{{ config('services.flask.predict_url') }}</span>
            </div>
        </div>
    </footer>

    <script>
        const topNav = document.getElementById('topNav');
        const toggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const iconOpen = document.getElementById('mobileIconOpen');
        const iconClose = document.getElementById('mobileIconClose');

        const syncScrolled = () => {
            if (!topNav) return;
            topNav.setAttribute('data-scrolled', window.scrollY > 12 ? '1' : '0');
        };
        window.addEventListener('scroll', syncScrolled);
        syncScrolled();

        toggle?.addEventListener('click', () => {
            const isOpen = !mobileMenu?.classList.contains('hidden');
            mobileMenu?.classList.toggle('hidden');
            iconOpen?.classList.toggle('hidden');
            iconClose?.classList.toggle('hidden');
            toggle.setAttribute('aria-expanded', (!isOpen).toString());
        });

        mobileMenu?.querySelectorAll('a').forEach((a) => {
            a.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                iconOpen?.classList.remove('hidden');
                iconClose?.classList.add('hidden');
                toggle?.setAttribute('aria-expanded', 'false');
            });
        });

        const openModal = (modalEl) => {
            if (!modalEl) return;
            const backdrop = modalEl.querySelector('[data-modal-backdrop]');
            const panel = modalEl.querySelector('[data-modal-panel]');

            modalEl.classList.remove('hidden');
            modalEl.classList.add('flex');
            modalEl.setAttribute('aria-hidden', 'false');
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                backdrop?.classList.remove('opacity-0');
                backdrop?.classList.add('opacity-100');

                panel?.classList.remove('opacity-0', 'translate-y-2', 'sm:scale-95');
                panel?.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        };

        const closeModal = (modalEl) => {
            if (!modalEl) return;
            const backdrop = modalEl.querySelector('[data-modal-backdrop]');
            const panel = modalEl.querySelector('[data-modal-panel]');

            backdrop?.classList.add('opacity-0');
            backdrop?.classList.remove('opacity-100');

            panel?.classList.add('opacity-0', 'translate-y-2', 'sm:scale-95');
            panel?.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');

            window.setTimeout(() => {
                modalEl.classList.add('hidden');
                modalEl.classList.remove('flex');
                modalEl.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
            }, 180);
        };

        document.addEventListener('click', (e) => {
            const openBtn = e.target.closest('[data-modal-open]');
            if (openBtn) {
                const modalId = openBtn.getAttribute('data-modal-open');
                const modalEl = modalId ? document.getElementById(modalId) : null;
                openModal(modalEl);
                return;
            }

            const closeBtn = e.target.closest('[data-modal-close]');
            if (closeBtn) {
                const modalEl = closeBtn.closest('[data-modal-root]');
                closeModal(modalEl);
                return;
            }

            const backdrop = e.target.closest('[data-modal-backdrop]');
            if (backdrop) {
                const modalEl = backdrop.closest('[data-modal-root]');
                closeModal(modalEl);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const openModalEl = document.querySelector('[data-modal-root]:not(.hidden)');
            closeModal(openModalEl);
        });
    </script>
</body>
</html>
