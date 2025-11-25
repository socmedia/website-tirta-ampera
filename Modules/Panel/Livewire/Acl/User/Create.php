<?php

namespace Modules\Panel\Livewire\Acl\User;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\WithThirdParty;
use Modules\Core\Services\RoleService;
use Modules\Core\Services\UserService;
use Modules\Panel\Http\Requests\Acl\CreateUserRequest;

class Create extends Component
{
    use WithToast, WithThirdParty;

    /**
     * The service instance used for handling user-related logic.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * Form data for user creation
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
     * Available roles for user assignment
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
     * It sets up the user service and loads available roles.
     *
     * @param UserService $userService The service for handling user operations
     * @return void
     */
    public function mount(UserService $userService)
    {
        $this->userService = $userService;
        $this->loadRoles();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     * It reinitializes the user service.
     *
     * @param UserService $userService The service for handling user operations
     * @return void
     */
    public function hydrate(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Load available roles
     *
     * @return void
     */
    public function loadRoles(): void
    {
        $this->roles = (new RoleService)->getRolesByGuard('web')->pluck('name')->toArray();
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
     * Handle form submission and user creation
     *
     * @return void
     */
    public function handleSubmit()
    {
        try {
            $request = new CreateUserRequest($this->form);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages()
            );

            $data = $this->prepareData();

            // Use UserService to create the user
            $this->userService->create($data);

            $this->reset('form');
            $this->resetThirdParty();
            $this->notifySuccess('User created successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.acl.user.create');
    }
}