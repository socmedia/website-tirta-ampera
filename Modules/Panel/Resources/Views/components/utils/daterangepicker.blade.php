@props([
    'pickerId' => $attributes->has('id') ? $attributes->get('id') : randAlpha(),
    'label' => null,
    'placeholder' => null,
    'model' => null,
    'startDate' => null,
    'endDate' => null,
    'options' => [],
])

@push('style')
    @vite(['Modules/Panel/Resources/assets/js/daterangepicker.js'])
@endpush

<div class="w-full" wire:ignore x-data="daterangepicker" x-init="init({
    startDate: @js($startDate),
    endDate: @js($endDate),
    modelable: @entangle($model)
})">
    @if ($label)
        <label class="form-label mb-2 font-semibold">{{ $label }}</label>
    @endif

    <input type="text" {{ $attributes->merge(['class' => 'form-input']) }} x-ref="input"
           placeholder="{{ $placeholder }}" autocomplete="off">

    <input name="{{ $model }}" type="hidden" wire:model.defer="{{ $model }}">
</div>
