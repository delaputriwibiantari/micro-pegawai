<?php


use App\Http\Controllers\Content\PortalController;
use App\Http\Controllers\PersonController as ControllersPersonController;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Route;

Route::get('view-file/{folder}/{filename}', [PortalController::class, 'viewFile'])
    ->where(['folder' => '[A-Za-z0-9_\-]+', 'filename' => '[A-Za-z0-9_\-\.]+'])
    ->name('view-file');

Route::prefix('person')->group(function () {
    Route::get('/', [ControllersPersonController::class, 'index'])
        ->name('person.index');
    Route::get('data', [ControllersPersonController::class, 'list'])
        ->name('person.list');
    Route::get('show/{id}', [ControllersPersonController::class, 'show'])
        ->name('person.show');
    Route::post('/store', [ControllersPersonController::class, 'store'])
        ->name('person.store');
    Route::post('update/{id}', [ControllersPersonController::class, 'update'])
        ->name('person.update');
});
