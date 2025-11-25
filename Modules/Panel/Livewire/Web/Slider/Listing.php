<?php

namespace Modules\Panel\Livewire\Web\Slider;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Modules\Common\Services\SliderService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling slider-related logic.
     *
     * @var SliderService
     */
    protected SliderService $sliderService;

    /**
     * The slider being displayed
     *
     * @var array $slider
     */
    public array $slider = [];

    /**
     * The selected type filter
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * The list of type tabs
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        self::TABLE_SORT_ORDER,
        self::CHANGE_PER_PAGE,
        'refresh' => '$refresh',
    ];

    /**
     * The component query string
     *
     * @var array
     */
    protected $queryString = [
        'search',
        'type',
    ];

    /**
     * Table columns definition for the slider listing.
     *
     * @var array
     */
    public $columns = [
        [
            'name' => 'heading',
            'label' => 'Heading',
            'sortable' => true,
        ],
        [
            'name' => 'meta',
            'label' => 'Link',
            'sortable' => false,
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'sortable' => true,
        ],
        [
            'name' => 'created_at',
            'label' => 'Created',
            'sortable' => true,
        ],
        [
            'name' => 'actions',
            'label' => 'Actions',
            'sortable' => false,
        ],
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the slider service and initializes the type tabs.
     *
     * @param SliderService $sliderService The service for handling slider operations
     * @return void
     */
    public function mount(SliderService $sliderService)
    {
        $this->sort = 'sort_order';
        $this->order = 'asc';

        $this->sliderService = $sliderService;
        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the slider service and type tabs.
     *
     * @param SliderService $sliderService The service for handling slider operations
     * @return void
     */
    public function hydrate(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
        $this->handleTabs();
    }

    /**
     * Show specific slider using the SliderService.
     *
     * @param string|int $id
     * @return void
     */
    public function showSlider($id)
    {
        try {
            $slider = $this->sliderService->findById($id);

            $this->slider = $slider->toArray();
        } catch (Exception $exception) {
            $this->dismiss();
            $this->notifyError($exception);
        }
    }

    /**
     * Update the order of sliders after drag and drop.
     *
     * @param array $orderedIds
     * @return void
     */
    public function updateOrder($orderedIds)
    {
        try {
            $this->sliderService->updateOrder($orderedIds);
            $this->notifySuccess('Slider order updated successfully');

            if (!empty($this->slider) && isset($this->slider['id'])) {
                $this->showSlider($this->slider['id']);
            }
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset pagination when search or filters change.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (!in_array($property, ['destroyId', 'checks', 'checkAll'])) {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of sliders with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search ?? null,
            'sort' => $this->sort ?? null,
            'order' => $this->order ?? null,
            'type' => $this->type,
        ];

        return $this->sliderService->listing($filters);
    }

    /**
     * Get the total count of sliders for each type tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $types = $this->sliderService->getTabs();
        $this->type = request('type') ?: (isset($types[0]['value']) ? $types[0]['value'] : null);
    }

    /**
     * Handle bulk delete of selected sliders using SliderService.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new \Exception('Please select at least one slider to delete');
            }

            $this->sliderService->bulkDelete($this->selectedIds);

            $this->notifySuccess('Selected sliders deleted successfully');
        } catch (\Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single slider deletion using SliderService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->sliderService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('Slider deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the slider creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('slider');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showDialog = false');
    }

    public function render()
    {
        return view('panel::livewire.web.slider.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}
