<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:5,1'])
    ->controller(AuthController::class)
    ->group(function (): void {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:api');
    });
Route::middleware(['throttle:5,1'])
    ->controller(PasswordResetController::class)
    ->group(function (): void {
        Route::post('/forget-password', 'forgetPassword');
        Route::post('/reset-password', 'resetPassword')->middleware('auth:api');

    });
Route::middleware('auth:api')
    ->post('/verify', VerifyController::class);

Route::controller(ProfileController::class)->group(function (): void {
    Route::post('/profile', 'update');
    Route::delete('/profiles/{profile}', 'destroy');
});

Route::controller(CartController::class)->group(function (): void {
    Route::get('/carts', 'index');
    Route::post('/travels/{travel}/tours/{tour}', 'store');
    Route::put('/carts/items/{cartItem}', 'update');
    Route::delete('/carts/items/{cartItem}', 'destroy');
});

Route::controller(OrderController::class)->group(function (): void {
    Route::post('orders/{cartId}/confirm', 'confirm');
    Route::post('/orders/{orderId}/accept', 'accept');
});
