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
    'prefix' => 'panel/human-resource',
    'as' => 'panel.hrm.',
], function () {
    Route::group([
        'middleware' => ['auth.module:web', 'verified'],
    ], function () {
        Route::get('/', [MainController::class, 'humanResource'])->name('index');

        // Branch
        Route::group([
            'prefix' => 'branches',
            'as' => 'branch.',
        ], function () {
            Route::get('/', [BranchController::class, 'index'])->name('index');
            Route::get('/create', [BranchController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [BranchController::class, 'edit'])->name('edit');
        });

        // Department
        Route::group([
            'prefix' => 'departments',
            'as' => 'department.',
        ], function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('index');
            Route::get('/create', [DepartmentController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('edit');
        });


        // Employee
        Route::group([
            'prefix' => 'employees',
            'as' => 'employee.',
        ], function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
        });
    });
});
