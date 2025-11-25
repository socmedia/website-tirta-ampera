<?php

namespace Modules\Panel\Livewire\Main\Profile;

use App\Traits\WithToast;
use Livewire\Component;
use Modules\Core\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Panel\Http\Requests\Main\UpdatePasswordRequest;

class Security extends Component
{
    use WithToast;

    /**
     * The user model instance.
     *
     * @var \Modules\Core\Models\User
     */
    public User $user;

    /**
     * Form data for password update.
     *
     * @var array<string, mixed>
     */
    public array $form = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

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
        $this->user = $user;
    }

    /**
     * Update user password.
     *
     * @return void
     */
    public function handleUpdatePassword(): void
    {
        try {
            // Validate form data using defined rules and custom attributes
            $request = new UpdatePasswordRequest($this->user);

            $this->validate(
                rules: $request->rules(),
                attributes: $request->attributes()
            );

            $this->user->update([
                'password' => Hash::make($this->form['password'])
            ]);

            $this->reset('form');

            $this->notifySuccess('Password updated successfully');
        } catch (\Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('panel::livewire.main.profile.security');
    }
}
