<?php

namespace Modules\Panel\Livewire\Ui\Announcement;

use Exception;
use Livewire\Component;
use Modules\Core\Models\User;

class VerifyEmail extends Component
{
    /**
     * The user model instance.
     *
     * @var \Modules\Core\Models\User
     */
    public User $user;

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
    }

    /**
     * Send email verification to the user.
     *
     * @return void
     */
    public function handleSendVerificationEmail(): void
    {
        try {
            if ($this->user->hasVerifiedEmail()) {
                $this->dispatch('notify', [
                    'type' => 'default',
                    'message' => 'Email is already verified.'
                ]);
                return;
            }

            $this->user->sendEmailVerificationNotification();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Verification email sent successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to send verification email: ' . $exception->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('panel::livewire.ui.announcement.verify-email');
    }
}