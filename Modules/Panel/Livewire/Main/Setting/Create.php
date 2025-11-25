<?php

namespace Modules\Panel\Livewire\Main\Setting;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Livewire\WithFileUploads;
use Modules\Common\Enums\SettingType;
use Modules\Common\Services\AppSettingService;
use Modules\Panel\Http\Requests\Main\CreateSettingRequest;

class Create extends Component
{
    use WithFileUploads, WithToast, FileService;

    /**
     * The service instance used for handling appsetting-related logic.
     *
     * @var AppSettingService
     */
    protected AppSettingService $settingService;

    /**
     * The form data for creating a new appsetting.
     *
     * @var array
     */
    public array $form = [
        'group' => '',
        'key' => '',
        'type' => '',
        'meta' => [],
        'name' => '',
        'value' => null,
    ];

    /**
     * The list of available groups/tabs for settings.
     *
     * @var array
     */
    public array $groups = [];

    /**
     * Mount the component and inject the AppSettingService.
     *
     * @param AppSettingService $settingService
     * @return void
     */
    public function mount(AppSettingService $settingService)
    {
        $this->settingService = $settingService;
        $this->groups = $this->settingService->getTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the appsetting service and tab tabs.
     *
     * @param AppSettingService $settingService The service for handling appsetting operations
     * @return void
     */
    public function hydrate(AppSettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Livewire hook: called when any property on $form is updated.
     *
     * @param mixed $value
     * @param string $property
     * @return void
     */
    public function updatedForm($value, $property)
    {
        if ($property === 'type') {
            // Reset name and value
            $this->form['name'] = '';
            $this->form['value'] = null;
        }

        if ($property === 'group') {
            $this->form['group'] = str($value)->slug('_')->toString();
        }

        if ($property === 'key') {
            $this->form['key'] = str($value)->slug('_')->toString();
        }
    }

    /**
     * Handle the creation of a new appsetting.
     *
     * @return void
     */
    public function handleSubmit()
    {
        // Validate form data using defined rules and custom attributes
        $request = new CreateSettingRequest;

        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->settingService->create($data);
            $this->notifySuccess('Setting created successfully.');

            $this->reset('form');
        } catch (\Exception $e) {
            info($e);
            $this->notifyError($e);
        }
    }

    /**
     * Prepare form data for submission
     *
     * @return array
     */
    protected function prepareData(): array
    {
        $data = $this->form;

        // Ensure meta is a JSON string if it's an array
        if (isset($data['meta']) && is_array($data['meta'])) {
            $data['meta'] = json_encode($data['meta']);
        }

        return $data;
    }

    public function render()
    {
        return view('panel::livewire.main.setting.create', [
            'types' => SettingType::cases()
        ]);
    }
}
