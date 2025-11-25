@props([
    'icon' => 'bx bx-menu',
    'href' => 'javascript:void(0)',
    'current' => false,
])

<li>
    <a class="{{ $current ? 'bg-zinc-800/[4%] dark:bg-white/[7%] text-zinc-800 dark:text-white' : '' }} relative my-px flex w-full items-center gap-1 rounded-lg px-3 py-2 text-start text-zinc-500 hover:bg-zinc-800/[4%] hover:text-zinc-800 dark:bg-white/[7%] dark:text-white/80 dark:hover:bg-white/[7%] dark:hover:text-white"
       href="{{ $href }}" {{ $attributes }}>
        <i class="{{ $icon }}"></i>
        <span class="ml-3">{{ $slot }}</span>
    </a>
</li>
