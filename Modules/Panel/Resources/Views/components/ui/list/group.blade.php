@props([
    'label' => '',
    'icon' => null,
    'collapsible' => true,
    'collapsed' => false,
    'groupId' => 'group-' . randAlpha(6),
    'open' => false,
    'current' => false,
])

<li x-data="{ open: {{ $open ? 'true' : 'false' }} }">
    <button type="button"
            {{ $attributes->merge([
                'class' =>
                    'flex items-center w-full gap-x-3.5 py-2 px-2.5 text-sm text-zinc-800 rounded-lg
                                                                                hover:bg-zinc-100 focus:outline-none focus:bg-zinc-100
                                                                                dark:hover:bg-zinc-700 dark:focus:bg-zinc-700 dark:text-white ' .
                    ($current || $open ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-white' : ''),
            ]) }}
            x-on:click="open = !open" :aria-expanded="open.toString()" :aria-controls="'{{ $groupId }}'">

        @if ($icon)
            <i class="{{ $icon }} size-6 rounded-md text-center !leading-6"></i>
        @endif
        <span class="flex-1 whitespace-nowrap text-left"> {{ __('panel::sidebar.' . $label) }}</span>
        <i class="bx bx-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
    </button>

    <ul class="ml-5 mt-1 space-y-1 border-l border-zinc-200 pl-3 dark:border-zinc-700" id="{{ $groupId }}"
        x-show="open" x-collapse x-cloak>
        {{ $slot }}
    </ul>
</li>
