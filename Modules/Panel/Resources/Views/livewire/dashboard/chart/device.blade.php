<div x-data="apexChart({
    options: {
        chart: {
            type: 'pie',
            height: 315,
            toolbar: { show: false },
        },
        labels: @js($data['labels']),
        legend: {
            show: true,
            position: 'bottom',
            fontSize: '12px',
            fontWeight: 400,
            labels: {
                colors: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563',
                useSeriesColors: false
            }
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
            style: {
                fontSize: '12px',
            }
        },
        colors: ['#3b82f6', '#a78bfa', '#34d399', '#fbbf24', '#f87171'],
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '12px',
                fontWeight: 500,
                colors: [document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151']
            },
            dropShadow: {
                enabled: false
            }
        },
        stroke: {
            show: false,
        },
        series: @js($data['data']),
    }
})">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 class="text-gray-700 dark:text-neutral-300">
                Device / Operating System
            </h2>
            <small class="mt-1 block text-xs text-gray-500 dark:text-neutral-400">
                @if (!empty($dateRange['start']) && !empty($dateRange['end']))
                    @if ($dateRange['start'] === $dateRange['end'])
                        {{ carbon($dateRange['start'])->format('d M Y') }}
                    @else
                        {{ carbon($dateRange['start'])->format('d M Y') }} -
                        {{ carbon($dateRange['end'])->format('d M Y') }}
                    @endif
                @else
                    -
                @endif
            </small>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-end sm:gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Total Sessions</p>
                <p class="text-xl font-medium text-gray-800 dark:text-neutral-200 sm:text-2xl">
                    {{ numberShortner(array_sum($data['data'])) }}
                </p>
            </div>
        </div>
    </div>

    <div class="min-h-[325px]" x-ref="chart"></div>
</div>
