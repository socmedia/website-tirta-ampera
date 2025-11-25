@props([
    'id' => null,
    'label' => null,
    'icon' => null,
])

<div class="hs-dropdown relative inline-flex" wire:ignore>
    <button id="dropdown-{{ $id }}" type="button" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown"
            {{ $attributes->only('class') }}>
        {{ $label }}
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
    </button>

    <div class="hs-dropdown-menu duration hs-dropdown-open:opacity-100 z-50 mt-2 hidden min-w-60 divide-y divide-gray-200 rounded-lg bg-white opacity-0 shadow-md transition-[opacity,margin] dark:divide-neutral-700 dark:border dark:border-neutral-700 dark:bg-neutral-800"
         role="menu" aria-orientation="vertical" aria-labelledby="dropdown-{{ $id }}">
        <div class="space-y-0.5 p-1">
            {{ $slot }}
        </div>
    </div>
</div>
