<?php

namespace Modules\Auth\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Traits\WithToast;

class VerifyEmail extends Component
{
    use WithToast;

    public bool $resent = false;

    /**
     * Resend the email verification notification.
     *
     * @return void
     */
    public function resend()
    {
        $user = Auth::guard('customer')->user();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            $this->resent = true;
            $this->notifySuccess(__('A fresh verification link has been sent to your email address.'));
        }
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  string  $id
     * @param  string  $hash
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify($id, $hash)
    {
        $user = Auth::guard('customer')->user();

        if (!$user || $user->getKey() != $id) {
            abort(403);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('customer.index'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            $this->notifySuccess(__('Your email has been verified!'));
        }

        return redirect()->intended(route('customer.index'));
    }

    public function render()
    {
        return view('auth::livewire.customer.verify-email');
    }
}
