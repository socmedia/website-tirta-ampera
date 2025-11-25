<?php

namespace Modules\Panel\Livewire\Dashboard\Chart;

use Carbon\Carbon;
use Livewire\Component;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;

class Visitor extends Component
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
     * Fetch visitors and page views by date for the selected date range.
     * Returns two arrays: visitors and pageViews, each indexed by date.
     *
     * @return array
     */
    protected function fetchVisitorsAndPageViewsByDate()
    {
        try {
            $start = $this->dateRange['start'] ?? Carbon::now()->subDays(6)->toDateString();
            $end = $this->dateRange['end'] ?? Carbon::now()->toDateString();

            $period = Period::create(
                Carbon::parse($start),
                Carbon::parse($end)
            );

            $metrics = chartMetrics($this->dateRange);

            $data = Analytics::fetchTotalVisitorsAndPageViews($period);

            // Prepare daily data
            $dailyVisitors = [];
            $dailyPageViews = [];
            foreach ($data as $row) {
                $date = $row['date']->format('Y-m-d');
                $dailyVisitors[$date] = $row['activeUsers'] ?? 0;
                $dailyPageViews[$date] = $row['screenPageViews'] ?? 0;
            }

            // Prepare grouped data (e.g., by month, week, etc. according to $metrics)
            $groupedVisitors = [];
            $groupedPageViews = [];

            foreach ($metrics as $label => $range) {
                $rangeStart = $range['start'];
                $rangeEnd = $range['end'];

                // Sum visitors and page views in this range
                $visitorSum = 0;
                $pageViewSum = 0;
                $periodRange = Carbon::parse($rangeStart)->daysUntil(Carbon::parse($rangeEnd)->addDay());
                foreach ($periodRange as $date) {
                    $dateStr = $date->format('Y-m-d');
                    $visitorSum += $dailyVisitors[$dateStr] ?? 0;
                    $pageViewSum += $dailyPageViews[$dateStr] ?? 0;
                }
                $groupedVisitors[$label] = $visitorSum;
                $groupedPageViews[$label] = $pageViewSum;
            }

            // Prepare data for chart.js/apexcharts style output
            $categories = array_keys($groupedVisitors);

            $series = [
                [
                    'name' => 'Visitors',
                    'data' => array_values($groupedVisitors),
                ],
                [
                    'name' => 'Page Views',
                    'data' => array_values($groupedPageViews),
                ],
            ];

            return [
                'series' => $series,
                'categories' => $categories,
            ];
        } catch (\Throwable $e) {
            // Optionally log the error or handle it as needed
            // logger($e->getMessage());
            return [
                'series' => [
                    [
                        'name' => 'Visitors',
                        'data' => [],
                    ],
                    [
                        'name' => 'Page Views',
                        'data' => [],
                    ],
                ],
                'categories' => [],
            ];
        }
    }

    public function render()
    {
        return view('panel::livewire.dashboard.chart.visitor', [
            'data' => $this->fetchVisitorsAndPageViewsByDate(),
        ]);
    }
}
