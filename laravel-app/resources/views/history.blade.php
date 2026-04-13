<x-layouts.app :title="'History'">
    @php
        $total = (int) ($stats['total'] ?? 0);
        $organic = (int) ($stats['organic'] ?? 0);
        $recyclable = (int) ($stats['recyclable'] ?? 0);
        $avg = (float) ($stats['avg_confidence'] ?? 0);
        $avgPct = $total > 0 ? round($avg * 100, 1) : 0;
    @endphp

    <div class="mb-6">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-5 h-5 rounded-lg flex items-center justify-center" style="background: rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.08);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-4 h-4"
                    style="color: rgba(148,163,184,1);"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
            </span>
            <span class="text-xs uppercase tracking-widest text-slate-400" style="font-weight: 600;">Analysis Log</span>
        </div>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-slate-800" style="font-size: 1.75rem; font-weight: 700;">History</h1>
                <p class="text-slate-500 text-sm mt-1">Daftar hasil analisis yang tersimpan di database.</p>
            </div>
            <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl text-sm flex items-center gap-2" style="background: linear-gradient(135deg, #0F172A, #1E40AF); color: #fff; font-weight: 600; box-shadow: 0 4px 16px rgba(15,23,42,0.25);">
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
                Upload Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="rounded-2xl p-4 flex items-center gap-3" style="background: #fff; box-shadow: 0 2px 12px rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.05);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(99,102,241,0.08);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5"
                    style="color: var(--fg-indigo);"
                    aria-hidden="true"
                >
                    <path d="M5 21v-6" />
                    <path d="M12 21V3" />
                    <path d="M19 21V9" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Total Analyses</p>
                <p style="font-size: 1.3rem; font-weight: 700; color: var(--fg-indigo); line-height: 1.2;">{{ $total }}</p>
            </div>
        </div>

        <div class="rounded-2xl p-4 flex items-center gap-3" style="background: #fff; box-shadow: 0 2px 12px rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.05);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(34,197,94,0.08);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5"
                    style="color: var(--fg-green);"
                    aria-hidden="true"
                >
                    <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Organic</p>
                <p style="font-size: 1.3rem; font-weight: 700; color: var(--fg-green); line-height: 1.2;">{{ $organic }}</p>
            </div>
        </div>

        <div class="rounded-2xl p-4 flex items-center gap-3" style="background: #fff; box-shadow: 0 2px 12px rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.05);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(59,130,246,0.08);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5"
                    style="color: var(--fg-blue);"
                    aria-hidden="true"
                >
                    <path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5" />
                    <path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12" />
                    <path d="m14 16-3 3 3 3" />
                    <path d="M8.293 13.596 7.196 9.5 3.1 10.598" />
                    <path d="m9.344 5.811 1.093-1.892A1.83 1.83 0 0 1 11.985 3a1.784 1.784 0 0 1 1.546.888l3.943 6.843" />
                    <path d="m13.378 9.633 4.096 1.098 1.097-4.096" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Recyclable</p>
                <p style="font-size: 1.3rem; font-weight: 700; color: var(--fg-blue); line-height: 1.2;">{{ $recyclable }}</p>
            </div>
        </div>

        <div class="rounded-2xl p-4 flex items-center gap-3" style="background: #fff; box-shadow: 0 2px 12px rgba(15,23,42,0.06); border: 1px solid rgba(15,23,42,0.05);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.08);">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5"
                    style="color: #F59E0B;"
                    aria-hidden="true"
                >
                    <path d="M16 7h6v6" />
                    <path d="m22 7-8.5 8.5-5-5L2 17" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Avg. Confidence</p>
                <p style="font-size: 1.3rem; font-weight: 700; color: #F59E0B; line-height: 1.2;">{{ $total > 0 ? $avgPct . '%' : '—' }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl overflow-hidden" style="background: #fff; box-shadow: 0 4px 24px rgba(15,23,42,0.08); border: 1px solid rgba(15,23,42,0.06);">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead style="background: rgba(241,245,249,0.8); border-bottom: 1px solid rgba(226,232,240,1);" class="text-slate-500">
                    <tr>
                        <th class="text-left px-5 py-4" style="font-weight: 600;">Gambar</th>
                        <th class="text-left px-5 py-4" style="font-weight: 600;">Prediction</th>
                        <th class="text-left px-5 py-4" style="font-weight: 600;">Confidence</th>
                        <th class="text-left px-5 py-4" style="font-weight: 600;">Waktu</th>
                        <th class="text-right px-5 py-4" style="font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $a)
                        @php
                            $conf = (float) $a->confidence;
                            $confPct = round($conf * 100, 2);
                            $pill = 'bg-green-50 text-green-700 border-green-200';
                            if ($conf < 0.6) $pill = 'bg-red-50 text-red-700 border-red-200';
                            elseif ($conf < 0.8) $pill = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                        @endphp
                        <tr class="border-t" style="border-color: rgba(226,232,240,1);">
                            <td class="px-5 py-4">
                                <img src="{{ asset('storage/' . $a->image_path) }}" class="h-12 w-12 object-cover rounded-xl" style="border: 1px solid rgba(15,23,42,0.08); box-shadow: 0 2px 12px rgba(15,23,42,0.06);" alt="thumb">
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-full border px-3 py-1 {{ $pill }}" style="background: rgba(241,245,249,0.6); font-weight: 700;">
                                    {{ $a->prediction }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-700">{{ $confPct }}%</td>
                            <td class="px-5 py-4 text-slate-500">{{ $a->created_at }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('result.show', ['analysis' => $a->id]) }}" class="px-4 py-2 rounded-xl text-sm" style="background: rgba(241,245,249,0.8); border: 1px solid rgba(203,213,225,0.6); font-weight: 700; color: #0f172a;">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada history. Silakan upload gambar di Home.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4" style="border-top: 1px solid rgba(226,232,240,1); background: #fff;">
            {{ $items->links() }}
        </div>
    </div>
</x-layouts.app>
