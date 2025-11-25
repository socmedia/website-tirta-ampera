<?php

namespace Modules\Auth\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordValidation;
use Illuminate\Validation\ValidationException;
use Modules\Core\Models\Customer;
use Modules\Auth\Providers\RouteServiceProvider;
use App\Traits\WithToast;

class Register extends Component
{
    use WithToast;

    /**
     * The full name provided by the customer.
     *
     * @var string
     */
    public string $name = '';

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
     * The password confirmation provided by the customer.
     *
     * @var string
     */
    public string $password_confirmation = '';

    /**
     * Define validation rules for the component's public properties.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'password' => [
                'required',
                'confirmed',
                PasswordValidation::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }

    /**
     * Handle the registration attempt for the customer.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(): void
    {
        try {
            $this->validate();

            $this->ensureIsNotRateLimited();

            $customer = Customer::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Optionally, you may want to send email verification here

            // Log the customer in
            Auth::guard('customer')->login($customer);

            RateLimiter::clear($this->throttleKey());

            Session::regenerate();

            $this->notifySuccess(__('auth.registration_success'));

            $this->redirect(RouteServiceProvider::CUSTOMER_DASHBOARD, navigate: true);
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
        return view('auth::livewire.customer.register');
    }
}
