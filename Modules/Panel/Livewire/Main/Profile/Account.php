<?php

namespace Modules\Panel\Livewire\Main\Profile;

use Exception;
use Livewire\Component;
use App\Traits\WithToast;
use App\Traits\FileService;
use Modules\Core\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Panel\Http\Requests\Main\UpdateAccountRequest;

class Account extends Component
{
    use WithToast, FileService;

    /**
     * The user model instance.
     *
     * @var \Modules\Core\Models\User
     */
    public User $user;

    /**
     * Form data for user account settings.
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'id' => null,
        'name' => null,
        'email' => null,
        'email_verified_at' => null,
        'avatar' => null,
        'old_avatar' => null,
    ];

    /**
     * Form data for user account password.
     *
     * @var string
     */
    public ?string $current_password;

    /**
     * Event listeners for the component.
     *
     * @var array<string, string>
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * Mount the component with user data.
     *
     * @param \Modules\Core\Models\User $user
     * @return void
     */
    public function mount(User $user): void
    {
        $this->initialize($user);
    }

    /**
     * Initialize the component with the given User model.
     * Populates the form array with the user's current data.
     *
     * @param  \Modules\Core\Models\User  $user  The User model instance to initialize from
     * @return void
     */
    public function initialize(User $user)
    {
        $this->user = $user;
        $this->form['id'] = $user->id;
        $this->form['name'] = $user->name;
        $this->form['email'] = $user->email;
        $this->form['email_verified_at'] = $user->email_verified_at;
        $this->form['old_avatar'] = $user->getAvatar();
    }

    /**
     * Update user account information.
     *
     * Validates input, processes the avatar if changed,
     * updates the user's record, and dispatches events for UI feedback.
     *
     * @return void
     */
    public function handleUpdateAccount(): void
    {
        try {
            // Validate form data using defined rules and custom attributes
            $request = new UpdateAccountRequest($this->user);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes()
            );

            // Prepare data for update
            $data = $this->prepareDataBeforeUpdate();

            // Handle avatar upload if present
            if ($this->form['avatar']) {
                // Store new avatar and update path in data array
                $data['avatar'] = $this->storeFileFromBase64($this->form['avatar'], 'avatar');

                // Delete old avatar if it exists
                if ($this->form['old_avatar']) {
                    $this->removeFile('avatar', $this->form['old_avatar']);
                }
            }

            // Update the user with new data
            $this->user->update($data);

            // Refresh the user instance and reset the form
            $user = $this->user->refresh();
            $this->reset('form');
            $this->initialize($user);

            // Emit avatarChanged event for frontend updates
            $this->dispatch('avatarChanged', ['url' => $user->getAvatar()]);

            // Dispatch success notification
            $this->notifySuccess('Account updated successfully');
        } catch (Exception $exception) {
            // Dispatch error notification
            $this->notifyError($exception);
        }
    }

    /**
     * Prepare the user data array for update.
     *
     * This method collects updated name and email values from the form.
     *
     * @return array
     */
    public function prepareDataBeforeUpdate(): array
    {
        return [
            'name'  => $this->form['name'],
            'email' => $this->form['email'],
        ];
    }

    /**
     * Delete user account.
     *
     * @return void
     */
    public function handleDeleteAccount()
    {
        try {
            $this->validate([
                'current_password' => 'current_password:web'
            ]);
            // Delete the user
            // $this->user->delete();

            // Logout and redirect to login
            Auth::guard('web')->logout();

            Session::invalidate();
            Session::regenerateToken();

            return $this->redirectIntended(
                default: route('auth.web.login'),
                navigate: true
            );
        } catch (\Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('panel::livewire.main.profile.account');
    }
}
