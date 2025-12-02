@props([
    'data' => [],
    'options' => [10, 25, 50, 100],
    'perPage' => 10,
])

<div
     class="grid gap-3 border-t border-zinc-200 px-6 py-4 dark:border-zinc-700 md:flex md:items-center md:justify-between">
    <div class="flex items-center gap-3">
        {{-- Per Page Dropdown (Livewire-bound) --}}
        <div class="ml-4">
            <label class="sr-only" for="perPage">Per Page</label>
            <select class="rounded-lg border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-sky-500 focus:ring-sky-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:focus:border-sky-500 dark:focus:ring-sky-500"
                    id="perPage" wire:model.lazy="perPage">
                @foreach ($options as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>

        {{-- Showing x to y of z results --}}
        <p class="inline-flex gap-x-1.5 text-sm text-zinc-600 dark:text-zinc-400">
            Showing
            <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $data->firstItem() }}</span>
            to
            <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $data->lastItem() }}</span>
            of
            <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $data->total() }}</span>
            results
        </p>
    </div>

    <div>
        {{ $data->onEachSide(1)->links('livewire::tailwind') }}
    </div>
</div>
