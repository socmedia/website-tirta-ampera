<?php

namespace Modules\Panel\Livewire\Web\Page;

use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use App\Traits\WithThirdParty;
use Livewire\WithFileUploads;
use Modules\Common\Enums\ContentType;
use Modules\Common\Enums\InputType;
use Modules\Common\Services\ContentService;
use Modules\Panel\Http\Requests\Web\CreateContentRequest;

class Create extends Component
{
    use WithFileUploads, WithToast, FileService, WithThirdParty;

    /**
     * The service instance used for handling page-related logic.
     *
     * @var ContentService
     */
    protected ContentService $contentService;

    /**
     * The form data for creating a new static page.
     *
     * @var array
     */
    public array $form = [
        'page' => '',
        'section' => 'body',
        'key' => 'page_{page_name}',
        'type' => ContentType::STATIC_PAGE->value,
        'input_type' => InputType::EDITOR->value,
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
            // Reset value and name
            $this->form['name'] = '';
            $this->form['value'] = null;
        }

        if ($property === 'page') {
            $this->form['page'] = $key = str($value)->slug('_')->toString();
            $this->form['key'] =  "{$key}_{$this->form['section']}";
        }

        if ($property === 'section') {
            $this->form['section'] = str($value)->slug('_')->toString();
        }

        if ($property === 'key') {
            $this->form['key'] = str($value)->lower();
        }
    }

    /**
     * Handle the update event from the Editor component.
     *
     * @param string $markdown The new markdown value from the editor
     * @return void
     */
    public function updatedEditor(string $markdown): void
    {
        $this->form['value'] = $markdown;
    }

    /**
     * Handle the creation of a new static page.
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
            $this->notifySuccess('Static page created successfully.');

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
        $data['type'] = $data['type'] ?: ContentType::STATIC_PAGE->value;
        $data['input_type'] = $data['input_type'] ?? InputType::EDITOR->value;

        return $data;
    }

    public function render()
    {
        return view('panel::livewire.web.page.create', [
            'inputs' => InputType::cases(),
            'pages' => $this->contentService->getPages(),
        ]);
    }
}
