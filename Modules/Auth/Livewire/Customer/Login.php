<?php

namespace Modules\Auth\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Providers\RouteServiceProvider;
use App\Traits\WithToast;

class Login extends Component
{
    use WithToast;

    /**
     * The email address provided by the customer.
     *
     * @var string
     */
    public string $email = '';

    /**
     * The password provided by the customer.
     *
     * @var string
     */
    public string $password = '';

    /**
     * Whether the customer wants to be remembered.
     *
     * @var bool
     */
    public bool $remember = false;

    /**
     * Define validation rules for the component's public properties.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    /**
     * Handle the authentication attempt for the customer.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(): void
    {
        try {
            // Validate input (Livewire assumes rules are set via rules() method)
            $this->validate();

            // Prevent brute force attempts
            $this->ensureIsNotRateLimited();

            // Attempt login using the 'customer' guard
            if (!Auth::guard('customer')->attempt([
                'email' => $this->email,
                'password' => $this->password,
            ], $this->remember)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            // Clear any rate limit on success
            RateLimiter::clear($this->throttleKey());

            // Regenerate session to prevent session fixation
            Session::regenerate();

            // Show success message
            $this->notifySuccess('Login successful');

            // Redirect to intended location for customer
            $this->redirectIntended(
                default: RouteServiceProvider::CUSTOMER_DASHBOARD,
                navigate: true
            );
        } catch (\Exception $e) {
            $this->notifyError($e);
        }
    }

    /**
     * Ensure the customer is not locked out due to too many failed attempts.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Generate a unique key for throttling based on customer email and IP.
     *
     * @return string
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    public function render()
    {
        return view('auth::livewire.customer.login');
    }
}
