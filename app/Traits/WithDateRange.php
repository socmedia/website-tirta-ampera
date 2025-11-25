<?php

namespace App\Traits;

trait WithDateRange
{
    /**
     * Date range filter values.
     * 'start' and 'end' should be date strings (Y-m-d).
     *
     * @var array
     */
    public array $dates = [
        'start' => null,
        'end' => null,
    ];

    /**
     * Set the default date range to the current month.
     *
     * @return void
     */
    public function initializeDateRange()
    {
        $this->dates['start'] = now()->startOfMonth()->toDateString();
        $this->dates['end'] = now()->endOfMonth()->toDateString();
    }
}
