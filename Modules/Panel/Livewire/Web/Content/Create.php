<?php

namespace Modules\Panel\Livewire\Web\Content;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Livewire\WithFileUploads;
use Modules\Common\Enums\ContentType;
use Modules\Common\Enums\InputType;
use Modules\Common\Services\ContentService;
use Modules\Panel\Http\Requests\Web\CreateContentRequest;

class Create extends Component
{
    use WithFileUploads, WithToast, FileService;

    /**
     * The service instance used for handling content-related logic.
     *
     * @var ContentService
     */
    protected ContentService $contentService;

    /**
     * The form data for creating a new content.
     *
     * @var array
     */
    public array $form = [
        'page' => '',
        'section' => '',
        'key' => '{page}_{section}_{name}',
        'type' => ContentType::CONTENT->value,
        'input_type' => InputType::INPUT_TEXT->value,
        'meta' => [],
        'name' => '',
        'value' => null,
    ];

    /**
     * Mount the component and inject the ContentService.
     *
     * @param ContentService $contentService
     * @return void
     */
    public function mount(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the content service.
     *
     * @param ContentService $contentService
     * @return void
     */
    public function hydrate(ContentService $contentService)
    {
        $this->contentService = $contentService;
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
            $this->form['name'] = '';
            $this->form['value'] = null;
        }

        if ($property === 'page') {
            $this->form['page'] = str($value)->slug('_')->toString();
        }

        if ($property === 'section') {
            $this->form['section'] = str($value)->slug('_')->toString();
        }

        if ($property === 'key') {
            $this->form['key'] = str($value)->lower();
        }
    }

    /**
     * Handle the creation of a new content.
     *
     * @return void
     */
    public function handleSubmit()
    {
        // Validate form data using defined rules and custom attributes
        $request = new CreateContentRequest;

        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->contentService->create($data);
            $this->notifySuccess('Content created successfully.');

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

        // Ensure 'type' and 'input_type' have correct defaults if not set
        $data['type'] = $data['type'] ?: ContentType::CONTENT->value;
        $data['input_type'] = $data['input_type'] ?? InputType::INPUT_TEXT->value;

        return $data;
    }

    public function render()
    {
        return view('panel::livewire.web.content.create', [
            'inputs' => InputType::cases(),
            'pages' => $this->contentService->getPages(),
            'sections' => $this->contentService->getSections($this->form['page']),
        ]);
    }
}
