<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\ManagementController;
use App\Http\Controllers\Api\OrderController;
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

        Route::post('/upload','addProductImage');
        //Catalog Route

        Route::get("/admin/isadmin", "isAdmin");

        //TEST
        Route::get("/admin/order", "getOrderList");
        Route::put("/admin/order/{order_id}", "updateOrderStatus");
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
    //Image
    Route::get('/product/{id}/image','getProductImageUrl');

    //Attribute
    Route::get('/attribute/size','getSizeAttribute');
});
Route::controller(OrderController::class)->group(function () {
   Route::post('/order', 'makeOrder');

   Route::get('/order/{id}', 'getOrderDetails');
});
Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/auth/google/url','getGoogleUrl');
    Route::get('/auth/google/callback','callback');

});

