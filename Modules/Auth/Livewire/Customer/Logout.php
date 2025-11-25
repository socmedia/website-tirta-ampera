<?php

namespace Modules\Auth\Livewire\Customer;

use Livewire\Component;
use Modules\Core\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public Customer $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('customer')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return $this->redirectIntended(
            default: route('auth.customer.login'),
            navigate: true
        );
    }

    public function render()
    {
        return view('auth::livewire.customer.logout');
    }
}
