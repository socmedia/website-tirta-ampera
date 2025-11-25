<?php

namespace Modules\Panel\Livewire\Web\Slider;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Common\Models\Slider;
use Modules\Common\Enums\SliderType;
use Modules\Common\Services\SliderService;
use Modules\Panel\Http\Requests\Web\UpdateSliderRequest;

class Edit extends Component
{
    use WithToast, WithThirdParty;

    /**
     * @var SliderService
     */
    protected SliderService $sliderService;

    /**
     * @var Slider|null
     */
    public ?Slider $slider = null;

    /**
     * @var array
     */
    public array $form = [
        'old_desktop_media_path' => [],
        'desktop_media_path' => [],
        'type' => null,
        'status' => true,
        'heading' => '',
        'sub_heading' => '',
        'description' => '',
        'alt' => '',
        'button_text' => '',
        'button_url' => '',
    ];

    /**
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
     * @param Slider|null $slider
     * @return void
     */
    public function mount(SliderService $sliderService, $slider = null)
    {
        $this->sliderService = $sliderService;
        $this->sliderTypes = $this->getSliderTypes();

        if ($slider) {
            $this->find($slider->id);
        }
    }

    /**
     * Handle component hydration.
     *
     * @param SliderService $sliderService
     * @return void
     */
    public function hydrate(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    /**
     * Find and load a SLIDER by ID.
     *
     * @param int $id
     * @return void
     */
    public function find($id)
    {
        try {
            $slider = $this->sliderService->findById($id);

            if (!$slider) {
                throw new Exception('Slider not found.');
            }

            $this->slider = $slider;
            $this->form['old_desktop_media_path'][] = $slider->desktop_media_path;
            $this->form['type'] = $slider->type;
            $this->form['status'] = $slider->status;

            // Set non-translated single values
            $translation = $slider->translations->first();
            $meta = [];
            if (!empty($translation?->meta)) {
                $meta = is_array($translation->meta)
                    ? $translation->meta
                    : (json_decode($translation->meta, true) ?: []);
            }

            $this->form['heading'] = $translation?->heading ?? '';
            $this->form['sub_heading'] = $translation?->sub_heading ?? '';
            $this->form['description'] = $translation?->description ?? '';
            $this->form['alt'] = $translation?->alt ?? '';
            $this->form['button_text'] = $meta['button_text'] ?? '';
            $this->form['button_url'] = $meta['button_url'] ?? '';
        } catch (Exception $e) {
            $this->notifyError($e);
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
        // No-op for removed translation/multilang
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
     * Handle the update of an existing SLIDER.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $request = new UpdateSliderRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();

            $this->sliderService->update($this->slider->id, $data);

            $this->notifySuccess(__('Slider updated successfully.'));

            $slider =  $this->slider->refresh();
            $this->find($slider->id);
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

        // Remove desktop_media_path if null
        if (empty($data['desktop_media_path'])) {
            unset($data['desktop_media_path']);
        }

        // Prepare meta with button fields
        $meta = [
            'button_text' => $data['button_text'] ?? '',
            'button_url' => $data['button_url'] ?? '',
        ];

        // Set up translations as a single array for default locale (legacy stub)
        $data['translations'] = [
            [
                'heading' => $data['heading'] ?? '',
                'sub_heading' => $data['sub_heading'] ?? '',
                'description' => $data['description'] ?? '',
                'alt' => $data['alt'] ?? '',
                'meta' => $meta,
                'locale' => 'en', // fallback default/legacy single locale
            ]
        ];

        // Remove fields from main data (move to translation)
        unset(
            $data['heading'],
            $data['sub_heading'],
            $data['description'],
            $data['alt'],
            $data['button_text'],
            $data['button_url']
        );

        // Ensure type is set and valid
        $sliderTypeValues = array_column($this->sliderTypes, 'value');
        if (!isset($data['type']) || !$data['type'] || !in_array($data['type'], $sliderTypeValues, true)) {
            $data['type'] = $this->sliderTypes[0]['value'];
        }

        return $data;
    }

    public function render()
    {
        return view('panel::livewire.web.slider.edit');
    }
}
