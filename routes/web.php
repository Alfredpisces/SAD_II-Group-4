<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BaristaController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// --- 2. PROTECTED ROUTES ---
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'admin'   => redirect()->route('inventory.index'),
            'barista' => redirect()->route('barista.dashboard'),
            'cashier' => redirect()->route('cashier.orders'),
            default   => redirect()->route('cashier.orders'),
        };
    })->name('dashboard');

    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

    Route::get('/barista/dashboard', [BaristaController::class, 'index'])->name('barista.dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::post('/inventory/{id}', [InventoryController::class, 'updateStock'])->name('inventory.update');

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
        
        // --- FIXED REPORTS ROUTE ---
        Route::get('/reports', function() { 
            // 1. Total Stats
            $totalRevenue = Order::sum('total') ?: 0;
            $totalOrders = Order::count();

            // 2. Best Seller Logic (Uses 'item_name' from your migration)
            $topProduct = Order::select('item_name', DB::raw('count(*) as total_sales'))
                ->groupBy('item_name')
                ->orderBy('total_sales', 'desc')
                ->first();

            // 3. 7-Day Sales Trend
            $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total) as total')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->take(7)
                ->get();

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

    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';