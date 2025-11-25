<?php

namespace Modules\Panel\Livewire\Main\Category;

use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Common\Services\CategoryService;
use Exception;
use Modules\Common\Models\Category;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling category-related logic.
     *
     * @var CategoryService
     */
    protected CategoryService $categoryService;

    /**
     * The category being displayed
     *
     * @var array $category
     */
    public array $category;

    /**
     * The selected group filter
     *
     * @var string|null
     */
    public ?string $group = 'all';

    /**
     * The list of groups filter
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The selected status filter
     *
     * @var string
     */
    public string $status = 'all';

    /**
     * Permission string for creating categories.
     *
     * @var string
     */
    public string $createPermission;

    /**
     * Permission string for updating categories.
     *
     * @var string
     */
    public string $updatePermission;

    /**
     * Permission string for deleting categories.
     *
     * @var string
     */
    public string $deletePermission;

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
        'status',
    ];

    /**
     * Table columns definition for the category listing.
     *
     * @var array
     */
    public $columns = [
        [
            'name' => 'name',
            'label' => 'Name',
            'sortable' => true,
        ],
        [
            'name' => 'description',
            'label' => 'Description',
            'sortable' => false,
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'sortable' => true,
        ],
        [
            'name' => 'featured',
            'label' => 'Featured',
            'sortable' => true,
        ],
        [
            'name' => 'created_at',
            'label' => 'Created',
            'sortable' => true,
        ],
        [
            'name' => 'actions',
            'label' => 'Action',
            'sortable' => false,
        ],
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the category service, permissions, and initializes the group tabs.
     *
     * @param CategoryService $categoryService The service for handling category operations
     * @param string|null $group The group filter to initialize with
     * @param string $createPermission
     * @param string $updatePermission
     * @param string $deletePermission
     * @return void
     */
    public function mount(
        CategoryService $categoryService,
        ?string $group = null,
        string $createPermission = 'create-category',
        string $updatePermission = 'update-category',
        string $deletePermission = 'delete-category'
    ) {
        $this->sort = 'sort_order';
        $this->order = 'asc';
        $this->categoryService = $categoryService;

        $this->createPermission = $createPermission;
        $this->updatePermission = $updatePermission;
        $this->deletePermission = $deletePermission;

        if ($group) {
            $this->group = $group;
        }

        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the category service and group tabs.
     *
     * @param CategoryService $categoryService The service for handling category operations
     * @return void
     */
    public function hydrate(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->handleTabs();
    }

    /**
     * Show specific Category.
     */
    public function showCategory($id)
    {
        try {
            $category = $this->categoryService->findByIdWithSubcategories($id);
            $this->category = $category;
        } catch (Exception $exception) {
            $this->dismiss();
            $this->notifyError($exception);
        }
    }

    /**
     * Update the order of categories after drag and drop.
     *
     * @param array $orderedIds
     * @return void
     */
    public function updateOrder($orderedIds)
    {
        try {
            $this->categoryService->updateOrder($orderedIds);
            $this->notifySuccess('Category order updated successfully');

            if ($this->category) {
                $this->showCategory($this->category['id']);
            }
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset pagination when search or filters change.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function updated($property, $value)
    {
        if (!in_array($property, ['destroyId', 'checks', 'checkAll'])) {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of categories with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
            'group' => $this->group,
            'status' => $this->status,
        ];

        return $this->categoryService->listing($filters);
    }

    /**
     * Get the total count of categories for each group tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $this->categoryService->getTabs(groupFilter: $this->group);
    }

    /**
     * Handle single category deletion using CategoryService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->categoryService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('Category deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the category creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('category');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showCategory = false');
    }

    public function render()
    {
        return view('panel::livewire.main.category.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}
