@props(['paginator', 'label' => 'results'])

@if ($paginator->total() > 0)
    <p class="text-sm text-neutral-600">
        <span class="font-semibold text-zinc-700">{{ $paginator->firstItem() }}</span>
        to
        <span class="font-semibold text-zinc-700">{{ $paginator->lastItem() }}</span>
        of
        <span class="font-semibold text-zinc-700">{{ $paginator->total() }}</span>
        {{ $label }}
    </p>
@else
    <p class="text-sm text-neutral-600">
        No {{ $label }} found.
    </p>
@endif
