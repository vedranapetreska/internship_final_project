<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('reservation/index', [\App\Http\Controllers\ReservationController::class, 'index'])->name('reservation.index');

Route::get('reservation', [\App\Http\Controllers\ReservationController::class, 'create'])->middleware('auth')->name('reservation.create');
Route::post('reservation/store', [\App\Http\Controllers\ReservationController::class, 'store'])->middleware('auth')->name('reservation.store');

// routes/web.php

Route::get('/reservations', [ReservationController::class, 'show'])->name('reservation.show');
Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->middleware('auth')->name('reservation.edit');
Route::put('/reservation/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


