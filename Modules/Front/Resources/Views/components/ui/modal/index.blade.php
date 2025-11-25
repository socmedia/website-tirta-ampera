@props([
    'title' => 'Modal Title',
    'modal' => 'show',
    'variant' => 'modal-md', // modal-sm, modal-md, modal-lg, modal-xl, modal-2xl
    'dismissAction' => null,
])

<template x-teleport="body">
    <div>
        <div class="z-100 fixed inset-0 m-0 bg-black/20 backdrop-blur-[1px] transition-opacity" x-cloak
             x-show="{{ $modal }}" x-on:click="{{ $modal }} = false; {{ $dismissAction }}"
             x-on:keydown.escape.window="{{ $modal }} = false; {{ $dismissAction }}"
             wire:key="{{ randAlpha() }}">
        </div>

        <div class="modal {{ $variant }}" role="dialog" tabindex="-1" x-show="{{ $modal }}"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             x-trap="{{ $modal }}" x-cloak>
            <div class="modal-wrapper w-full">
                <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3">
                    <h3 class="font-bold text-gray-800" id="hs-bg-gray-on-hover-cards-label">
                        {{ $title }}
                    </h3>
                    <div class="modal-close">
                        <button type="button" aria-label="Close"
                                x-on:click="{{ $modal }} = false; {{ $dismissAction }}">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</template>
