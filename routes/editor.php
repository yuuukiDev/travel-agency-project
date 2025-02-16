<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TravelController;
use Illuminate\Support\Facades\Route;

// // editor endpoints

Route::prefix('editor')
    ->middleware(['auth:sanctum', 'role:editor'])
    ->group(function () {

        Route::put('travels/{travel}', [TravelController::class, 'update']);

        Route::put('travels/{travel}/tours', [TourController::class, 'update']);

    });
