<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BaristaController; 
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - CafeEase System
|--------------------------------------------------------------------------
*/

// 1. GUEST ROUTES
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// 2. PROTECTED ROUTES (Must be Logged In)
Route::middleware(['auth'])->group(function () {

    // Global Dashboard Redirect Logic
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'admin'   => redirect()->route('inventory.index'),
            'barista' => redirect()->route('barista.dashboard'),
            'cashier' => redirect()->route('cashier.orders'),
            default   => redirect()->route('cashier.orders'),
        };
    })->name('dashboard');

    // --- CASHIER SECTION ---
    Route::get('/cashier/orders', [OrderController::class, 'index'])->name('cashier.orders');
    
    // This handles the "Place Order" form
    Route::post('/cashier/orders', [OrderController::class, 'store'])->name('orders.store');

    // --- BARISTA SECTION ---
    Route::get('/barista/dashboard', [BaristaController::class, 'index'])->name('barista.dashboard');

    // --- ADMIN / INVENTORY SECTION ---
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/{id}/update', [InventoryController::class, 'updateStock'])->name('inventory.update');

    // --- SHARED ORDER UPDATES ---
    // We define BOTH names so both your "Finish" and "Ready" buttons work
    Route::post('/orders/{id}/update', [OrderController::class, 'updateStatus'])->name('orders.update');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // PROFILE MANAGEMENT
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';