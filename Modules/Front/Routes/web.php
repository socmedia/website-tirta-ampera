<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Front\Http\Controllers\FrontController;

Route::group([
    'as' => 'front.',
], function () {
    Route::get('/', [FrontController::class, 'index'])->name('index');
    Route::get('/tentang-kami', [FrontController::class, 'about'])->name('about');

    Route::group([
        'prefix' => 'layanan',
        'as' => 'service.',
    ], function () {
        Route::get('/', [FrontController::class, 'service'])->name('index');
        Route::get('/bayar-tagihan', [FrontController::class, 'servicePayBill'])->name('pay-bill');
        Route::get('/pasang-baru', [FrontController::class, 'serviceNewConnection'])->name('new-connection');
        Route::get('/pengaduan-pelanggan', [FrontController::class, 'serviceComplaint'])->name('complaint');
        Route::get('/pindah-meter', [FrontController::class, 'serviceMoveMeter'])->name('move-meter');
        Route::get('/ganti-stop-kran', [FrontController::class, 'serviceReplaceStopValve'])->name('replace-stop-valve');
        Route::get('/balik-nama', [FrontController::class, 'serviceChangeName'])->name('change-name');
        Route::get('/buka-kembali', [FrontController::class, 'serviceReconnect'])->name('reconnect');
        Route::get('/tutup-sementara', [FrontController::class, 'serviceTemporaryDisconnect'])->name('temporary-disconnect');
    });

    Route::group([
        'prefix' => 'info-pelanggan',
        'as' => 'customer-info.',
    ], function () {
        Route::get('/hak-dan-kewajiban', [FrontController::class, 'customerInfoRightsObligations'])->name('rights-obligations');
        Route::get('/larangan', [FrontController::class, 'customerInfoProhibitions'])->name('prohibitions');
        Route::get('/golongan', [FrontController::class, 'customerInfoGroups'])->name('groups');
        Route::get('/tarif', [FrontController::class, 'customerInfoTariff'])->name('tariff');
        Route::get('/info-gangguan', [FrontController::class, 'customerInfoDisturbanceInfo'])->name('disturbance-info');
    });

    Route::group([
        'prefix' => 'berita',
        'as' => 'news.'
    ], function () {
        Route::get('/', [FrontController::class, 'news'])->name('index');
        Route::get('/{slug}', [FrontController::class, 'newsDetail'])->middleware('post.view')->name('show');
    });

    Route::get('/kontak', [FrontController::class, 'contact'])->name('contact');
    Route::get('/syarat-ketentuan', [FrontController::class, 'tnc'])->name('terms-conditions');
    Route::get('/kebijakan-privasi', [FrontController::class, 'privacyPolicy'])->name('privacy-policy');
});
