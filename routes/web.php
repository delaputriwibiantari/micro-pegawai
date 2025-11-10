<?php

use App\Http\Controllers\admin\sdm\SdmController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\content\PortalController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/', [PortalController::class, 'login'])->name('index');
Route::post('/login', [PortalController::class, 'logindb'])->name('logindb');
Route::get('/admin/sdm/show/{id}', [SdmController::class, 'show'])->name('show');
Route::get('/forgot', function () { return view('forgot');})->name('forgot');
Route::post('log-error', [PortalController::class, 'error'])->name('log-error');

