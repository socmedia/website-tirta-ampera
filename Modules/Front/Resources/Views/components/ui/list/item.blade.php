@props([
    'icon' => null,
    'href' => 'javascript:void(0)',
    'current' => false,
])

<li>
    <a href="{{ $href }}"
       {{ $attributes->merge([
           'class' =>
               'flex items-center gap-x-3.5 py-2 px-2.5 text-sm
                                                         text-zinc-800 rounded-lg hover:bg-zinc-100 focus:outline-hidden focus:bg-zinc-100 dark:hover:bg-zinc-800
                                                         dark:focus:bg-zinc-800 dark:text-white ' .
               ($current
                   ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-800
                                                         dark:text-white'
                   : ''),
       ]) }}>
        @if ($icon)
            <i class="{{ $icon }} size-6 rounded-md text-center !leading-6"></i>
        @endif
        <span>{{ $slot }}</span>
    </a>
</li>
