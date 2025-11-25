<?php

namespace Modules\Panel\Livewire\Web\Post;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Modules\Common\Models\Post;
use Modules\Common\Services\PostService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling post-related logic.
     *
     * @var PostService
     */
    protected PostService $postService;

    /**
     * The post being displayed
     *
     * @var Post $post
     */
    public Post $post;

    /**
     * The selected type filter
     *
     * @var string|null
     */
    public ?string $type = null;

    /**
     * The list of type tabs
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        self::TABLE_SORT_ORDER,
        self::CHANGE_PER_PAGE,
        'refresh' => '$refresh',
    ];

    /**
     * The component query string
     *
     * @var array
     */
    protected $queryString = [
        'search',
        'type',
    ];

    /**
     * Table columns definition for the post listing.
     *
     * @var array
     */
    public $columns = [
        [
            'name' => 'title',
            'label' => 'Title',
            'sortable' => true,
        ],
        [
            'name' => 'author_name',
            'label' => 'Author',
            'sortable' => false,
        ],
        [
            'name' => 'published_by_name',
            'label' => 'Published By',
            'sortable' => false,
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'sortable' => true,
        ],
        [
            'name' => 'created_at',
            'label' => 'Created',
            'sortable' => true,
        ],
        [
            'name' => 'actions',
            'label' => 'Actions',
            'sortable' => false,
        ],
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the post service and initializes the type tabs.
     *
     * @param PostService $postService The service for handling post operations
     * @return void
     */
    public function mount(PostService $postService)
    {
        $this->sort = 'created_at';
        $this->order = 'desc';

        $this->postService = $postService;
        $this->handleTabs();
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
     * Show specific post using the PostService.
     *
     * @param string|int $id
     * @return void
     */
    public function showPost($id)
    {
        try {
            $post = $this->postService->findById($id);

            $this->post = $post;
        } catch (Exception $exception) {
            $this->dismiss();
            $this->notifyError($exception);
        }
    }

    // Removed updateOrder method (drag and drop functionality)

    /**
     * Reset pagination when search or filters change.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (!in_array($property, ['destroyId', 'checks', 'checkAll', 'post', 'showPost'])) {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of posts with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search ?? null,
            'sort' => $this->sort ?? null,
            'order' => $this->order ?? null,
            'type' => $this->type,
            'per_page' => $this->perPage,
        ];

        return $this->postService->listing($filters, true);
    }

    /**
     * Get the total count of posts for each type tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $categories = $this->postService->getTabs();
        $this->type = request('type') ?: (isset($categories[0]['value']) ? $categories[0]['value'] : null);
    }

    /**
     * Handle bulk delete of selected posts using PostService.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new \Exception('Please select at least one post to delete');
            }

            $this->postService->bulkDelete($this->selectedIds);

            $this->notifySuccess('Selected posts deleted successfully');
        } catch (\Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single post deletion using PostService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->postService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('Post deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the post creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('post');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showDialog = false');
    }

    public function render()
    {
        return view('panel::livewire.web.post.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}