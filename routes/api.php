<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Wishlist\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'product'], function () {
    Route::get('all', [ProductController::class, 'index']);
    Route::get('get', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::patch('update', [ProductController::class, 'update']);
    Route::delete('delete', [ProductController::class, 'destroy']);
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'viewCart']);
    Route::post('add', [CartController::class, 'addItem']);
    Route::patch('update', [CartController::class, 'updateItem']);
    Route::delete('remove', [CartController::class, 'removeItem']);
});

Route::group(['prefix' => 'wishlist'], function () {
    Route::post('add', [WishlistController::class, 'addItem']);
    Route::delete('remove', [WishlistController::class, 'removeItem']);
});

