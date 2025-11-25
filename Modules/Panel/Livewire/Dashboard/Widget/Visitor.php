<?php

namespace Modules\Panel\Livewire\Dashboard\Widget;

use Carbon\Carbon;
use Livewire\Component;
use Spatie\Analytics\Period;
use App\Traits\WithThirdParty;
use App\Traits\WithToast;
use Spatie\Analytics\Facades\Analytics;

class Visitor extends Component
{
    use WithThirdParty, WithToast;

    /**
     * The selected date range for the dashboard.
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
     * Initialize the component with a default or provided date range and fetch counts.
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
     * Get the total visitors from Google Analytics using spatie/laravel-analytics.
     *
     * @return int
     */
    protected function updateCounts()
    {
        try {
            // If date range is not set, use last 7 days as default
            $start = $this->dateRange['start'] ?? Carbon::now()->subDays(6)->toDateString();
            $end = $this->dateRange['end'] ?? Carbon::now()->toDateString();

            $period = Period::create(
                Carbon::parse($start),
                Carbon::parse($end)
            );

            // Get total users (visitors) for the period
            $data = Analytics::fetchTotalVisitorsAndPageViews($period);

            return $data->sum('activeUsers');
        } catch (\Throwable $e) {
            // Optionally log the error or handle it as needed
            // logger($e->getMessage());
            return 0;
        }
    }

    public function render()
    {
        return view('panel::livewire.dashboard.widget.visitor', [
            'visitorCount' => $this->updateCounts()
        ]);
    }
}
