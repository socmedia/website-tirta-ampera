<?php

namespace Modules\Panel\Livewire\Web\Content;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Livewire\WithFileUploads;
use Modules\Common\Models\Content;
use Modules\Common\Enums\InputType;
use Modules\Common\Enums\ContentType;
use Modules\Common\Services\ContentService;
use Modules\Panel\Http\Requests\Web\EditContentRequest;
use Modules\Panel\Http\Requests\Web\UpdateContentRequest;

class Edit extends Component
{
    use WithFileUploads, WithToast, FileService;

    /**
     * The service instance used for handling content-related logic.
     *
     * @var ContentService
     */
    protected ContentService $contentService;

    /**
     * The content being edited
     *
     * @var Content $content
     */
    public ?Content $content = null;

    /**
     * The form data for editing content.
     *
     * @var array
     */
    public array $form = [
        'page' => '',
        'section' => '',
        'key' => '',
        'type' => ContentType::CONTENT->value,
        'input_type' => InputType::INPUT_TEXT->value,
        'meta' => [],
        'name' => '',
        'value' => null,
    ];

    /**
     * The confirmation key for deleting content.
     *
     * @var string|null
     */
    public ?string $confirmation_key = null;

    /**
     * Mount the component and inject the ContentService.
     *
     * @param ContentService $contentService
     * @param Content $content
     * @return void
     */
    public function mount(ContentService $contentService, $content)
    {
        $this->contentService = $contentService;
        $this->initialize($content);
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the content service.
     *
     * @param ContentService $contentService The service for handling content operations
     * @return void
     */
    public function hydrate(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Initialize component data (form) for editing.
     *
     * @param Content $content
     * @return void
     */
    protected function initialize($content)
    {
        if ($content) {
            $this->content = $content;
            $this->form['page'] = $content->page ?? '';
            $this->form['section'] = $content->section ?? '';
            $this->form['key'] = $content->key ?? '';
            $this->form['type'] = $content->type;
            $this->form['input_type'] = $content->input_type ?? 'input:text';
            $this->form['meta'] = $content->meta ?? [];
            $this->form['name'] = $content->name ?? '';
            $this->form['value'] = $content->value ?? null;
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
        if ($property === 'input_type') {
            // Reset value and name
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
     * Handle the update of an existing content.
     *
     * @return void
     */
    public function handleSubmit()
    {
        // Validate form data using defined rules and custom attributes
        $request = new UpdateContentRequest($this->form, $this->content->id);

        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();
            $this->contentService->update($this->content->id, $data);
            $this->notifySuccess('Content updated successfully.');
        } catch (\Exception $e) {
            info($e);
            $this->notifyError($e);
        }
    }

    /**
     * Delete the current content.
     *
     * @return void
     */
    public function deleteContent()
    {
        try {
            if (!$this->content) {
                throw new Exception('No content to delete.');
            }

            // Validate confirmation key
            if (
                !$this->confirmation_key ||
                trim($this->confirmation_key) !== $this->content->key
            ) {
                throw new Exception('The confirmation key does not match the content key.');
            }

            $this->contentService->delete($this->content->id);
            $this->notifySuccess('Content deleted successfully.');
            // Optionally, redirect or emit event to parent
            return $this->redirect(route('panel.web.content.index'), true);
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

        // Ensure 'type' and 'input_type' have correct defaults if not set
        $data['type'] = $data['type'] ?: ContentType::CONTENT->value;
        $data['input_type'] = $data['input_type'] ?? InputType::INPUT_TEXT->value;

        return $data;
    }

    public function render()
    {
        return view('panel::livewire.web.content.edit', [
            'inputs' => InputType::cases()
        ]);
    }
}