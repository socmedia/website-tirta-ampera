@props([
    'title' => null,
    'items' => [],
])

@php
    $count = count($items);
@endphp

<div
     class="flex flex-wrap justify-between gap-3 border-b border-zinc-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800">
    @if ($title)
        <h1 class="text-lg font-semibold text-zinc-800 dark:text-neutral-200">{{ $title }}</h1>
    @endif

    <ol class="flex flex-wrap items-center gap-1 whitespace-nowrap text-xs sm:text-sm">
        @foreach ($items as $index => $item)
            @php
                $isLast = $loop->last;
                $isFirst = $loop->first;
                $isSecondToLast = $loop->index === $count - 1;
                $shouldHideOnMobile = !$isFirst && !$isSecondToLast && !$isLast;

                $showEllipsis = $loop->index === 1 && $count > 4;
            @endphp

            @if ($showEllipsis)
                <li class="inline-flex items-center sm:hidden">
                    <span class="mx-1 text-zinc-400 dark:text-neutral-500">…</span>
                    <i class="bx bx-chevron-right mx-1 shrink-0 text-lg text-zinc-400 dark:text-neutral-600"></i>
                </li>
            @endif

            <li class="{{ $shouldHideOnMobile ? 'hidden sm:inline-flex' : 'inline-flex' }} items-center">
                @if (!$isLast)
                    <a class="link-white flex items-center" href="{{ $item['url'] ?? '#' }}" wire:navigate>
                        {{ $item['label'] }}
                    </a>
                    <i class="bx bx-chevron-right mx-1 shrink-0 text-lg text-zinc-400 dark:text-zinc-600"></i>
                @else
                    <span class="truncate font-semibold text-zinc-800 dark:text-zinc-200" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</div>
