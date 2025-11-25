@props([
    'variant' => 'solid-primary',
])

<button type="submit" {{ $attributes->merge(['class' => "btn $variant"]) }} {{ $attributes }}>
    <span class="btn-spinner" role="status" aria-label="loading" wire:loading
          {{ $attributes->only(['wire:target']) }}></span>
    {{ $slot }}
</button>
