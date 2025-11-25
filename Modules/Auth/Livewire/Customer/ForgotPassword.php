<?php

namespace Modules\Auth\Livewire\Customer;

use App\Traits\WithToast;
use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPassword extends Component
{
    use WithToast;

    /**
     * The email address provided by the user.
     *
     * @var string
     */
    public string $email = '';

    /**
     * Send a password reset link to the provided email address with rate limiting by IP and email.
     *
     * Validates the email input, checks if the user has exceeded the allowed number of attempts,
     * and if not, sends the reset link. If the rate limit is exceeded, throws a validation exception
     * informing the user to wait before trying again.
     *
     * @throws \Illuminate\Validation\ValidationException When too many attempts are detected.
     *
     * @return void
     */
    public function sendPasswordResetLink()
    {
        try {
            $this->validate([
                'email' => ['required', 'string', 'email', 'exists:customers,email'],
            ]);

            $key = $this->throttleKey();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                $second = RateLimiter::availableIn($key);
                return $this->notifyWarning(new \Exception("Too many attempts. Please try again in {$second} seconds"));
            }

            RateLimiter::hit($key, 60); // 60 seconds decay

            // Send the reset link using the 'customers' broker, but override the URL to use the customer reset route
            $status = Password::broker('customers')->sendResetLink(
                ['email' => $this->email],
                function ($user, $token) {
                    // Generate the correct customer reset password URL
                    $url = route('auth.customer.password.reset', ['token' => $token, 'email' => $this->email]);
                    // Send the notification with the custom URL
                    $user->sendPasswordResetNotification($token, $url);
                }
            );

            if ($status !== Password::RESET_LINK_SENT) {
                return $this->notifyError(new \Exception(__($status)));
            }

            return $this->notifySuccess('Password reset link has been sent to your email address.');
        } catch (\Exception $e) {
            return $this->notifyError($e);
        }
    }

    /**
     * Generate the throttle key for rate limiting.
     *
     * Combines the email address (lowercased) and the user's IP address to uniquely identify
     * the throttle bucket.
     *
     * @return string
     */
    protected function throttleKey(): string
    {
        return Str::lower($this->email) . '|' . request()->ip();
    }

    public function render()
    {
        return view('auth::livewire.customer.forgot-password');
    }
}
