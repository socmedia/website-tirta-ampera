<?php

namespace Modules\Panel\Livewire\Acl\User;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Modules\Core\Models\User;
use Modules\Core\Services\UserService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling user-related logic.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * The user being displayed
     *
     * @var array $user
     */
    public array $user;

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
     * Table columns definition for the user listing.
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
            'name' => 'email',
            'label' => 'Email',
            'sortable' => true,
        ],
        [
            'name' => 'roles',
            'label' => 'Roles',
            'sortable' => false,
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
     * It sets up the user service and initializes the guard tabs.
     *
     * @param UserService $userService The service for handling user operations
     * @return void
     */
    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the user service and guard tabs.
     *
     * @param UserService $userService The service for handling user operations
     * @return void
     */
    public function hydrate(UserService $userService)
    {
        $this->userService = $userService;
        $this->handleTabs();
    }

    /**
     * Show specific User.
     */
    public function showUser($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);

            $user->role_badges = $user->roleBadges();

            $this->user = $user->toArray();
        } catch (Exception $exception) {
            $this->dismiss();
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
     * Handle the listing of users with search, sort and pagination.
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

        return $this->userService
            ->paginatedListing($filters, $this->perPage);
    }

    /**
     * Get the total count of users for each guard tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $this->userService->getGuardTabs();
    }

    /**
     * Handle bulk delete of selected users.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new Exception('Please select at least one user to delete');
            }

            User::whereIn('id', $this->selectedIds)->delete();

            $this->notifySuccess('Selected users deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single user deletion using UserService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->userService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('User deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the user creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('user');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showDialog = false');
    }

    public function render()
    {
        return view('panel::livewire.acl.user.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}