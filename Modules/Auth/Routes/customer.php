<?php

use Illuminate\Support\Facades\Route;
// use Modules\Auth\Http\Controllers\Auth\Customer\SocialiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group([
    'prefix' => 'auth/customer',
    'as' => 'auth.customer.',
    'middleware' => ['guest', 'guest:customer'],
], function () {
    Route::view('login', 'auth::auth.customer.login')->name('login');
    Route::view('register', 'auth::auth.customer.register')->name('register');
    Route::view('forgot-password', 'auth::auth.customer.forgot-password')->name('password.request');
    Route::view('reset-password/{token}', 'auth::auth.customer.reset-password')->name('password.reset');

    // Route::get('redirect', [SocialiteController::class, 'redirectToProvider'])->name('redirect');
    // Route::get('callback', [SocialiteController::class, 'handleProviderCallback'])->name('callback');
});

Route::group([
    'prefix' => 'auth/customer',
    'as' => 'auth.customer.',
    'middleware' => 'auth.module:customer',
], function () {
    Route::view('verify-email', 'auth::auth.customer.verify-email')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', function ($id, $hash) {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();

        if (!$user || $user->getKey() != $id) {
            abort(403);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('customer.index')->with('status', __('Your email is already verified.'));
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect()->route('customer.index')->with('status', __('Your email has been verified!'));
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
});
