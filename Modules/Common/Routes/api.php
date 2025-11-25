<?php

use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\CommonController;

Route::group([
    'prefix' => 'v1/common',
    'as' => 'common.',
    'middleware' => [],
], function () {

    Route::group([
        'prefix' => 'image',
        'as' => 'image.',
        'middleware' => [],
    ], function () {
        Route::post('store', [CommonController::class, 'uploadImage'])->name('store');
        Route::delete('remove', [CommonController::class, 'deleteImage'])->name('remove');
    });
});
