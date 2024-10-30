<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

// public endpoints


Route::get('travels', [TravelController::class, 'index']);
Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::middleware(['throttle:5,1'])
    ->controller(AuthController::class)
    ->group(function () {

        Route::post('/register', 'register');

        Route::post('/login', 'login');

        Route::post('/forget-password', 'forgetPassword');

        Route::post('/check-verification-code', 'checkVerificationCode');
    });
    

// authenticated endpoints

Route::middleware('auth:api')->group(function () {
    
    // Authentication routes

    Route::controller(AuthController::class)->group(function () {
        Route::post('/register/verification/', 'verify')->middleware('throttle:5,1');
        Route::post('/reset-password', 'resetPassword')->middleware('throttle:5,1');
        Route::post('/logout', 'logout');
    });

    // Profile routes
    
    Route::controller(ProfileController::class)->group(function () {
        Route::post('/profile', 'update');
        Route::delete('/profiles/{profile}', 'destroy');
    });

    // cart routes

    // TODO "always gives null as a response" fix it (store method)
    Route::controller(CartController::class)->group(function(){
        Route::get('/carts', 'index');
        Route::post('/travels/{travel}/tours/{tour}', 'store');
        Route::put('/carts/items/{cartItem}', 'update');
        Route::delete('/carts/items/{cartItem}', 'destroy');
    });


    // Order routes 
    // TODO "always give no response"
    Route::controller(OrderController::class)->group(function () {
        Route::post('orders/{cartId}/confirm', 'confirm');
        Route::post('/orders/{orderId}/accept', 'accept');
    });
    
});


// admin endpoints

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

        // something wrong with this!

        // Route::controller(App\Http\Controllers\Admin\TourImageController::class)->group(function () {
        //     Route::post('tours/{tour}/images', 'store'); // working
        //     Route::put('tours/{tour}/images/{tour_image_id}', 'update'); // not working
        //     Route::delete('tours/{tour}/images/{tour_image_id}', 'destroy'); // not working
        // });


    });

// editor endpoints

Route::prefix('editor')
    ->middleware(['auth:sanctum', 'role:editor'])
    ->group(function () {

        // travel route
        Route::put('travels/{travel}', [App\Http\Controllers\Admin\TravelController::class, 'update']);

        // tour route
        Route::put('travels/{travel}/tours', [App\Http\Controllers\Admin\TourController::class, 'update']);

    });

    
