<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// public endpoints

Route::group([], function() {

        Route::get('travels', [TravelController::class, 'index']);
        Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

        Route::middleware(['throttle:5,1'])
                    ->controller(AuthController::class)
                    ->group(function(){
                
        Route::post('/register', "register");

        Route::post('/login', "login");

        Route::post('/forget-password', "forgetPassword");

        Route::post('/check-verification-code', "checkVerificationCode");
    });

});

// authenticated endpoints

Route::middleware('auth:api')
                ->controller(AuthController::class)
                ->group(function(){

    Route::post('/register/verification/', "verify")->middleware('throttle:5,1');

    Route::post('/reset-password', "resetPassword")->middleware('throttle:5,1');

    Route::post('/logout', "logout");
});


Route::middleware('auth:api')->controller(ProfileController::class)->group(function(){

    Route::post('/profile', 'update');

    Route::delete('/profiles/{profile}', 'destroy');
});

// admin endpoints

Route::prefix('admin')
            ->middleware(['auth:sanctum', 'role:admin'])
            ->controller(AdminController::class)
            ->group(function () {

    Route::post('travels', 'createTravel');

    Route::post('travels/{travel}/tours', 'createTour');

    Route::put('travels/{travel}', 'updateTravel');

    Route::delete('travels/{travel}', 'deleteTravel');

    Route::put('travels/{travel}/tours', 'updateTour');

    Route::delete('travels/{travel}/tours', 'deleteTour');
});

// editor endpoints

Route::prefix('editor')
            ->middleware(['auth:sanctum', 'role:editor'])
            ->controller(AdminController::class)
            ->group(function () {

    Route::put('travels/{travel}', 'updateTravel');

    Route::put('travels/{travel}/tours', 'updateTour');

});