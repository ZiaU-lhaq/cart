<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
    //cart
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/update', [CartController::class, 'updateCart']);
    Route::delete('/cart/remove/{cart}', [CartController::class, 'removeFromCart']);
    //products
    Route::get('/products', [ProductController::class, 'getProduct']);
    Route::post('/products/add', [ProductController::class, 'store'])->name('products.store');
});
