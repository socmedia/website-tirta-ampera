<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Modules\Panel\Enums\Documentation;
use Modules\Panel\Http\Controllers\MainController;
use Modules\Panel\Http\Controllers\Website\AppSettingController;

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
    'as' => 'panel.main.',
], function () {
    Route::group([
        'middleware' => ['auth.module:web', 'verified'],
    ], function () {
        Route::get('/', [MainController::class, 'index'])->name('index');
        Route::get('/account', [MainController::class, 'account'])->name('account');
        Route::get('/security', [MainController::class, 'account'])->name('security');
        Route::get('/preference', [MainController::class, 'account'])->name('preference');
        Route::get('/notifikasi', [MainController::class, 'notification'])->name('notification');

        // Settings
        Route::group([
            'prefix' => 'settings',
            'as' => 'setting.',
        ], function () {
            Route::get('/', [MainController::class, 'setting'])->name('index');
            Route::get('/create', [MainController::class, 'createSetting'])->name('create');
            Route::get('/edit/{appSetting:id}', [MainController::class, 'editSetting'])->name('edit');
        });

        // Documentation
        Route::group([
            'prefix' => 'documentation',
            'as' => 'documentation.',
            'middleware' => ['auth.module:web', 'verified'],
        ], function () {
            Route::redirect('/', '/panel/documentation/code-base/introduction')->name('index');

            Route::get('/{type}/{filename?}', function (Request $request) {
                $docType = Documentation::tryFrom($request->type);

                if (!$docType) {
                    return abort(404);
                }

                // Remove multi language, use default 'id'
                $directory = $docType->getDirectory('id');

                $filename = $request->filename;

                if (empty($filename)) {
                    return redirect()->route('documentation.show', [
                        'type' => $request->type,
                        'filename' => $docType->defaultFile()
                    ]);
                }

                // validasi nama file
                if (!preg_match('/^[a-zA-Z0-9_-]+$/', $filename)) {
                    return abort(404);
                }

                $filePath = $directory . DIRECTORY_SEPARATOR . $filename . '.md';

                if (!File::exists($filePath)) {
                    return abort(404);
                }

                return view('panel::pages.documentation', [
                    'type' => $request->type,
                    'filename' => $filename,
                    'filepath' => $filePath
                ]);
            })->name('show');
        });
    });
});
