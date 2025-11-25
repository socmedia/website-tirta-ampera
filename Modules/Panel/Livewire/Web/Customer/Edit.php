<?php

namespace Modules\Panel\Livewire\Web\Customer;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Modules\Core\Models\Customer;
use Modules\Core\Services\RoleService;
use Modules\Core\Services\CustomerService;
use Modules\Panel\Http\Requests\Acl\UpdateCustomerRequest;

class Edit extends Component
{
    use WithToast;

    /**
     * The service instance used for handling customer-related logic.
     *
     * @var CustomerService
     */
    protected CustomerService $customerService;

    /**
     * The customer being edited
     *
     * @var Customer|null
     */
    public ?Customer $customer = null;

    /**
     * Form data for customer editing
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'name' => '',
        'email' => '',
        'email_verified' => false,
        'password' => '',
        'password_confirmation' => '',
        'roles' => []
    ];

    /**
     * Available roles for the customer
     *
     * @var array
     */
    public array $roles = [];

    /**
     * The component event listeners
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * Initialize the component with customer data
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @param Customer $customer The customer to edit
     * @return void
     */
    public function mount(CustomerService $customerService, Customer $customer): void
    {
        $this->customerService = $customerService;
        $this->initialize($customer);
        $this->loadRoles();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @return void
     */
    public function hydrate(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Initialize the component with the given Customer model.
     * Populates the form array with the customer's current data.
     *
     * @param  Customer  $customer  The Customer model instance to initialize from
     * @return void
     */
    public function initialize(Customer $customer)
    {
        $this->customer = $customer;
        $this->form['name'] = $customer->name;
        $this->form['email'] = $customer->email;
        $this->form['email_verified'] = $customer->email_verified_at ? true : false;
        $this->form['roles'] = $customer->getRoleNames()->toArray();
    }

    /**
     * Load available roles
     *
     * @return void
     */
    public function loadRoles(): void
    {
        $this->roles = (new RoleService)->getRolesByGuard('customer')->pluck('name')->toArray();
    }

    /**
     * Handle tagify update for roles
     *
     * @param array $tags
     * @return void
     */
    public function handleTagifyUpdate($tags)
    {
        $this->form['roles'] = $tags;
    }

    /**
     * Prepare the data for submission
     *
     * @return array
     */
    protected function prepareData()
    {
        return [
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'email_verified_at' => $this->form['email_verified'],
            'password' => $this->form['password'],
            'roles' => $this->form['roles'],
        ];
    }

    /**
     * Handle the form submission
     *
     * @return void
     */
    public function handleSubmit()
    {
        try {
            // Validate form data using defined rules and custom attributes
            $request = new UpdateCustomerRequest($this->form, $this->customer->id);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages(),
            );

            $data = $this->prepareData();

            // Use CustomerService to update the customer
            $customer = $this->customerService->update($this->customer, $data);

            // Re-init with updated customer
            $this->initialize($customer);

            $this->notifySuccess('Customer updated successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.web.customer.edit');
    }
}
