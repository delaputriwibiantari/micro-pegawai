<?php

use App\Http\Controllers\admin\pendidikan\PendidikanController;

use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\admin\person\PersonController;
use App\Http\Controllers\admin\ref\RefEselonController;
use App\Http\Controllers\admin\ref\RefHubunganKeluargaController;
use App\Http\Controllers\admin\sdm\SdmController;
use App\Http\Controllers\admin\ref\RefJenjangPendidikanController;
use App\Http\Controllers\admin\sdm\SdmKeluargaController;
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
        Route::get('/{id}', [SdmPendidikanController::class, 'index'])
            ->name('index');
        Route::get('data/{id}', [SdmPendidikanController::class, 'list'])
            ->name('list');
        Route::get('cari', [SdmPendidikanController::class, 'cari'])
            ->name('cari');
        Route::post('store', [SdmPendidikanController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [SdmPendidikanController::class, 'update'])
            ->name('update');
            Route::get('show/{id}', [SdmPendidikanController::class, 'show'])
                ->name('show'); // Menjadi: admin.person.show
        Route::post('destroy/{id}', [SdmPendidikanController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('keluarga')->name('keluarga.')->group(function () {
        Route::get('/{id}', [SdmKeluargaController::class, 'index'])
            ->name('index');
        Route::get('data/{id}', [SdmKeluargaController::class, 'list'])
            ->name('list');
        Route::get('show/{id}', [SdmKeluargaController::class, 'show'])
            ->name('show');
        Route::post('/store', [SdmKeluargaController::class, 'store'])
            ->name('store');
        Route::post('update/{id}', [SdmKeluargaController::class, 'update'])
            ->name('update');
        Route::post('destroy/{id}', [SdmKeluargaController::class, 'destroy'])
            ->name('destroy');
        Route::get('find/by/nik/{id}', [SdmKeluargaController::class, 'find_by_nik'])
            ->name('find_by_nik');
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

    Route::prefix('hubungan-keluarga')->group(function () {
        Route::get('/', [RefHubunganKeluargaController::class, 'index'])
            ->name('ref.hubungan-keluarga.index');
        Route::get('data', [RefHubunganKeluargaController::class, 'list'])
            ->name('ref.hubungan-keluarga.list');
        Route::get('show/{id}', [RefHubunganKeluargaController::class, 'show'])
            ->name('ref.hubungan-keluarga.show');
        Route::post('/store', [RefHubunganKeluargaController::class, 'store'])
            ->name('ref.hubungan-keluarga.store');
        Route::post('update/{id}', [RefHubunganKeluargaController::class, 'update'])
            ->name('ref.hubungan-keluarga.update');
    });

    Route::prefix('eselon')->group(function () {
        Route::get('/', [RefEselonController::class, 'index'])
            ->name('ref.eselon.index');
        Route::get('data', [RefEselonController::class, 'list'])
            ->name('ref.eselon.list');
        Route::get('show/{id}', [RefEselonController::class, 'show'])
            ->name('ref.eselon.show');
        Route::post('/store', [RefEselonController::class, 'store'])
            ->name('ref.eselon.store');
        Route::post('update/{id}', [RefEselonController::class, 'update'])
            ->name('ref.eselon.update');
    });
});


    Route::get('/coba', function () {
        return view('admin.coba.index');
    })->name('coba.index');


