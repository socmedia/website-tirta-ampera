<?php

use Illuminate\Support\Facades\Route;

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
    'prefix' => 'auth',
    'as' => 'auth.web.',
    'middleware' => ['guest', 'guest:web'],
], function () {
    Route::redirect('/', '/auth/login');

    Route::view('login', 'auth::auth.web.login')->name('login');
    Route::view('forgot-password', 'auth::auth.web.forgot-password')->name('password.request');
    Route::view('reset-password/{token}', 'auth::auth.web.reset-password')->name('password.reset');

    Route::group([
        'middleware' => 'auth.module:web',
    ], function () {
        Route::view('verify-email', 'auth::auth.web.verify-email')->name('verification.notice');
        Route::view('verify-email/{id}/{hash}', 'auth::auth.web.verify-email')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });
});
