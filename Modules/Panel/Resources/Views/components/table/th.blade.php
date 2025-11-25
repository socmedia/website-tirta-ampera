@php
    $name = $column->name;
    $sortable = $column->sortable;
@endphp
<th class="{{ $name == $sort ? 'bg-light' : null }} px-6 py-3 text-left text-xs font-medium uppercase text-gray-500"
    scope="col" x-data="{
        name: '{{ $column->name }}',
        sort: '{{ $sort }}',
    }">
    @if ($sortable)
        <button class="flex w-full items-center justify-between whitespace-nowrap uppercase" type="button"
                x-on:click="
                sort = name;
                $dispatch('sortOrder', [sort])">
            {{ $column->label }}
            @if ($sort == $name && $order == 'asc')
                <i class="bx bx-chevron-up bx-border-circle ml-2"></i>
            @elseif($sort == $name && $order == 'desc')
                <i class="bx bx-chevron-down bx-border-circle ml-2"></i>
            @else
                <i class="bx bx-filter bx-border-circle ml-2"></i>
            @endif
        </button>
    @else
        {{ $column->label }}
    @endif
</th>
