<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WishListController;

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

Route::post('users/register', [UserController::class, 'store']);
Route::post('users/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function (){
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/search', [BookController::class, 'search']);
    Route::get('books/{book}', [BookController::class, 'show']);
    
    Route::get('cart/{user_id}', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'store']);
    Route::put('cart/update', [CartController::class, 'update']);
    Route::delete('cart/remove',[CartController::class, 'delete']);

    Route::get('users/{user_id}',[UserController::class, 'profile']);

    Route::get('wishlist',[WishListController::class, 'index']);
    Route::post('wishlist/{book_id}',[WishListController::class, 'store']);
    Route::delete('wishlist/{book_id}',[WishListController::class, 'delete']);

    Route::post('orders/checkout', [OrderController::class, 'checkout']);
});