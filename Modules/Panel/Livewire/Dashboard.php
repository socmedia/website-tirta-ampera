<?php

namespace Modules\Panel\Livewire;

use App\Traits\WithThirdParty;
use Livewire\Component;

class Dashboard extends Component
{
    use WithThirdParty;

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
        self::UPDATED_DATERANGEPICKER,
    ];

    /**
     * Mount the component and set the default date range.
     *
     * @return void
     */
    public function mount()
    {
        $this->dateRange = [
            'start' => now()->startOfYear()->format('Y-m-d'),
            'end' => now()->endOfYear()->format('Y-m-d'),
        ];
    }

    /**
     * Handle updates from the DaterangePicker component.
     *
     * @param mixed $value
     * @return void
     */
    public function updatedDaterangePicker($value)
    {
        $this->dateRange = $value;

        $this->dispatch('updatedDates', $value);
    }

    public function render()
    {
        return view('panel::livewire.dashboard');
    }
}
