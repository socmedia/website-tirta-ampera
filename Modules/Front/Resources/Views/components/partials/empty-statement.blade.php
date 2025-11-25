@props([
    'icon' => 'bx-news',
    'title' => 'No results found',
    'description' =>
        "We couldn't find any results matching your criteria.<br>Try adjusting your filters or search keywords.",
])

<div class="col-span-full flex flex-col items-center justify-center py-16">
    <i class="bx {{ $icon }} mb-6 text-[8rem] text-neutral-300 opacity-80"></i>
    <h3 class="mb-2 text-xl font-semibold text-neutral-700">{!! $title !!}</h3>
    <p class="mb-4 max-w-md text-center text-neutral-500">
        {!! $description !!}
    </p>
    <button class="solid-primary btn rounded-full" wire:click="resetFilters">
        Reset Filters <i class="bx bx-x"></i>
    </button>
</div>
