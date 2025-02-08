<?php

declare(strict_types=1);

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/download-ticket/{orderId}', [TicketController::class, 'download'])->name('ticket.download');
