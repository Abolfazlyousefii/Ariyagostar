<?php

use App\Http\Controllers\Api\V1\AppController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\FavoriteController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProvinceController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ------------------ Api V1 Routes
Route::group(['prefix' => 'v1'], function () {

    // ------------------ AuthController
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    // ------------------ Auth Required Routes
    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        // ------------------ user
        Route::get('user', [UserController::class, 'user']);
        Route::put('user', [UserController::class, 'update']);
        Route::put('user/address', [UserController::class, 'updateAddress']);

        // ------------------ user
        Route::apiResource('orders', OrderController::class)->only(['index', 'show']);

        // ------------------ Favorites
        Route::get('favorites', [FavoriteController::class, 'index']);
        Route::post('favorites', [FavoriteController::class, 'store']);
        Route::delete('favorites', [FavoriteController::class, 'destroy']);

        // ------------------ Products
        Route::post('products/{product}/comments', [ProductController::class, 'storeComment']);

        // ------------------ AuthController
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
    });

    // ------------------ AppController
    Route::group(['prefix' => 'app'], function () {
        Route::get('settings', [AppController::class, 'settings']);
    });

    // ------------------ Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}/filter', [CategoryController::class, 'filter']);

    // ------------------ Products
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);
    Route::get('products/{product}/comments', [ProductController::class, 'comments']);
    Route::get('products/{product}/relatedProducts', [ProductController::class, 'relatedProducts']);

    // ------------------ Posts
    Route::apiResource('posts', PostController::class)->only(['index', 'show']);
    Route::get('posts/{post}/comments', [PostController::class, 'comments']);

    // ------------------ Pages
    Route::apiResource('pages', PageController::class)->only(['show']);

    // ------------------ MainController
    Route::get('provinces', [ProvinceController::class, 'index']);
    Route::get('provinces/{province}/cities', [ProvinceController::class, 'cities']);

    // ------------------ Cart
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{price}', [CartController::class, 'destroy']);
});
