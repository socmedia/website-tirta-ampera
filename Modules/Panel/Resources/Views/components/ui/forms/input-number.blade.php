@props([
    'property' => 'price',
    'mask' => 99,
    'prefix' => null,
    'suffix' => null,
    'value' => null,
])

<div>
    <input class="text-right form-input" {{ $attributes }}
           x-mask:dynamic="'{{ $prefix }}' + {{ $mask }} + '{{ $suffix }}'"
           :value="{{ $value }}"
           x-on:change="$wire.set('{{ $property }}', `${$el.value.replace(/[A-Za-z% ,.]/g, '')}`)">
</div>
