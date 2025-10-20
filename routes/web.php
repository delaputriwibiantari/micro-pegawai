<?php

use App\Http\Controllers\content\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'login'])->name('index');
Route::post('/login', [PortalController::class, 'logindb'])->name('logindb');
