@props([
    'type' => 'text',
    'value' => null,
])

<div class="input-preview">
    @switch($type)
        @case('input:checkbox')
            <span class="{{ $value ? 'badge soft-primary' : 'badge soft-danger' }}">
                {{ $value ? 'Yes' : 'No' }}
            </span>
        @break

        @case('input:image')
            @if ($value)
                <img class="h-12 rounded shadow-sm" src="{{ $value }}" alt="Preview">
            @else
                <span class="text-gray-400">No image</span>
            @endif
        @break

        @case('input:number')
            <span>{{ is_numeric($value) ? number_format($value, 0) : '—' }}</span>
        @break

        @case('json')
            <pre class="whitespace-pre-wrap break-words text-xs text-gray-700 dark:text-neutral-300">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @break

        @case('input:url')
            <a class="break-all text-primary underline" href="{{ $value }}" target="_blank">{{ $value }}</a>
        @break

        @default
            <span class="line-clamp-2 break-all">{{ $value ?? '—' }}</span>
    @endswitch
</div>
