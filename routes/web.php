<?php

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
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');
});

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/index', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/approve-reservation/{id}', [\App\Http\Controllers\AdminController::class, 'approveReservation'])->name('admin.approveReservation');
    Route::post('/admin/deny-reservation/{id}', [\App\Http\Controllers\AdminController::class, 'denyReservation'])->name('admin.denyReservation');
    Route::delete('/admin/delete-reservation/{id}', [\App\Http\Controllers\AdminController::class, 'deleteReservation'])->name('admin.deleteReservation');

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


