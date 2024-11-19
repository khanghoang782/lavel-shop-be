<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\IsAdminMiddleware;


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/user', 'getUser');
        Route::post('/logout', 'logout');
    });
});
Route::middleware([IsAdminMiddleware::class])->group(function () {

});

