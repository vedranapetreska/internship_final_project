<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('aboutUs');
});

Route::get('/reservations/index', [\App\Http\Controllers\ReservationController::class, 'index'])->name('reservation.index');

Route::middleware(['auth','user'])->group(function () {
    Route::get('/reservations/create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservations/store', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservations', [ReservationController::class, 'show'])->name('reservation.show');
    Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservation.cancel');

});

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/approve-reservation/{id}', [AdminController::class, 'approveReservation'])->name('admin.approveReservation');
    Route::post('/admin/deny-reservation/{id}', [AdminController::class, 'denyReservation'])->name('admin.denyReservation');
    Route::delete('/admin/delete-reservation/{id}', [AdminController::class, 'softDeleteReservation'])->name('admin.deleteReservation');
    Route::get('/admin/reservation/deleted', [AdminController::class, 'showDeletedReservations'])->name('admin.deleted');
    Route::post('/admin/reservation/restore/{id}', [AdminController::class, 'RestoreReservation'])->name('admin.restore');



});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified','user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


