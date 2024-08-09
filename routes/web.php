<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('calendar', [\App\Http\Controllers\ReservationController::class, 'index'])->name('calendar');

Route::get('reservation', [\App\Http\Controllers\ReservationController::class, 'create'])->middleware('auth')->name('reservation.create');
Route::post('reservation/store', [\App\Http\Controllers\ReservationController::class, 'store'])->middleware('auth')->name('reservation.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


