<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Order;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display the ingredient-based inventory dashboard.
     */
    public function index()
    {
        // 1. Fetch ONLY Raw Materials (Hide Spanish Latte, Matcha, etc. from this list)
        $ingredients = Product::where('category', 'Raw Material')->get();
        
        // 2. Analytical stats
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::where('status', 'completed')->count();

        // 3. Low Stock Count: Only count RAW MATERIALS that are below threshold
        $lowStockCount = Product::where('category', 'Raw Material')
            ->whereColumn('stock', '<=', 'min_stock')
            ->count();

        return view('inventory.index', compact(
            'ingredients', 
            'totalRevenue', 
            'totalOrders', 
            'lowStockCount'
        ));
    }

    /**
     * Update the ingredient stock level (manual restock).
     */
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $ingredient = Product::findOrFail($id);
        
        $ingredient->update([
            'stock' => $request->stock
        ]);

        return back()->with('success', "Updated {$ingredient->name} to {$request->stock} {$ingredient->unit}.");
    }
}