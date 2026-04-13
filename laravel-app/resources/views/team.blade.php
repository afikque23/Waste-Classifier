<x-layouts.app :title="'Anggota Kelompok'">
    @php
        $paletteCount = 6;

        $initials = function (string $name): string {
            $parts = preg_split('/\s+/', trim($name));
            $first = $parts[0] ?? '';
            $last = count($parts) > 1 ? $parts[count($parts) - 1] : '';
            $a = mb_substr($first, 0, 1);
            $b = $last !== '' ? mb_substr($last, 0, 1) : '';
            return strtoupper($a . $b);
        };
    @endphp

    <div class="mb-8 text-center">
        <div class="flex items-center justify-center gap-2 mb-2">
            <span class="w-5 h-5 rounded-lg flex items-center justify-center" style="background: rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.08);">
                <span class="w-2 h-2 rounded-full" style="background: rgba(148,163,184,1);"></span>
            </span>
            <span class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 600;">Meet the Team</span>
        </div>
        <h1 class="text-slate-800" style="font-size: 1.75rem; font-weight: 700;">Our Team</h1>
        <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto">Daftar anggota dan peran dalam proyek.</p>
    </div>

    <div class="rounded-2xl p-6 mb-8 relative overflow-hidden" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 60%, #0F3460 100%); box-shadow: 0 8px 32px rgba(15,23,42,0.2);">
        <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full opacity-10" style="background: linear-gradient(135deg, var(--fg-green), var(--fg-blue));"></div>
        <div class="absolute -bottom-12 -left-8 w-52 h-52 rounded-full opacity-5" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);"></div>
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div>
                <p class="text-xs mb-1 uppercase tracking-widest" style="color: rgba(34,197,94,0.8); font-weight: 600;">Universitas</p>
                <h2 class="text-white" style="font-size: 1.1rem; font-weight: 700;">Web-Based Image Analysis Simulation</h2>
                <p class="text-white/50 text-xs mt-1">Waste Classification (Organic vs Recyclable) · 2026</p>
            </div>
            <div class="sm:ml-auto flex items-center gap-2">
                @foreach ($members as $i => $m)
                    @php
                        $pi = $i % $paletteCount;
                    @endphp
                    <div
                        class="team-p-{{ $pi }} team-avatar-stack w-8 h-8 rounded-full flex items-center justify-center text-white text-xs shrink-0 -ml-1 first:ml-0"
                        title="{{ $m['name'] }}"
                    >
                        {{ $initials($m['name']) }}
                    </div>
                @endforeach
                <span class="ml-2 text-white/50 text-xs">{{ count($members) }} members</span>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($members as $i => $m)
            @php
                $pi = $i % $paletteCount;
            @endphp
            <div class="team-p-{{ $pi }} rounded-2xl overflow-hidden transition-all duration-300" style="background: #fff; box-shadow: 0 4px 20px rgba(15,23,42,0.07); border: 1px solid rgba(15,23,42,0.06);">
                <div class="team-role-header-bg relative h-20 flex items-end px-5 pb-0">
                    <div class="team-role-blob absolute top-2 right-4 w-12 h-12 rounded-full opacity-15"></div>
                    <div class="team-role-blob absolute top-5 right-10 w-6 h-6 rounded-full opacity-10"></div>
                </div>

                <div class="px-5 -mt-8 relative z-10">
                    <div class="team-avatar-card w-16 h-16 rounded-2xl flex items-center justify-center text-white">
                        {{ $initials($m['name']) }}
                    </div>
                </div>

                <div class="px-5 pb-5 pt-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-slate-800" style="font-weight: 700; font-size: 1rem; line-height: 1.2;">{{ $m['name'] }}</h3>
                            <p class="text-slate-400 text-xs mt-1">NIM: {{ $m['nim'] }}</p>
                        </div>
                        <span class="team-role-badge text-xs px-3 py-1 rounded-full">
                            {{ $i + 1 }}
                        </span>
                    </div>

                    <div class="mt-4 inline-flex items-center rounded-full border px-3 py-1 text-xs" style="background: rgba(241,245,249,0.6); border-color: rgba(203,213,225,0.6); color: #0f172a; font-weight: 700;">
                        {{ $m['role'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 text-xs text-slate-400">
        Edit data anggota di <span class="text-slate-600" style="font-weight: 700;">config/team.php</span>.
    </div>
</x-layouts.app>
