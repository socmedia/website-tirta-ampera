<?php

namespace Modules\Panel\Livewire\Web\Post;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Common\Models\Post;
use Modules\Common\Enums\PostType;
use Modules\Common\Services\PostService;
use Modules\Common\Services\CategoryService;
use Modules\Panel\Http\Requests\Web\UpdatePostRequest;

class Edit extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling post logic.
     *
     * @var PostService
     */
    protected PostService $postService;

    /**
     * The post being edited.
     *
     * @var Post|null
     */
    public ?Post $post = null;

    /**
     * Form data for post editing.
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'category_id' => null,
        'type' => null,
        'status' => false,
        'thumbnail' => null,
        'old_thumbnail' => null,
        'content' => '',
        'tags' => '',
        'title' => '',
        'slug' => '',
        'subject' => '',
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
        self::UPDATED_DROPZONE,
        self::UPDATED_EDITOR,
    ];

    /**
     * Mount the component and inject the PostService.
     *
     * @param PostService $postService
     * @param Post|null $post
     * @return void
     */
    public function mount(PostService $postService, $post = null)
    {
        $this->postService = $postService;
        $this->postTypes = $this->getPostTypes();

        if ($post) {
            $this->find($post->id);
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
     * Find and load a post by ID.
     *
     * @param int $id
     * @return void
     */
    public function find($id)
    {
        try {
            $post = $this->postService->findById($id);

            if (!$post) {
                throw new Exception('Post not found.');
            }

            $this->post = $post;
            $this->form['category_id'] = $post->category_id;
            $this->form['type'] = $post->type;
            $this->form['status'] = $post->published_at ? true : false;
            $this->form['thumbnail'] = null;
            $this->form['old_thumbnail'] = $post->thumbnail_url;
            $this->form['tags'] = $post->tags;
            $this->form['title'] = $post->title ?? '';
            $this->form['slug'] = $post->slug ?? '';
            $this->form['subject'] = $post->subject ?? '';
            $this->form['content'] = $post->content ?? '';
        } catch (Exception $e) {
            $this->notifyError($e);
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
        $this->form['thumbnail'] = $value;
    }

    /**
     * Handle the update event from the Editor component.
     *
     * @param string $markdown The new markdown value from the editor
     * @param string|null $id The id of the editor (optional, for multi-locale/field support)
     * @param string|null $form The form data (optional, for explicit updates)
     * @return void
     */
    public function updatedEditor(string $markdown, ?string $id = null, ?string $form = null): void
    {
        // Only one content field - just set it
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
            $slug = slug($value);
            $this->form['slug'] = $slug;
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
     * Handle form submission and update post.
     *
     * @return void
     */
    public function handleSubmit()
    {
        $request = new UpdatePostRequest();
        $this->validate(
            rules: $request->rules(),
            attributes: $request->attributes()
        );

        try {
            $data = $this->prepareData();

            $this->postService->update($this->post->id, $data);

            $this->notifySuccess(__('Post updated successfully.'));

            $post = $this->post->refresh();
            $this->find($post->id);
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

        $postFillable = ['category_id', 'status', 'type', 'thumbnail', 'old_thumbnail', 'content', 'tags', 'title', 'slug', 'subject'];
        $filteredData = array_intersect_key($data, array_flip($postFillable));

        if (!empty($this->postTypes)) {
            $validTypes = array_column($this->postTypes, 'value');
            if (empty($filteredData['type']) || !in_array($filteredData['type'], $validTypes, true)) {
                $filteredData['type'] = $this->postTypes[0]['value'];
            }
        }

        return $filteredData;
    }

    public function render()
    {
        return view('panel::livewire.web.post.edit', [
            'categories' => (new CategoryService)->getCategoriesByGroup('posts'),
        ]);
    }
}
