@props([
    'type' => 'input:text',
    'form' => null,
])

@switch($type)
    @case('input:number')
        <input class="form-input text-right" value="{{ $trans['value'] }}" x-mask:dynamic="$money($input)"
               x-on:change="$wire.set('{{ $form }}', `${$el.value.replace(/[A-Za-z% ,.]/g, '')}`)" />
    @break

    @case('textarea')
        <textarea class="form-textarea w-full" rows="4" wire:model="{{ $form }}"></textarea>
    @break

    @case('input:image')
        @php
            $form = str_replace('value', 'uploaded_file', $form);
        @endphp
        <div class="space-y-2">
            <input class="form-file w-full" type="file" accept="image/*" placeholder="Image URL"
                   wire:model="{{ $form }}">
            <div wire:loading wire:target="{{ $form }}" class="text-xs text-gray-500">Uploading...</div>
        </div>
    @break

    @case('input:url')
        <input class="form-input w-full" type="url" wire:model="{{ $form }}">
    @break

    @case('input:email')
        <input class="form-input w-full" type="email" wire:model="{{ $form }}">
    @break

    @case('json')
        <textarea class="font-mono form-textarea w-full text-xs" rows="6" wire:model="{{ $form }}"></textarea>
    @break

    @case('input:checkbox')
        <div class="flex items-center">
            <input class="form-checkbox" id="{{ $form }}" type="checkbox" @checked($value)
                   x-on:change="$wire.set('{{ $form }}', $el.checked)">
            <label class="ml-2 text-sm" for="{{ $form }}">{{ $trans['name'] ?? $trans['title'] }}</label>
        </div>
    @break

    @case('input:text')
        <input class="form-input w-full" type="text" wire:model="{{ $form }}">
    @break

    @default
        <input class="form-input w-full" type="text" wire:model="{{ $form }}">
@endswitch
