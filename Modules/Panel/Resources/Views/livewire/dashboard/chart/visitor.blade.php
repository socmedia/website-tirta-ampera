<div x-data="apexChart({
    options: {
        chart: {
            type: 'area',
            height: 315,
            toolbar: { show: true },
            zoom: {
                enabled: true
            },
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#334155' : '#e5e7eb',
            row: { colors: ['transparent'], opacity: 0.5 },
        },
        xaxis: {
            categories: @js($data['categories']),
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? ['#a3a3a3', '#a3a3a3', '#a3a3a3', '#a3a3a3', '#a3a3a3', '#a3a3a3', '#a3a3a3'] : ['#6b7280', '#6b7280', '#6b7280', '#6b7280', '#6b7280', '#6b7280', '#6b7280'],
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#a3a3a3' : '#6b7280',
                }
            }
        },
        legend: { show: false },
        tooltip: { theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light' },
        colors: ['#2563eb', '#a21caf'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: document.documentElement.classList.contains('dark') ? 0.25 : 0.45,
                opacityTo: document.documentElement.classList.contains('dark') ? 0.01 : 0.05,
                stops: [0, 100]
            }
        },
        series: @js($data['series'])
    }
})">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 class="text-gray-700 dark:text-neutral-500">
                Visitors & Page Views
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
                <p class="text-xs text-gray-500 dark:text-neutral-400">Visitors</p>
                <p class="text-xl font-medium text-gray-800 dark:text-neutral-200 sm:text-2xl">
                    {{ numberShortner(array_sum($data['series'][0]['data'])) }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Page Views</p>
                <p class="text-xl font-medium text-gray-800 dark:text-neutral-200 sm:text-2xl">
                    {{ numberShortner(array_sum($data['series'][1]['data'])) }}
                </p>
            </div>
        </div>
    </div>

    <div class="min-h-[325px]" x-ref="chart"></div>
</div>
