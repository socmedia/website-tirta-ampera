<?php

namespace Modules\Auth\Livewire\Web;

use Livewire\Component;
use Modules\Core\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    public User $user;


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
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return $this->redirectIntended(
            default: route('auth.web.login'),
            navigate: true
        );
    }

    public function render()
    {
        return view('auth::livewire.web.logout');
    }
}
