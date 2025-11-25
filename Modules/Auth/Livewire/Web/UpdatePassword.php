<?php

namespace Modules\Auth\Livewire\Web;

use Livewire\Component;
use App\Traits\WithToast;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as PasswordValidation;

class UpdatePassword extends Component
{
    use WithToast;

    /**
     * The reset token from the password reset link.
     *
     * @var string
     */
    public string $token = '';

    /**
     * The email address of the user resetting the password.
     *
     * @var string
     */
    public string $email = '';

    /**
     * The new password.
     *
     * @var string
     */
    public string $password = '';

    /**
     * Password confirmation input.
     *
     * @var string
     */
    public string $password_confirmation = '';

    /**
     * Mount the component and initialize properties.
     *
     * @param  string  $token
     * @return void
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    /**
     * Handle the password reset logic.
     *
     * @return void
     */
    public function resetPassword()
    {
        try {
            $this->validate([
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => [
                    'required',
                    'confirmed',
                    // PasswordValidation::defaults()
                    PasswordValidation::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
            ]);

            $status = Password::reset(
                $this->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) {
                    $user->forceFill([
                        'password' => bcrypt($this->password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status !== Password::PASSWORD_RESET) {
                $this->addError('email', __($status));
                return;
            }

            $this->notifySuccess('Password has been reset successfully.');
            $this->redirectRoute('auth.web.login', navigate: true);
        } catch (\Exception $exception) {
            $this->notifyError($exception);
        }
    }

    /**
     * Render the Livewire component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('auth::livewire.web.update-password');
    }
}
