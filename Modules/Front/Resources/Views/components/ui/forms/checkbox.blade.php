@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'size' => null,
])

<div class="flex items-center">
    <input type="checkbox" id="{{ $id }}"
           {{ $attributes->merge(['class' => 'form-checkbox' . ($size ? " form-checkbox-{$size}" : '')]) }}
           {{ $attributes }}>

    @if ($label)
        <label for="{{ $id }}" class="text-sm text-gray-500 ml-2 dark:text-neutral-400">
            {{ $label }}
        </label>
    @endif
</div>
