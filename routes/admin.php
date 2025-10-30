<?php

use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\admin\person\PersonController;
use App\Http\Controllers\admin\sdm\SdmController;
use Illuminate\Support\Facades\Route;

Route::get('view-file/{folder}/{filename}', [PortalController::class, 'viewFile'])
    ->where(['folder' => '[A-Za-z0-9_\-]+', 'filename' => '[A-Za-z0-9_\-\.]+'])
    ->name('view-file');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('person')->name('person.')->group(function () {
        Route::get('/', [PersonController::class, 'index'])
            ->name('index'); // Menjadi: admin.person.index
        Route::get('data', [PersonController::class, 'list'])
            ->name('list'); // Menjadi: admin.person.list
        Route::get('show/{id}', [PersonController::class, 'show'])
            ->name('show'); // Menjadi: admin.person.show
        Route::post('/store', [PersonController::class, 'store'])
            ->name('store'); // Menjadi: admin.person.store
        Route::post('update/{id}', [PersonController::class, 'update'])
            ->name('update'); // Menjadi: admin.person.update
    });
});

Route::prefix('sdm')->name('sdm.')->group(function () {
    Route::get('/', [SdmController::class, 'index'])
        ->name('index');
    Route::get('data', [SdmController::class, 'list'])
        ->name('list');
    Route::get('cari', [SdmController::class, 'cari'])
        ->name('cari');
    Route::post('store', [SdmController::class, 'store'])
        ->name('store');
    Route::post('update/{id}', [SdmController::class, 'update'])
        ->name('update');
    Route::get('show/{id}', [SdmController::class, 'show'])
        ->name('show');
});





