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
     * Show the form for adding stock to ingredients.
     */
    public function create()
    {
        // Get existing ingredients to show in dropdown
        $existingIngredients = Product::where('category', 'Raw Material')
            ->orderBy('name')
            ->get();
        
        return view('inventory.create', compact('existingIngredients'));
    }

    /**
     * Add stock to existing ingredient or create new one.
     */
    public function store(Request $request)
    {
        // If adding to existing ingredient
        if ($request->filled('ingredient_id')) {
            $request->validate([
                'ingredient_id' => 'required|exists:products,id',
                'stock' => 'required|integer|min:1',
            ]);

            $ingredient = Product::findOrFail($request->ingredient_id);
            $oldStock = $ingredient->stock;
            $ingredient->increment('stock', $request->stock);

            return redirect()->route('inventory.index')
                ->with('success', "Updated {$ingredient->name}: {$oldStock} → " . ($oldStock + $request->stock) . " {$ingredient->unit}");
        }

        // If creating new ingredient
        if ($request->filled('new_ingredient_name')) {
            $request->validate([
                'new_ingredient_name' => 'required|string|max:255|unique:products,name',
                'stock' => 'required|integer|min:1',
                'unit' => 'required|string|max:100',
                'min_stock' => 'required|integer|min:0',
            ]);

            Product::create([
                'name' => $request->new_ingredient_name,
                'category' => 'Raw Material',
                'stock' => $request->stock,
                'unit' => $request->unit,
                'min_stock' => $request->min_stock,
                'price' => 0,
            ]);

            return redirect()->route('inventory.index')
                ->with('success', "New ingredient '{$request->new_ingredient_name}' created with {$request->stock} {$request->unit} stock.");
        }

        return back()->withError('Please either select an existing ingredient or create a new one.');
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