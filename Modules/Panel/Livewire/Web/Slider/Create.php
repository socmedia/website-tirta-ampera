<?php

namespace Modules\Panel\Livewire\Web\Slider;

use Exception;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Common\Enums\SliderType;
use Modules\Common\Services\SliderService;
use Modules\Panel\Http\Requests\Web\CreateSliderRequest;

class Create extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling slider logic.
     *
     * @var SliderService
     */
    protected SliderService $sliderService;

    /**
     * Form data for slider creation
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'desktop_media_path' => null,
        'status' => true,
        'type' => null,
        'heading' => '',
        'sub_heading' => '',
        'button_text' => '',
        'button_url' => '',
        'description' => '',
        'alt' => '',
    ];

    /**
     * Slider types data.
     *
     * @var array
     */
    public array $sliderTypes = [];

    /**
     * The event listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        self::UPDATED_DROPZONE
    ];

    /**
     * Mount the component and inject the SliderService.
     *
     * @param SliderService $sliderService
     * @return void
     */
    public function mount(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;

        // Initialize slider types from SliderType enum
        $this->sliderTypes = $this->getSliderTypes();

        // Set default slider type if not set
        if (!$this->form['type']) {
            $this->form['type'] = $this->sliderTypes[0]['value'];
        }
    }

    /**
     * Handle the update event from the Dropzone component.
     *
     * @param array $value The new value from Dropzone (e.g., file path or array)
     * @return void
     */
    public function updatedDropzone(array $value): void
    {
        $this->form['desktop_media_path'] = $value;
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the slider service.
     *
     * @param SliderService $sliderService The service for handling slider operations
     * @return void
     */
    public function hydrate(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
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
        // No translation or multi-language features required
    }

    /**
     * Get the available slider types as an array of value, label, and icon.
     *
     * @return array
     */
    protected function getSliderTypes(): array
    {
        return array_map(function ($case) {
            return $case->info();
        }, SliderType::cases());
    }

    /**
     * Handle form submission and create slider.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $request = new CreateSliderRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->sliderService->create($data);

            $this->reset('form');

            // Reset type to default after creation
            $this->form['type'] = $this->sliderTypes[0]['value'];

            $this->notifySuccess(__('slider created successfully'));
            $this->dispatch('refresh');

            $this->dismiss();
        } catch (Exception $e) {
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

        // Prepare meta with button fields
        $meta = [];
        if (!empty($data['button_text'])) {
            $meta['button_text'] = $data['button_text'];
        }
        if (!empty($data['button_url'])) {
            $meta['button_url'] = $data['button_url'];
        }
        $data['meta'] = $meta;

        // Remove meta fields from top level
        unset($data['button_text'], $data['button_url']);

        // Ensure type is set and valid
        $sliderTypeValues = array_column($this->sliderTypes, 'value');
        if (!isset($data['type']) || !$data['type'] || !in_array($data['type'], $sliderTypeValues, true)) {
            $data['type'] = $this->sliderTypes[0]['value'];
        }

        return $data;
    }

    /**
     * Reset the form and close the slider creation dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('form');

        // Reset type to default after dismiss
        $this->form['type'] = $this->sliderTypes[0]['value'];
    }

    public function render()
    {
        return view('panel::livewire.web.slider.create', [
            'sliderTypes' => $this->sliderTypes,
        ]);
    }
}
