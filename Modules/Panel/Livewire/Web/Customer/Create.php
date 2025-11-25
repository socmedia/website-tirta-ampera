<?php

namespace Modules\Panel\Livewire\Web\Customer;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Core\Services\RoleService;
use Modules\Core\Services\CustomerService;
use Modules\Panel\Http\Requests\Acl\CreateCustomerRequest;

class Create extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling customer-related logic.
     *
     * @var CustomerService
     */
    protected CustomerService $customerService;

    /**
     * Form data for customer creation
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
     * Available roles for customer assignment
     *
     * @var array
     */
    public $roles = [];

    /**
     * Component event listeners
     *
     * @var array
     */
    public $listeners = [
        self::UPDATED_TAGIFY,
    ];

    /**
     * Initialize the component.
     * This method is called when the component is first mounted.
     * It sets up the customer service and loads available roles.
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @return void
     */
    public function mount(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->loadRoles();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the customer service.
     *
     * @param CustomerService $customerService The service for handling customer operations
     * @return void
     */
    public function hydrate(CustomerService $customerService)
    {
        $this->customerService = $customerService;
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
     * Prepare form data for submission
     *
     * @return array
     */
    protected function prepareData(): array
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
     * Handle tagify component updates
     *
     * @param array $tags The updated tags
     * @return void
     */
    public function handleTagifyUpdate($tags)
    {
        $this->form['roles'] = $tags;
    }

    /**
     * Handle form submission and customer creation
     *
     * @return void
     */
    public function handleSubmit()
    {
        try {
            $request = new CreateCustomerRequest($this->form);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages()
            );

            $data = $this->prepareData();

            // Use CustomerService to create the customer
            $this->customerService->create($data);

            $this->reset('form');
            $this->resetThirdParty();
            $this->notifySuccess('Customer created successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.web.customer.create');
    }
}
