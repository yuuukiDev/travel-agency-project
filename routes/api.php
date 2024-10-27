<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
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

    Route::controller(CartController::class)->group(function(){
        Route::post('/carts', 'store');
        Route::put('/carts/{cart}', 'update');
        Route::delete('/carts/{cart}', 'destroy');
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

        // problem here
        Route::controller(App\Http\Controllers\Admin\TourImageController::class)->group(function () {
            Route::post('travels/{travel}/tours/images', 'store');
            Route::put('travels/{travel}/tours/images/{image}', 'update');
            Route::delete('travels/{travel}/tours/images/{image}', 'destroy');
        });
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
