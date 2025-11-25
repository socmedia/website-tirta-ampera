<?php

namespace Modules\Panel\Livewire\Main\Setting;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Exception;
use Livewire\WithFileUploads;
use Modules\Common\Enums\SettingType;
use Modules\Common\Models\AppSetting;
use Modules\Common\Services\AppSettingService;
use Modules\Panel\Http\Requests\Main\EditSettingRequest;

class Edit extends Component
{
    use WithFileUploads, WithToast, FileService;

    /**
     * The service instance used for handling appsetting-related logic.
     *
     * @var AppSettingService
     */
    protected AppSettingService $settingService;

    /**
     * The appsetting being edited
     *
     * @var AppSetting $setting
     */
    public ?AppSetting $setting = null;

    /**
     * The form data for editing an appsetting.
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
     * The confirmation key for deleting a setting.
     *
     * @var string|null
     */
    public ?string $confirmation_key = null;

    /**
     * Mount the component and inject the AppSettingService.
     *
     * @param AppSettingService $settingService
     * @param AppSetting $setting
     * @return void
     */
    public function mount(AppSettingService $settingService, $setting)
    {
        $this->settingService = $settingService;
        $this->initialize($setting);
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the appsetting service.
     *
     * @param AppSettingService $settingService The service for handling appsetting operations
     * @return void
     */
    public function hydrate(AppSettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Initialize component data (groups, form) for editing.
     *
     * @param AppSetting $setting
     * @return void
     */
    protected function initialize($setting)
    {
        $this->groups = $this->settingService->getTabs();

        if ($setting) {
            $this->setting = $setting;
            $this->form['group'] = $setting->group;
            $this->form['key'] = $setting->key;
            $this->form['type'] = $setting->type;
            $this->form['meta'] = $setting->meta ?? [];
            $this->form['name'] = $setting->name;
            $this->form['value'] = $setting->value;
        }
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
            // Reset value and name
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
     * Handle the update of an existing appsetting.
     *
     * @return void
     */
    public function handleSubmit()
    {
        // Validate form data using defined rules and custom attributes
        $request = new EditSettingRequest($this->form, $this->setting->id);

        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->settingService->update($this->setting->id, $data);
            $this->notifySuccess('Setting updated successfully.');
        } catch (\Exception $e) {
            info($e);
            $this->notifyError($e);
        }
    }

    /**
     * Delete the current setting.
     *
     * @return void
     */
    public function deleteSetting()
    {
        try {
            if (!$this->setting) {
                throw new Exception('No setting to delete.');
            }

            // Validate confirmation key
            if (
                !$this->confirmation_key ||
                trim($this->confirmation_key) !== $this->setting->key
            ) {
                throw new Exception('The confirmation key does not match the setting key.');
            }

            $this->settingService->delete($this->setting->id);
            $this->notifySuccess('Setting deleted successfully.');
            // Optionally, redirect or emit event to parent
            return $this->redirect(route('panel.main.setting.index'), true);
        } catch (\Exception $e) {
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
        return view('panel::livewire.main.setting.edit', [
            'types' => SettingType::cases()
        ]);
    }
}
