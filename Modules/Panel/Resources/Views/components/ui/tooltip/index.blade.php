@props([
    'tooltip' => '',
    'placement' => 'top', // for future extensibility
])

<div class="relative" x-data="{ show: false }">
    <div class="outline-none" tabindex="0" x-on:mouseenter="show = true" x-on:mouseleave="show = false"
         x-on:focus="show = true" x-on:blur="show = false">
        {{ $slot }}
        <span class="shadow-2xs min-w-3xs absolute bottom-full left-1/2 z-10 mt-2 inline-block max-w-xs -translate-x-1/2 rounded-md bg-gray-900 px-2 py-1 text-xs font-medium text-white opacity-90 dark:bg-neutral-700"
              role="tooltip" style="display: none;" x-show="show" x-transition>
            {{ $tooltip }}
        </span>
    </div>
</div>
