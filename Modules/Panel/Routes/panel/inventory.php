<?php

use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\MainController;

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
    'prefix' => 'panel/inventory',
    'as' => 'panel.inventory.',
], function () {
    Route::group([
        'middleware' => ['auth.module:web', 'verified'],
    ], function () {
        Route::get('/', [MainController::class, 'inventory'])->name('index');
    });
});
