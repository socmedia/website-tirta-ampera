<?php

namespace Modules\Panel\Livewire\Acl\User;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use Modules\Core\Models\User;
use Modules\Core\Services\RoleService;
use Modules\Core\Services\UserService;
use Modules\Panel\Http\Requests\Acl\UpdateUserRequest;

class Edit extends Component
{
    use WithToast;

    /**
     * The service instance used for handling user-related logic.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * The user being edited
     *
     * @var User|null
     */
    public ?User $user = null;

    /**
     * Form data for user editing
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
     * Available roles for the user
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
     * Initialize the component with user data
     *
     * @param UserService $userService The service for handling user operations
     * @param User $user The user to edit
     * @return void
     */
    public function mount(UserService $userService, User $user): void
    {
        $this->userService = $userService;
        $this->initialize($user);
        $this->loadRoles();
    }

    /**
     * Handle component hydration.
     * This method is called when the component is rehydrated after a page refresh.
     *
     * @param UserService $userService The service for handling user operations
     * @return void
     */
    public function hydrate(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Initialize the component with the given User model.
     * Populates the form array with the user's current data.
     *
     * @param  User  $user  The User model instance to initialize from
     * @return void
     */
    public function initialize(User $user)
    {
        $this->user = $user;
        $this->form['name'] = $user->name;
        $this->form['email'] = $user->email;
        $this->form['email_verified'] = $user->email_verified_at ? true : false;
        $this->form['roles'] = $user->getRoleNames()->toArray();
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
            $request = new UpdateUserRequest($this->form, $this->user->id);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes(),
                messages: $request->messages(),
            );

            $data = $this->prepareData();

            // Use UserService to update the user
            $user = $this->userService->update($this->user, $data);

            // Re-init with updated user
            $this->initialize($user);

            $this->notifySuccess('User updated successfully');
        } catch (Exception $exception) {
            $this->notifyError($exception);
        }
    }

    public function render()
    {
        return view('panel::livewire.acl.user.edit');
    }
}