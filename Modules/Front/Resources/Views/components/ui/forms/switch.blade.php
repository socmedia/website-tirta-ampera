@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'size' => null,
])

<div class="flex items-center gap-x-2">
    <label class="relative inline-block h-6 w-11 cursor-pointer" for="{{ $id }}">
        <input class="peer sr-only" id="{{ $id }}" type="checkbox" {{ $attributes }}>
        <span
              class="absolute inset-0 rounded-full bg-gray-200 transition-colors duration-200 ease-in-out peer-checked:bg-sky-600 peer-disabled:pointer-events-none peer-disabled:opacity-50 dark:bg-neutral-700 dark:peer-checked:bg-sky-500"></span>
        <span
              class="shadow-xs absolute start-0.5 top-1/2 size-5 -translate-y-1/2 rounded-full bg-white transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
    </label>
    <label class="text-sm text-gray-500 dark:text-neutral-400" for="{{ $id }}">
        {{ $label }}
    </label>
</div>
