@props([
    'variant' => 'link-primary',
])

<a {{ $attributes->merge(['class' => "$variant"]) }} {{ $attributes }}>
    {{ $slot }}
</a>
