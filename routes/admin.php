<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourImageController;
use App\Http\Controllers\Admin\TravelController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        // travel routes
        Route::controller(TravelController::class)->group(function (): void {
            Route::post('travels', 'store');
            Route::put('travels/{travel}', 'update');
            Route::delete('travels/{travel}', 'destroy');
        });
        // tour routes
        Route::controller(TourController::class)->group(function (): void {
            Route::post('travels/{travel}/tours', 'store');
            Route::put('travels/{travel}/tours/{tour}', 'update');
            Route::delete('travels/{travel}/tours/{tour}', 'destroy');
        });

        Route::controller(TourImageController::class)->group(function (): void {
            Route::post('tours/{tour}', 'store');
            Route::post('tours/{tour}/images/{tour_image_id}', 'update');
            Route::delete('tours/{tour}/images/{tour_image_id}', 'destroy');
        });
    });
