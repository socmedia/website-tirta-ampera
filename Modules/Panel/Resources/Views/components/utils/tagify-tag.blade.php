@props([
    'whitelist' => [],
    'maxTags' => 0,
    'placeholder' => 'Add tags...',
    'form' => $attributes->filter(fn($value, $key) => str_contains($key, 'wire:model'))->first(),
])

@push('style')
    @vite(['Modules/Panel/Resources/assets/js/tagify.js'])
@endpush

<div class="custom-tagify"
     data-config='{{ json_encode([
         'whitelist' => $whitelist,
         'maxTags' => $maxTags,
         'dropdown' => [
             'maxItems' => 20,
             'classname' => 'tags-look',
             'enabled' => 0,
             'closeOnSelect' => false,
         ],
     ]) }}'
     x-data="tagify()" wire:ignore>
    <input id="{{ $form }}" name="{{ $form }}" type="text" {{ $attributes->only('value') }}
           placeholder="{{ $placeholder }}" />
</div>
