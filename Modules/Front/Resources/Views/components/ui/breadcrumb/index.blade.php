@props([
    'title' => null,
    'items' => [],
])

@php
    $count = count($items);
@endphp

<div class="relative z-50 mt-20 border-y border-neutral-200 bg-white">
    <div class="container">
        <div class="flex min-h-[62px] items-center py-4">
            <div
                 class="mx-auto flex w-full flex-col items-start justify-between space-y-2 md:flex-row md:items-center md:space-y-0">

                @if ($title)
                    <h1 class="text-base font-medium text-neutral-800 md:text-lg">{{ $title }}</h1>
                @endif

                @if (!empty($items))
                    <nav class="flex items-center text-sm font-medium text-neutral-500">
                        <ul class="flex flex-wrap items-center space-x-1">
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
                                        <span class="text-neutral-400 md:mx-1">…</span>
                                        <i class="bx bx-chevron-right shrink-0 text-sm text-neutral-400"></i>
                                    </li>
                                @endif

                                <li
                                    class="{{ $shouldHideOnMobile ? 'hidden sm:inline-flex' : 'inline-flex' }} items-center">
                                    @if (!$isLast)
                                        <a class="flex items-center hover:text-neutral-700 md:mx-1"
                                           href="{{ $item['url'] ?? '#' }}" wire:navigate>
                                            {{ $item['label'] }}
                                        </a>
                                        <i class="bx bx-chevron-right text-sm text-neutral-400"></i>
                                    @else
                                        <span class="truncate text-sky-600" aria-current="page">
                                            {{ $item['label'] }}
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>
