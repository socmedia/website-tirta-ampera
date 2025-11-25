@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'property' => 'price',
    'mask' => 99,
    'label' => null,
    'prefix' => null,
    'suffix' => null,
    'value' => null,
])

<div>
    @if ($label)
        <label class="form-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <input {{ $attributes->merge(['class' => 'form-input text-right']) }}{{ $attributes }}
           x-mask:dynamic="'{{ $prefix }}' + {{ $mask }} + '{{ $suffix }}'"
           :value="{{ $value }}"
           x-on:change="$wire.set('{{ $property }}', `${$el.value.replace(/[A-Za-z% ,.]/g, '')}`)">
</div>
