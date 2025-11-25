<?php

namespace Modules\Panel\Livewire\Web\Customer;

use Exception;
use Livewire\Component;
use App\Traits\WithTable;
use App\Traits\WithToast;
use Livewire\WithPagination;
use Modules\Core\Models\Customer;
use Modules\Core\Services\CustomerService;

class Listing extends Component
{
    use WithTable, WithPagination, WithToast;

    /**
     * The service instance used for handling customer-related logic.
     *
     * @var CustomerService
     */
    protected CustomerService $customerService;

    /**
     * The customer being displayed
     *
     * @var array $customer
     */
    public array $customer;

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
     * Table columns definition for the customer listing.
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
     * It sets up the customer service and initializes the guard tabs.
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @return void
     */
    public function mount(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->handleTabs();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the customer service and guard tabs.
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @return void
     */
    public function hydrate(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->handleTabs();
    }

    /**
     * Show specific Customer.
     */
    public function showCustomer($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            // If you have badges or similar, adjust accordingly
            // $customer->badges = $customer->badges();

            $this->customer = $customer->toArray();
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
     * Handle the listing of customers with search, sort and pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function handleListing()
    {
        $filters = [
            'keyword' => $this->search ?? null,
            'sort' => $this->sort ?? null,
            'order' => $this->order ?? null,
            'guard_name' => $this->guard,
        ];

        return $this->customerService
            ->paginatedListing($filters, $this->perPage ?? 15);
    }

    /**
     * Get the total count of customers for each guard tab.
     *
     * @return void
     */
    public function handleTabs(): void
    {
        $this->tabs = $this->customerService->getGuardTabs();
    }

    /**
     * Handle bulk delete of selected customers.
     *
     * @return void
     */
    public function bulkDelete()
    {
        try {
            if (empty($this->selectedIds)) {
                throw new Exception('Please select at least one customer to delete');
            }

            Customer::whereIn('id', $this->selectedIds)->delete();

            $this->notifySuccess('Selected customers deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Handle single customer deletion using CustomerService.
     *
     * @return void
     */
    public function handleDestroy()
    {
        try {
            if (!$this->destroyId) {
                return;
            }

            $this->customerService->delete($this->destroyId);

            $this->reset('destroyId');

            $this->notifySuccess('Customer deleted successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Reset the form and close the customer creation/edit dialog.
     *
     * @return void
     */
    public function dismiss()
    {
        $this->reset('customer');

        // Or, trigger a Livewire event if your UI listens to it
        $this->js('showDialog = false');
    }

    public function render()
    {
        return view('panel::livewire.web.customer.listing', [
            'data' => $this->handleListing(),
        ]);
    }
}