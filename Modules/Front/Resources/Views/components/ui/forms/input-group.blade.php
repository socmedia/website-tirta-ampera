@props([
    'id' => $attributes->has('label') ? slug($label) : randAlpha(8),
    'label' => null,
    'variant' => 'left',
])

<div class="input-group space-y-2">
    @if ($label)
        <label class="form-label" for="{{ $id }}">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($variant === 'left')
            <div class="icon input-icon-left">
                {{-- ICON GOES HERE --}}
                {{ $slot }}
            </div>
        @endif

        <input id="{{ $id }}" {{ $attributes->merge(['class' => 'peer input-field has-icon-' . $variant]) }}
               {{ $attributes }} />

        @if ($variant === 'right')
            <div class="icon input-icon-right">
                {{-- ICON GOES HERE --}}
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
