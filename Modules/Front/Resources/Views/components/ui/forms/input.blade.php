@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'description' => null,
    'form' => $attributes->filter(fn(string $value, string $key) => str_contains($key, 'wire:model'))->first(),
])

<div class="space-y-2">
    @if ($label)
        <label class="form-label" for="{{ $id }}">{!! $label !!}</label>
    @endif
    <input id="{{ $id }}" {{ $attributes->merge(['class' => 'form-input']) }} {{ $attributes }} />

    @error($form)
        <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
    @else
        @if ($description)
            <small class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $description }}</small>
        @endif
    @enderror
</div>
