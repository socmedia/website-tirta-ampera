@props([
    'title' => 'Nothing here yet',
    'description' => 'There’s currently no data to display.',
    'data' => 'Users',
    'icon' => 'bx-box',
])

<div class="min-h-100 mx-auto flex w-full max-w-sm flex-col justify-center px-6 py-4">
    <!-- Icon -->
    <div class="flex size-11 items-center justify-center rounded-lg bg-gray-100 dark:bg-neutral-800">
        <i class="{{ $icon }} text-xl text-gray-600 dark:text-neutral-400"></i>
    </div>

    <!-- Title -->
    <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
        {{ $title }}
    </h2>

    <!-- Description -->
    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
        {{ $description }}
    </p>

    @if ($attributes->has('href'))
        <div class="mt-3">
            <a class="btn solid-primary" {{ $attributes->only('href') }} {{ $attributes->only('x-on:click') }}
               {{ $attributes->only('wire:navigate') }}>
                <i class="bx bx-plus text-base"></i>
                Create new {{ $data }}
            </a>
        </div>
    @endif

</div>
