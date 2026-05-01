<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BaristaController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Feedback; 
use App\Models\Order; 
use Illuminate\Support\Facades\DB; 

/*
|--------------------------------------------------------------------------
| Web Routes - CafeEase System
|--------------------------------------------------------------------------
*/

// --- 1. GUEST & PUBLIC ROUTES ---
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); 
    }
    return view('welcome');
});

// Feedback for Customers (QR Code Target)
Route::get('/feedback-customer', function () {
    return view('feedback'); 
})->name('feedback.customer');

Route::post('/submit-feedback', function (Request $request) {
    $request->validate([
        'comments' => 'required|min:3',
        'rating' => 'required|numeric|min:1|max:5',
    ]);

    Feedback::create([
        'rating' => $request->rating, 
        'comments' => $request->comments,
    ]);

    return back()->with('success', 'Thank you for your feedback!');
});

// --- 2. PROTECTED ROUTES (Login Required) ---
Route::middleware(['auth', 'check.account.active'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'admin'   => redirect()->route('inventory.index'),
            'barista' => redirect()->route('barista.dashboard'),
            'cashier' => redirect()->route('cashier.orders'),
            default   => redirect()->route('cashier.orders'),
        };
    })->name('dashboard');

    // Cashier Routes
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

    // Barista Routes
    Route::get('/barista/dashboard', [BaristaController::class, 'index'])->name('barista.dashboard');

    // Global Order Status Update (Shared by Barista/Cashier)
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // --- 3. ADMIN ONLY ROUTES ---
    Route::middleware(['can:admin'])->prefix('admin')->group(function () {
        
        // Staff Management
        // Removing the extra prefix('staff') inside the admin prefix to avoid "staff.staff" names
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::put('/staff/{id}/toggle-active', [StaffController::class, 'toggleActive'])->name('staff.toggleActive');

        // Inventory
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::post('/inventory/{id}', [InventoryController::class, 'updateStock'])->name('inventory.update');

        // Feedback Management
        Route::get('/feedback', function() { 
            $feedbacks = Feedback::latest()->get();
            $average = $feedbacks->avg('rating') ?: 0; 
            $sentiment = $average >= 4.5 ? 'Excellent' : ($average >= 3.5 ? 'Good' : 'Average');
            return view('inventory.feedback', compact('feedbacks', 'average', 'sentiment'));
        })->name('feedback.index');

        Route::delete('/feedback/{id}', function ($id) {
            Feedback::findOrFail($id)->delete();
            return back()->with('success', 'Feedback removed successfully.');
        })->name('feedback.destroy');
        
        // Reports
        Route::get('/reports', function() { 
            $totalRevenue = Order::sum('total') ?: 0;
            $totalOrders = Order::count();
            $topProduct = Order::select('item_name', DB::raw('count(*) as total_sales'))
                ->groupBy('item_name')->orderBy('total_sales', 'desc')->first();
            $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->groupBy('date')->orderBy('date', 'asc')->take(7)->get();

            return view('inventory.reports', [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'labels' => $salesData->pluck('date'),
                'totals' => $salesData->pluck('total'),
                'feedbacks' => Feedback::all(),
                'topProduct' => $topProduct
            ]);
        })->name('reports.index');
    });

    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
}); // This correctly closes the main middleware(['auth']) group

require __DIR__.'/auth.php';