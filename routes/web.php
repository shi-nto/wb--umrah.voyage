<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationActionController;

Route::get('/', function () {
    return view('welcome');
});

// Admin reservation actions for confirm & PDF, protected by auth.
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('/reservations/{reservation}/confirm', [ReservationActionController::class, 'confirm'])
        ->name('admin.reservations.confirm');
    Route::get('/reservations/{reservation}/pdf', [ReservationActionController::class, 'pdf'])
        ->name('admin.reservations.pdf');
});
