<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/requests/{id}/details', [RequestController::class, 'getDetails']);
    Route::put('/requests/{id}/reactivate', [RequestController::class, 'reactivate']);
    Route::get('/orders/{id}/details', [OrderController::class, 'getDetails']);
    Route::get('/orders/getOrders', [OrderController::class, 'getOrders']);

});

require __DIR__.'/auth.php';
