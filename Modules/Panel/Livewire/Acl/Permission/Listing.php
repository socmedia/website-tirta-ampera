<?php

namespace Modules\Panel\Livewire\Acl\Permission;

use Livewire\Component;
use App\Traits\WithTable;
use Livewire\WithPagination;
use App\Traits\WithToast;
use Modules\Core\Services\PermissionService;
use Modules\Core\App\Enums\Guards;
use Exception;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The selected guard filter
     *
     * @var string|null
     */
    public ?string $guard = 'all';

    /**
     * The list of guards filter
     *
     * @var array
     */
    public array $tabs = [];

    /**
     * The service instance used for handling permission-related logic.
     *
     * @var PermissionService
     */
    protected PermissionService $permissionService;

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
        'guard',
    ];

    /**
     * Table columns definition for the permission listing.
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
            'name' => 'guard_name',
            'label' => 'Guard',
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
     * It sets up the permission service and initializes the guard tabs.
     *
     * @param PermissionService $permissionService The service for handling permission operations
     * @return void
     */
    public function mount(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the permission service and guard tabs.
     *
     * @param PermissionService $permissionService The service for handling permission operations
     * @return void
     */
    public function hydrate(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->handleTabs();
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
        if ($property !== 'destroyId' && $property !== 'checks' && $property !== 'checkAll') {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of permissions with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $this->handleTabs();

        $request = [
            'keyword' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
            'guard_name' => $this->guard
        ];

        return $this->permissionService->paginatedListing($request, $this->perPage);
    }

    /**
     * Get the total count of permissions for each guard tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $this->permissionService->getGuardTabs();
    }

    /**
     * Handle bulk delete of selected permissions.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new Exception('Please select at least one permission to delete');
            }

            foreach ($this->selectedIds as $id) {
                $this->permissionService->delete($id);
            }

            $this->notifySuccess('Selected permissions deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single permission deletion.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->permissionService->delete($this->destroyId);
            $this->destroyId = null;

            $this->notifySuccess('Permission deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle editing a permission.
     *
     * @param int $id
     * @return void
     */
    public function editPermission(int $id)
    {
        $this->dispatch('find', id: $id)->to('panel::acl.permission.edit');
    }

    public function render()
    {
        return view('panel::livewire.acl.permission.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}
