@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'description' => null,
    'form' => $attributes->filter(fn(string $value, string $key) => str_contains($key, 'wire:model'))->first(),
])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    <textarea id="{{ $id }}" {{ $attributes->merge(['class' => 'form-input']) }}
              {{ $attributes->except(['label', 'description']) }}></textarea>

    @error($form)
        <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
    @else
        @if ($description)
            <small class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $description }}</small>
        @endif
    @enderror
</div>
