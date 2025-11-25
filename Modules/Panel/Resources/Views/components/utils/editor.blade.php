@props([
    'editorId' => $attributes->has('id') ? $attributes->get('id') : randAlpha(),
    'label' => null,
    'placeholder' => null,
    'form' => $attributes->filter(fn($v, $k) => str_starts_with($k, 'wire:model'))->first(),
])

@push('style')
    @vite(['Modules/Panel/Resources/assets/js/editor.js'])
@endpush

<div class="space-y-2">
    <div class="prose-sm !max-w-full dark:prose-invert" wire:ignore x-data="editor({ id: '{{ $editorId }}', modelable: @js($form), placeholder: '{{ $placeholder }}' })">
        @if ($label)
            <label class="form-label mb-2 font-semibold" for="value-{{ $editorId }}">{{ $label }}</label>
        @endif

        <input id="value-{{ $editorId }}" name="{{ $form }}" type="hidden"
               wire:model.lazy="{{ $form }}" {{ $attributes->except(['wire:model']) }}>

    </div>

    @error($form)
        <div class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
    @enderror
</div>
