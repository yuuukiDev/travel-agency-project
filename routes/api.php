<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

// public endpoints

Route::get('travels', [TravelController::class, 'index']);
Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

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

    // Profile routes

    Route::controller(ProfileController::class)->group(function () {
        Route::post('/profile', 'update');
        Route::delete('/profiles/{profile}', 'destroy');
    });

//     // Cart routes

    Route::controller(CartController::class)->group(function () {
        Route::get('/carts', 'index');
        Route::post('/travels/{travel}/tours/{tour}', 'store');
        Route::put('/carts/items/{cartItem}', 'update');
        Route::delete('/carts/items/{cartItem}', 'destroy');
    });

//     // Order routes

    Route::controller(OrderController::class)->group(function () {
        Route::post('orders/{cartId}/confirm', 'confirm');
        Route::post('/orders/{orderId}/accept', 'accept');
    });

// // admin endpoints

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {

        // travel routes
        Route::controller(App\Http\Controllers\Admin\TravelController::class)->group(function () {
            Route::post('travels', 'store');
            Route::put('travels/{travel}', 'update');
            Route::delete('travels/{travel}', 'destroy');
        });

        // tour routes
        Route::controller(App\Http\Controllers\Admin\TourController::class)->group(function () {
            Route::post('travels/{travel}/tours', 'store');
            Route::put('travels/{travel}/tours', 'update');
            Route::delete('travels/{travel}/tours', 'destroy');
        });

        Route::controller(App\Http\Controllers\Admin\TourImageController::class)->group(function () {
            Route::post('tours/{tour}/images', 'store');
            Route::post('tours/{tour}/images/{tour_image_id}', 'update');
            Route::delete('tours/{tour}/images/{tour_image_id}', 'destroy');
        });

    });

// // editor endpoints

Route::prefix('editor')
    ->middleware(['auth:sanctum', 'role:editor'])
    ->group(function () {

        // travel route
        Route::put('travels/{travel}', [App\Http\Controllers\Admin\TravelController::class, 'update']);

        // tour route
        Route::put('travels/{travel}/tours', [App\Http\Controllers\Admin\TourController::class, 'update']);

    });
