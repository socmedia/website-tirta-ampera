<?php

use Illuminate\Support\Facades\Route;
// use Modules\Auth\Http\Controllers\Auth\Vendor\SocialiteController;

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
    'prefix' => 'auth/vendor',
    'as' => 'auth.vendor.',
    'middleware' => ['guest', 'guest:vendor'],
], function () {
    Route::view('login', 'auth::auth.vendor.login')->name('login');
    Route::view('register', 'auth::auth.vendor.register')->name('register');
    Route::view('forgot-password', 'auth::auth.vendor.forgot-password')->name('password.request');
    Route::view('reset-password/{token}', 'auth::auth.vendor.reset-password')->name('password.reset');

    // Route::get('redirect', [SocialiteController::class, 'redirectToProvider'])->name('redirect');
    // Route::get('callback', [SocialiteController::class, 'handleProviderCallback'])->name('callback');
});

Route::group([
    'prefix' => 'auth/vendor',
    'as' => 'auth.vendor.',
    'middleware' => 'auth.module:vendor',
], function () {
    Route::view('verify-email', 'auth::auth.vendor.verify-email')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', function ($id, $hash) {
        $user = \Illuminate\Support\Facades\Auth::guard('vendor')->user();

        if (!$user || $user->getKey() != $id) {
            abort(403);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('vendor.index')->with('status', __('Your email is already verified.'));
        }

        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect()->route('vendor.index')->with('status', __('Your email has been verified!'));
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
});
