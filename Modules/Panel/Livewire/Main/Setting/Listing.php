<?php

namespace Modules\Panel\Livewire\Main\Setting;

use App\Traits\WithTable;
use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\Common\Services\AppSettingService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast, WithFileUploads;

    /**
     * The service instance used for handling appsetting-related logic.
     *
     * @var AppSettingService
     */
    protected AppSettingService $settingService;

    /**
     * The appsetting being displayed
     *
     * @var array $appsetting
     */
    public array $appsetting;

    /**
     * The selected tab filter
     *
     * @var string|null
     */
    public ?string $tab = null;

    /**
     * The list of tabs filter
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The list of settings
     *
     * @var array
     */
    public array $settings = [];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * The component query string
     *
     * @var array
     */
    protected $queryString = [
        'search',
        'tab',
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the appsetting service and initializes the tabs.
     *
     * @param AppSettingService $settingService The service for handling appsetting operations
     * @return void
     */
    public function mount(AppSettingService $settingService)
    {
        $this->settingService = $settingService;
        $this->handleTabs();
        $this->handleListing();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the appsetting service and tabs.
     *
     * @param AppSettingService $settingService The service for handling appsetting operations
     * @return void
     */
    public function hydrate(AppSettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Save setting for a specific AppSetting using the AppSettingService.
     *
     * @param int|string $id
     * @param int $index
     * @return void
     */
    public function saveSetting($id, int $index)
    {
        try {
            $data = $this->settings[$index];
            // Use the service to update setting
            $this->settingService->update($id, $data);

            $this->notifySuccess('Setting updated successfully.');
            $this->handleListing();
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

        if ($property == 'tab') {
            $this->handleListing();
        }
    }

    /**
     * Handle the listing of appsettings with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
            'group' => $this->tab,
        ];

        return $this->settings = $this->settingService->listing($filters)->toArray();
    }

    /**
     * Get the total count of appsettings for each tab.
     *
     * @return array
     */
    public function handleTabs()
    {
        $this->tabs = $this->settingService->getTabs(exceptGroup: ['seo']);
        $this->tab = request()->get('tab', $this->tabs[0]['group'] ?? url()->livewireCurrent()->query['tab']);
        return $this->tabs;
    }

    public function render()
    {
        return view('panel::livewire.main.setting.listing');
    }
}
