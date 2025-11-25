@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'size' => null,
])

<div class="flex items-center gap-x-2">
    <label for="{{ $id }}" class="relative inline-block w-11 h-6 cursor-pointer">
        <input type="checkbox" id="{{ $id }}" class="peer sr-only" {{ $attributes }}>
        <span
              class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
        <span
              class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
    </label>
    <label for="{{ $id }}" class="text-sm text-gray-500 dark:text-neutral-400">
        {{ $label }}
    </label>
</div>
