<?php

namespace Modules\Panel\Livewire\Dashboard\Widget;

use App\Traits\WithThirdParty;
use Livewire\Component;
use Carbon\Carbon;
use Modules\Common\Models\ContactMessage as ContactMessageModel;

class ContactMessage extends Component
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
     * Update the contact message and unseen counts based on the current date range.
     */
    protected function updateCounts()
    {
        return ContactMessageModel::query()
            ->unseen()
            ->whereBetween('created_at', [
                $this->dateRange['start'] . ' 00:00:00',
                $this->dateRange['end'] . ' 23:59:59'
            ])->count();
    }

    public function render()
    {
        return view('panel::livewire.dashboard.widget.contact-message', [
            'unseenCount' => $this->updateCounts()
        ]);
    }
}
