@props([
    'property' => 'phone',
    'value' => null,
])

@php
    // Normalize the value for display: always show as "+62 " followed by the number without leading 0/62/+62
    $displayValue = '+62 ';
    if ($value) {
        $displayValue .= preg_replace('/^(\+62|62|0)/', '', $value);
    }
@endphp

<div x-data="{ value: '{{ $displayValue }}' }">
    <input class="form-input" type="tel" x-mask="+62 999 9999 99999" x-model="value" {{ $attributes }}
           x-on:change="$wire.set('{{ $property }}', value.replace('+62', '').replace(/\s+/g, ''));" ">
</div>
