<?php

namespace Modules\Panel\Livewire\Web\Post;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Common\Enums\PostType;
use Modules\Common\Services\PostService;
use Modules\Common\Services\CategoryService;
use Modules\Panel\Http\Requests\Web\CreatePostRequest;

class Create extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling post logic.
     *
     * @var PostService
     */
    protected PostService $postService;

    /**
     * Form data for post creation
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'category_id' => null,
        'type' => null,
        'status' => false,
        'thumbnail' => null,
        'title' => '',
        'slug' => '',
        'subject' => '',
        'content' => '',
        'tags' => '',
    ];

    /**
     * Post types data.
     *
     * @var array
     */
    public array $postTypes = [];

    /**
     * The event listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        self::UPDATED_TAGIFY,
        self::UPDATED_DROPZONE,
        self::UPDATED_EDITOR,
    ];

    /**
     * Mount the component and inject the PostService.
     *
     * @param PostService $postService
     * @return void
     */
    public function mount(PostService $postService)
    {
        $this->postService = $postService;
        $this->postTypes = $this->getPostTypes();

        // Set default post type if available
        if (!empty($this->postTypes) && empty($this->form['type'])) {
            $this->form['type'] = $this->postTypes[0]['value'];
        }
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the post service.
     *
     * @param PostService $postService The service for handling post operations
     * @return void
     */
    public function hydrate(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Handle the update event from the Dropzone component.
     *
     * @param array $value The new value from Dropzone (e.g., file path or array)
     * @return void
     */
    public function updatedDropzone(array $value): void
    {
        $this->form['thumbnail'] = $value;
    }

    /**
     * Handle the update event from the TagifyTag component.
     *
     * @param array $tags The new tags array from Tagify
     * @return void
     */
    public function handleTagifyUpdate(array $tags): void
    {
        $this->form['tags'] = implode(',', $tags);
    }

    /**
     * Handle the update event from the Editor component.
     *
     * @param string $markdown The new markdown value from the editor
     * @param string|null $id The id of the editor (optional)
     * @param string|null $form The form data (optional, for explicit updates)
     * @return void
     */
    public function updatedEditor(string $markdown, ?string $id = null, ?string $form = null): void
    {
        // When not using translations, simply store markdown in content field
        $this->form['content'] = $markdown;
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
        if ($property === 'title' && !empty($value)) {
            $this->form['slug'] = str($value)->slug()->toString();
        }
    }

    /**
     * Get the available post types as an array of value, label, and icon.
     * If you don't have post types, return an empty array.
     *
     * @return array
     */
    protected function getPostTypes(): array
    {
        return array_map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        }, PostType::cases());
    }

    /**
     * Handle form submission and create post.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $request = new CreatePostRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();

            $this->postService->create($data);

            $this->dismiss();
            $this->notifySuccess(__('Post created successfully'));
            $this->resetThirdParty();
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
        $postFillable = ['category_id', 'status', 'type', 'thumbnail', 'title', 'slug', 'subject', 'content', 'tags'];
        $filteredData = array_intersect_key($data, array_flip($postFillable));

        if (!empty($this->postTypes)) {
            $validTypes = array_column($this->postTypes, 'value');
            if (empty($filteredData['type']) || !in_array($filteredData['type'], $validTypes, true)) {
                $filteredData['type'] = $this->postTypes[0]['value'];
            }
        }

        return $filteredData;
    }

    /**
     * Reset the form and close the post creation dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('form');
        if (!empty($this->postTypes)) {
            $this->form['type'] = $this->postTypes[0]['value'];
        }
    }

    public function render()
    {
        return view('panel::livewire.web.post.create', [
            'categories' => (new CategoryService)->getCategoriesByGroup('posts'),
        ]);
    }
}
