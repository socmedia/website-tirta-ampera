@props([
    'label' => 'Total users',
    'tooltip' => 'The number of daily users',
    'icon' => null,
    'stat' => '72,540',
    'statIcon' => null,
    'statChange' => null,
    'statChangeColor' => 'text-green-600', // or text-red-600 for negative
])

<div class="p-4 md:p-5">
    <div class="flex items-center justify-between gap-x-2">
        <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
            {{ $label }}
        </p>
        @if ($tooltip)
            <x-panel::ui.tooltip :tooltip="$tooltip">
                @if ($icon)
                    <i class='bx {{ $icon }} size-4 shrink-0 text-gray-500 dark:text-neutral-500'></i>
                @else
                    <i class='bx bx-info-circle size-4 shrink-0 text-gray-500 dark:text-neutral-500'></i>
                @endif
            </x-panel::ui.tooltip>
        @endif
    </div>

    <div class="mt-1 flex items-center gap-x-2">
        <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200 sm:text-2xl">
            {{ $stat }}
        </h3>

        @if ($statChange)
            <span class="{{ $statChangeColor }} flex items-center gap-x-1">
                <i class='bx {{ $statIcon }} inline-block size-4 self-center'></i>
                <span class="inline-block text-sm">
                    {{ $statChange }}
                </span>
            </span>
        @endif
    </div>
</div>
