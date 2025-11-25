<?php

use Illuminate\Support\Facades\Route;
use Modules\Common\Services\PostService;
use Modules\Core\Models\Permission;
use Modules\Core\Services\PermissionService;
use Modules\Front\Http\Controllers\FrontController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('fronts', FrontController::class)->names('front');
});
