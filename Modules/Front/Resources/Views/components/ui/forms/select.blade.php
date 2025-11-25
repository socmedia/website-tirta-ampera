@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'description' => null,
    'form' => $attributes->filter(fn(string $value, string $key) => str_contains($key, 'wire:model'))->first(),
    'options' => null,
    'option-label' => 'label',
    'option-value' => 'value',
    'option-icon' => false,
    'option-icon-key' => 'icon',
])

<div class="space-y-2">
    @if ($label)
        <label class="block text-sm font-medium dark:text-white" for="{{ $id }}">{{ $label }}</label>
    @endif
    <select id="{{ $id }}" {{ $attributes->merge(['class' => 'form-input']) }}>
        @if ($options)
            @foreach ($options as $option)
                <option value="{{ is_array($option) ? $option[$optionValue ?? 'value'] : $option }}"
                        @if (old($form, $attributes->get('value')) == (is_array($option) ? $option[$optionValue ?? 'value'] : $option)) selected @endif>
                    @if ($optionIcon && !empty($option[$optionIconKey ?? 'icon']))
                        <i class="{{ $option[$optionIconKey ?? 'icon'] }}"></i>
                    @endif
                    {{ is_array($option) ? $option[$optionLabel ?? 'label'] : $option }}
                </option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>

    @error($form)
        <small class="mt-2 text-sm text-red-600">{{ $message }}</small>
    @else
        @if ($description)
            <small class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $description }}</small>
        @endif
    @enderror
</div>
