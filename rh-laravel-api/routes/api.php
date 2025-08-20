<?php

use App\Http\Controllers\Reservation\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/reservations/new', [ReservationController::class, 'createNewReservation'])->name('reservations.create');
Route::get('/reservations/all', [ReservationController::class, 'getAllReservations'])->name('reservations.all');
Route::get('/reservations/find', [ReservationController::class, 'findReservations'])->name('reservations.find');
Route::put('/reservations/update', [ReservationController::class, 'updateReservation'])->name('reservations.update');
Route::delete('reservations/delete/{id}', [ReservationController::class, 'deleteReservation'])->name('reservations.delete');

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});