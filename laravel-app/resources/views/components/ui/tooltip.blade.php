@props([
    'text',
])

<span {{ $attributes->merge(['class' => 'relative inline-flex items-center group']) }}>
    {{ $slot }}

    <span
        class="pointer-events-none absolute left-1/2 top-0 z-50 hidden w-max max-w-[260px] -translate-x-1/2 -translate-y-2 rounded-lg bg-slate-900 px-3 py-2 text-xs text-white shadow-lg opacity-0 transition duration-150 group-hover:block group-hover:opacity-100"
        role="tooltip"
    >
        {{ $text }}
        <span class="absolute left-1/2 top-full -translate-x-1/2 border-4 border-transparent border-t-slate-900"></span>
    </span>
</span>
