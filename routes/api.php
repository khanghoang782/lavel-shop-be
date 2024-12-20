<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ManagementController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\IsAdminMiddleware;

//public route
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});
//Authenticated route
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/user/me', 'getUser');
        Route::post('/logout', 'logout');
    });
});
//ADMIN route
Route::middleware([IsAdminMiddleware::class])->group(function () {
    Route::controller(ManagementController::class)->group(function () {
        //User Route
        Route::get('/users', 'getUsers');

        //Product Route
        Route::post('/product', 'addProduct');
        Route::delete('/product/{product_id}', 'deleteProductById');
        Route::put('/product', 'updateProduct');
        //Catalog Route

        Route::get("/admin/isadmin", "isAdmin");
    });
});
//Public route
Route::controller(ProductController::class)->group(function () {
    //Product route
    Route::get('/products', 'getAll');
    Route::get('/products/catalog/{catalog_id}','getByCatalogId');
    Route::get('/products/{product_id}','getOneProductById');

    Route::get('/productdisplay','getRandomProduct');




    //Catalog route
    Route::get('/catalogs', 'getAllCatalogs');
});

