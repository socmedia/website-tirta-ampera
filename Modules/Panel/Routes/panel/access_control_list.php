<?php

use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\MainController;
use Modules\Panel\Http\Controllers\Acl\RoleController;
use Modules\Panel\Http\Controllers\Acl\UserController;
use Modules\Panel\Http\Controllers\Acl\PermissionController;
use Modules\Panel\Http\Controllers\Acl\AccessControlController;

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
    'prefix' => 'panel/access-control',
    'as' => 'panel.acl.',
], function () {
    Route::group([
        'middleware' => ['auth.module:web', 'verified'],
    ], function () {
        Route::get('/', [MainController::class, 'accessControl'])->name('index');

        // Session
        Route::group([
            'prefix' => 'session',
            'as' => 'session.',
        ], function () {
            Route::get('/', [AccessControlController::class, 'index'])->name('index');
        });

        // User
        Route::group([
            'prefix' => 'user',
            'as' => 'user.',
        ], function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        });

        // Role
        Route::group([
            'prefix' => 'role',
            'as' => 'role.',
        ], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        });

        // Permission
        Route::group([
            'prefix' => 'permission',
            'as' => 'permission.',
        ], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
        });
    });
});