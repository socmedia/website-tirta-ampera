@props([
    'property' => 'phone',
    'value' => null,
])

<div x-data="{
    value:"{{ $value ? '+62 ' . preg_replace('/^(\+62|62|0)/', '', $value) : '+62 ' }}"}">
    <input class="form-input" type="tel" {{ $attributes }} x-mask="'+62 000 0000 00000'" x-model="value"
           x-on:input="
            if (!value.startsWith('+62 ')) value = '+62 ' + value.replace(/^\+?62 ?|^0/, '');
            value = value.replace(/[^0-9+ ]/g, '');
        "
           x-on:change="$wire.set('{{ $property }}', value.replace(/\D/g, '').replace(/^62/, ''))"
           placeholder="+62 xxx xxxx xxxxx">
</div>
