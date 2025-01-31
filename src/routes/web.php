<?php

use Illuminate\Support\Facades\Route;
use LaravelLogin\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('web');
    Route::post('/login', [AuthController::class, 'login'])->middleware('web');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('web');
});