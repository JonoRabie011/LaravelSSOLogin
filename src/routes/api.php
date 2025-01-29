<?php

use Illuminate\Support\Facades\Route;
use Jonorabie\LaravelLogin\Http\Controllers\Api\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});