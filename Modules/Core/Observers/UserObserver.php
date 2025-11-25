<?php

namespace Modules\Core\Observers;

use Exception;

use App\Traits\Logger;
use App\Traits\FileService;
use Modules\Core\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    use FileService, Logger;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->logger_file = 'users';
    }

    /**
     * Handle the "created" event for the User model.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        $log = $this->log();
        $log->info('User created with email: ' . $user->email);

        if (!$user->email_verified_at) {
            try {
                $user->sendEmailVerificationNotification();
                $log->info('Email verification sent to: ' . $user->email);
            } catch (Exception $exception) {
                $errorMessage = 'Error sending email verification to: ' . $user->email . '. Error: ' . $exception->getMessage();
                $log->error($errorMessage);
                session()->flash('failed', $errorMessage);
            }
        }
    }

    /**
     * Handle the "updated" event for the User model.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $log = $this->log();
        $log->info('User updated with email: ' . $user->email);

        // Check if email was changed
        if ($user->wasChanged('email')) {
            $log->info('User email changed. Resetting verification and sending new verification email.');

            // Reset email verification timestamp
            $user->email_verified_at = null;
            $user->saveQuietly(); // avoid triggering observer again

            // Send new verification email
            try {
                $user->sendEmailVerificationNotification();
                $log->info('Email verification re-sent to: ' . $user->email);
            } catch (Exception $exception) {
                $log->error('Failed to send verification email to: ' . $user->email . '. Error: ' . $exception->getMessage());
            }

            // Optional: flash a session message if context is available (e.g. via a job or controller)
            // session()->flash('info', 'We sent a new email verification link.');
        }
    }

    /**
     * Handle the "deleted" event for the User model.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $log = $this->log();
        $log->info('User deleted with email: ' . $user->email);

        // Remove user avatar if exists
        if ($user->avatar) {
            try {
                Storage::disk('avatar')->delete($user->avatar);
                $log->info('User avatar deleted successfully');
            } catch (Exception $exception) {
                $log->error('Failed to delete user avatar: ' . $exception->getMessage());
            }
        }
    }

    /**
     * Handle the "restored" event for the User model.
     *
     * @param  User  $user
     * @return void
     */
    public function restored(User $user)
    {
        // Implement logic for restored event if needed
    }

    /**
     * Handle the "force deleted" event for the User model.
     *
     * @param  User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        // Implement logic for force deleted event if needed
    }
}
