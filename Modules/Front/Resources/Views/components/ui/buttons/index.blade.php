@props([
    'variant' => 'solid-primary',
])

<button {{ $attributes->merge(['class' => "btn $variant"]) }} {{ $attributes }}>
    {{ $slot }}
</button>
