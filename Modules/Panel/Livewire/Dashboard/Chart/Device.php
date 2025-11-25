<?php

namespace Modules\Panel\Livewire\Dashboard\Chart;

use Livewire\Component;
use Carbon\Carbon;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;

class Device extends Component
{
    /**
     * The selected date range for the chart.
     *
     * @var array
     */
    public $dateRange = [
        'start' => null,
        'end' => null,
    ];

    /**
     * The event listeners for the Livewire component.
     *
     * @var array
     */
    protected $listeners = [
        'updatedDates'
    ];

    /**
     * Initialize the component with a default or provided date range.
     *
     * @param array|null $dateRange
     * @return void
     */
    public function mount(?array $dateRange = [])
    {
        if (!empty($dateRange) && isset($dateRange['start'], $dateRange['end'])) {
            $this->dateRange = $dateRange;
        }
    }

    /**
     * Handle updates from the parent dashboard's date range picker.
     *
     * @param array $value
     * @return void
     */
    public function updatedDates($value)
    {
        $this->dateRange = $value;
    }

    /**
     * Fetch the top operating systems for the selected date range.
     *
     * @return array
     */
    protected function fetchTopOperatingSystems()
    {
        try {
            $start = $this->dateRange['start'] ?? Carbon::now()->subDays(6)->toDateString();
            $end = $this->dateRange['end'] ?? Carbon::now()->toDateString();

            $period = Period::create(
                Carbon::parse($start),
                Carbon::parse($end)
            );

            // Fetch top operating systems from Google Analytics
            $osData = Analytics::fetchTopOperatingSystems($period, 5);

            // Prepare data for chart
            $labels = [];
            $data = [];
            foreach ($osData as $row) {
                $labels[] = $row['operatingSystem'] ?? 'Unknown';
                $data[] = $row['screenPageViews'] ?? 0;
            }

            return [
                'labels' => $labels,
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            // Optionally log the error or handle it as needed
            // logger($e->getMessage());
            return [
                'labels' => [],
                'data' => [],
            ];
        }
    }

    public function render()
    {
        return view('panel::livewire.dashboard.chart.device', [
            'data' => $this->fetchTopOperatingSystems(),
        ]);
    }
}
