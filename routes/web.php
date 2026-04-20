<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookRequestController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/permintaan-buku', [BookRequestController::class, 'index'])->name('permintaan.index');
    Route::post('/permintaan-buku', [App\Http\Controllers\BookRequestController::class, 'store'])->name('permintaan.store');
    Route::put('/permintaan-buku/{id}', [App\Http\Controllers\BookRequestController::class, 'update'])->name('permintaan.update');
    Route::delete('/permintaan-buku/{id}', [App\Http\Controllers\BookRequestController::class, 'destroy'])->name('permintaan.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); 
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); 
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';