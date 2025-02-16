<?php

declare(strict_types=1);

use App\Http\Controllers\TourController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

// public routes

Route::get('travels', [TravelController::class, 'index']);

Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

// user routes

require base_path('routes/user.php');

// admin routes
require base_path('routes/admin.php');

// editor routes

require base_path('routes/editor.php');
