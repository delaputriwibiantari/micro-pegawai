<?php

use App\Http\Controllers\admin\pendidikan\PendidikanController;

use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\admin\person\PersonController;
use App\Http\Controllers\admin\sdm\SdmController;
use App\Http\Controllers\admin\ref\RefJenjangPendidikanController;
use App\Http\Controllers\admin\sdm\SdmPendidikanController;
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
        ->name('sdm.list');
    Route::get('show/{id}', [SdmController::class, 'show'])
        ->name('sdm.show');
    Route::post('/store', [SdmController::class, 'store'])
        ->name('sdm.store');
    Route::post('update/{id}', [SdmController::class, 'update'])
        ->name('sdm.update');
    Route::get('histori/{id}', [SdmController::class, 'histori'])
        ->name('sdm.histori');
    Route::get('find/by/nik/{id}', [SdmController::class, 'find_by_nik'])
        ->name('sdm.find_by_nik');

    Route::prefix('pendidikan')->name('pendidikan.')->group(function () {
        Route::get('/', [SdmPendidikanController::class, 'index'])
            ->name('index');
        Route::get('data', [SdmPendidikanController::class, 'list'])
            ->name('list');
        Route::get('cari', [SdmPendidikanController::class, 'cari'])
            ->name('cari');
        Route::post('store', [SdmPendidikanController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [SdmPendidikanController::class, 'update'])
            ->name('update');
            Route::get('show/{id}', [SdmPendidikanController::class, 'show'])
                ->name('show'); // Menjadi: admin.person.show
    });
});

Route::prefix('ref')->group(function () {
    Route::prefix('jenjang-pendidikan')->group(function () {
        Route::get('/', [RefJenjangPendidikanController::class, 'index'])
            ->name('ref.jenjang-pendidikan.index');
        Route::get('data', [RefJenjangPendidikanController::class, 'list'])
            ->name('ref.jenjang-pendidikan.list');
        Route::get('show/{id}', [RefJenjangPendidikanController::class, 'show'])
            ->name('ref.jenjang-pendidikan.show');
        Route::post('/store', [RefJenjangPendidikanController::class, 'store'])
            ->name('ref.jenjang-pendidikan.store');
        Route::post('update/{id}', [RefJenjangPendidikanController::class, 'update'])
            ->name('ref.jenjang-pendidikan.update');
    });
});





    Route::get('/coba', function () {
        return view('admin.coba.index');
    })->name('coba.index');


