<?php

use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\Website\CmsController;
use Modules\Panel\Http\Controllers\Website\FaqController;
use Modules\Panel\Http\Controllers\Website\SeoController;
use Modules\Panel\Http\Controllers\Website\PageController;
use Modules\Panel\Http\Controllers\Website\PostController;
use Modules\Panel\Http\Controllers\Website\SliderController;
use Modules\Panel\Http\Controllers\Website\CustomerController;
use Modules\Panel\Http\Controllers\Website\AppSettingController;
use Modules\Panel\Http\Controllers\Website\PostCategoryController;
use Modules\Panel\Http\Controllers\Website\AdministratorController;
use Modules\Panel\Http\Controllers\Website\ContactMessageController;

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
    'prefix' => 'panel',
    'as' => 'panel.web.',
], function () {
    Route::group([
        'middleware' => ['auth.module:web'],
    ], function () {
        // Dashboard
        Route::get('/', [AdministratorController::class, 'index'])
            ->middleware('can:view-dashboard')
            ->name('index');

        // Content
        Route::group([
            'prefix' => 'content',
            'as' => 'content.',
            'middleware' => ['can:view-content'],
        ], function () {
            Route::get('/', [CmsController::class, 'index'])->name('index');
            Route::get('/create', [CmsController::class, 'create'])
                ->middleware('can:create-content')
                ->name('create');
            Route::get('/edit/{id}', [CmsController::class, 'edit'])
                ->middleware('can:update-content')
                ->name('edit');
        });

        // Page
        Route::group([
            'prefix' => 'page',
            'as' => 'page.',
            'middleware' => ['can:view-page'],
        ], function () {
            Route::get('/', [PageController::class, 'index'])->name('index');
            Route::get('/create', [PageController::class, 'create'])
                ->middleware('can:create-page')
                ->name('create');
            Route::get('/edit/{id}', [PageController::class, 'edit'])
                ->middleware('can:update-page')
                ->name('edit');
        });

        // Customer
        Route::group([
            'prefix' => 'customer',
            'as' => 'customer.',
            'middleware' => ['can:view-customer'],
        ], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])
                ->middleware('can:create-customer')
                ->name('create');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])
                ->middleware('can:update-customer')
                ->name('edit');
            Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
        });

        // Group post and post category routes together
        Route::group([
            'prefix' => 'post',
            'as' => 'post.',
            'middleware' => ['can:view-post'],
        ], function () {
            // Post routes
            Route::group([
                'as' => 'main.',
            ], function () {
                Route::get('/', [PostController::class, 'index'])->name('index');
                Route::get('/create', [PostController::class, 'create'])
                    ->middleware('can:create-post')
                    ->name('create');
                Route::get('/edit/{id}', [PostController::class, 'edit'])
                    ->middleware('can:update-post')
                    ->name('edit');
            });

            // Post category routes
            Route::group([
                'prefix' => 'category',
                'as' => 'category.',
                'middleware' => ['can:view-post-category'],
            ], function () {
                Route::get('/', [PostCategoryController::class, 'index'])->name('index');
            });
        });

        // Settings Route
        Route::group([
            'prefix' => 'setting',
            'as' => 'setting.',
            'middleware' => ['can:view-setting'],
        ], function () {

            // Main Settings
            Route::group([
                'prefix' => 'main',
                'as' => 'main.',
            ], function () {
                Route::get('/', [AppSettingController::class, 'index'])->name('index');
                Route::get('/create', [AppSettingController::class, 'create'])
                    ->middleware('can:create-setting')
                    ->name('create');
                Route::get('/edit/{id}', [AppSettingController::class, 'edit'])
                    ->middleware('can:update-setting')
                    ->name('edit');
            });
        });

        // Slider
        Route::group([
            'prefix' => 'slider',
            'as' => 'slider.',
            'middleware' => ['can:view-slider'],
        ], function () {
            Route::get('/', [SliderController::class, 'index'])->name('index');
            Route::get('/create', [SliderController::class, 'create'])
                ->middleware('can:create-slider')
                ->name('create');
            Route::get('/edit/{id}', [SliderController::class, 'edit'])
                ->middleware('can:update-slider')
                ->name('edit');
        });

        // FAQ
        Route::group([
            'prefix' => 'faq',
            'as' => 'faq.',
            'middleware' => ['can:view-faq'],
        ], function () {
            Route::get('/', [FaqController::class, 'index'])->name('index');
            Route::get('/create', [FaqController::class, 'create'])
                ->middleware('can:create-faq')
                ->name('create');
            Route::get('/edit/{id}', [FaqController::class, 'edit'])
                ->middleware('can:update-faq')
                ->name('edit');
        });

        // Contact Message
        Route::group([
            'prefix' => 'public-message',
            'as' => 'contactmessage.',
            'middleware' => ['can:view-contact-message'],
        ], function () {
            Route::get('/', [ContactMessageController::class, 'index'])->name('index');
        });

        // SEO
        Route::group([
            'prefix' => 'seo',
            'as' => 'seo.',
            'middleware' => ['can:view-seo'],
        ], function () {
            Route::get('/', [SeoController::class, 'index'])->name('index');
            Route::get('/create', [SeoController::class, 'create'])
                ->middleware('can:create-seo')
                ->name('create');
            Route::get('/edit/{id}', [SeoController::class, 'edit'])
                ->middleware('can:update-seo')
                ->name('edit');
        });
    });
});
