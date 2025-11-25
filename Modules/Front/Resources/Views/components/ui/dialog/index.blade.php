@props([
    'title' => '',
    'dialog' => 'dialog',
    'maxWidth' => 'md',
    'closeable' => true,
    'dismissAction' => null,
])

<!-- Overlay -->
<div class="fixed inset-0 z-50 bg-black/20 backdrop-blur-[1px] transition-opacity" x-cloak x-show="{{ $dialog }}"
     x-on:click="{{ $dialog }} = false; {{ $dismissAction }}">
</div>

<!-- Dialog -->
<div class="max-w-{{ $maxWidth }} z-100 fixed inset-y-0 right-0 w-full transform overflow-hidden bg-white shadow-xl transition-all dark:bg-neutral-900"
     x-cloak x-show="{{ $dialog }}" x-transition:enter="ease-out duration-300"
     x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="ease-in duration-200" x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-neutral-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white md:text-xl lg:text-2xl">{{ $title }}</h2>
        @if ($closeable)
            <button class="inline-flex rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-neutral-800 dark:hover:text-white"
                    x-on:click="{{ $dialog }} = false;  {{ $dismissAction }}">
                <i class="bx bx-x text-lg"></i>
            </button>
        @endif
    </div>

    <!-- Content -->
    <div class="overflow-y-auto px-6 py-4 text-base md:text-lg lg:text-xl">
        {{ $slot }}
    </div>
</div>
