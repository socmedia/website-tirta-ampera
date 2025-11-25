<?php

namespace Modules\Panel\Livewire\Acl\Role;

use Livewire\Component;
use App\Traits\WithTable;
use Livewire\WithPagination;
use App\Traits\WithToast;
use Modules\Core\Models\Role;
use Modules\Core\App\Enums\Guards;
use Exception;
use Modules\Core\Services\RoleService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling role-related logic.
     *
     * @var RoleService
     */
    protected RoleService $roleService;

    /**
     * The role being displayed
     *
     * @var array $role
     */
    public array $role;

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
     * Show specific Role.
     */
    public function showRole($id)
    {
        try {
            $role =  Role::with('permissions')->findOrFail($id);

            $role->guard_badge = $role->guardBadge();

            $role->permissions->each(function ($permission) {
                $permission->badge = $permission->readableNameBadge();
            });

            $this->role = $role->toArray();
        } catch (Exception $exception) {
            $this->dismiss();
            $this->notifyError($exception);
        }
    }

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
     * Table columns definition for the role listing.
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
            'name' => 'permissions_count',
            'label' => 'Total Permission',
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
     * It sets up the role service and initializes the guard tabs.
     *
     * @param RoleService $roleService The service for handling role operations
     * @return void
     */
    public function mount(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the role service and guard tabs.
     *
     * @param RoleService $roleService The service for handling role operations
     * @return void
     */
    public function hydrate(RoleService $roleService)
    {
        $this->roleService = $roleService;
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
        if (!in_array($property, ['destroyId', 'checks', 'checkAll'])) {
            $this->resetPage();
        }
    }

    /**
     * Handle the listing of roles with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
            'guard_name' => $this->guard,
        ];

        return $this->roleService
            ->paginatedListing($filters, $this->perPage);
    }

    /**
     * Get the total count of roles for each guard tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $this->roleService->getGuardTabs();
    }

    /**
     * Handle bulk delete of selected roles.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new Exception('Please select at least one role to delete');
            }

            Role::whereIn('id', $this->selectedIds)->delete();

            $this->notifySuccess('Selected roles deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single role deletion using RoleService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->roleService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('Role deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the role creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('role');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showDialog = false');
    }

    public function render()
    {
        return view('panel::livewire.acl.role.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}
