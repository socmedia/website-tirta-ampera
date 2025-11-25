@props([
    'id' => null,
    'label' => null,
    'icon' => null,
    'width' => 'min-w-42',
    'position' => 'right-0', // 'center' or 'right-0'
])

<div class="inline-flex" x-data="dropdownTeleport" x-ref="ts" x-on:keydown.window.escape="dropdownOpen = false">
    <button type="button" aria-haspopup="true" x-on:click="toggle($refs.ts)" x-bind:aria-expanded="dropdownOpen"
            {{ $attributes->merge(['class' => '']) }}>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        @if ($label)
            <span>{{ $label }}</span>
        @endif
    </button>

    <!-- Rendered menu in Blade -->
    <div class="dropdown-content {{ $width }} absolute z-40 mt-2 hidden origin-top-right rounded-md border border-gray-200 bg-white shadow-md dark:divide-neutral-700 dark:border dark:border-neutral-700 dark:bg-neutral-800"
         x-ref="menuEl">
        <div class="px-1 py-1.5" role="menu" aria-orientation="vertical">
            {{ $slot }}
        </div>
    </div>
</div>
