<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::whereNotIn('category', ['Raw Material'])->get();

        return view('cashier.index', compact('products'));
    }

    public function store(Request $request)
    {
        // Ingredient recipes per menu item (raw-material deduction map)
        $recipes = [
            'Spanish Latte'     => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Condensed Milk' => 30, 'Paper Cup' => 1],
            'Americano'         => ['Coffee Beans' => 18, 'Water' => 200, 'Paper Cup' => 1],
            'Matcha Latte'      => ['Matcha Powder' => 15, 'Fresh Milk' => 200, 'Paper Cup' => 1],
            'Caramel Macchiato' => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Paper Cup' => 1],
        ];

        $selectedItems = explode(', ', $request->item_name);

        try {
            DB::transaction(function () use ($selectedItems, $recipes) {
                foreach ($selectedItems as $drinkName) {
                    $drinkName = trim($drinkName);

                    // Load price from the database
                    $product = Product::where('name', $drinkName)->first();
                    if (!$product) {
                        throw new \Exception("Menu item \"$drinkName\" not found.");
                    }
                    $price = $product->price;

                    // Deduct raw-material stock if a recipe exists
                    if (isset($recipes[$drinkName])) {
                        foreach ($recipes[$drinkName] as $ingredientName => $amountNeeded) {
                            $ingredient = Product::where('name', $ingredientName)
                                ->where('category', 'Raw Material')
                                ->first();
                            if (!$ingredient || $ingredient->stock < $amountNeeded) {
                                throw new \Exception("Insufficient stock of $ingredientName for $drinkName.");
                            }
                            $ingredient->decrement('stock', $amountNeeded);
                        }
                    }

                    Order::create([
                        'item_name' => $drinkName,
                        'quantity'  => 1,
                        'price'     => $price,
                        'total'     => $price,
                        'status'    => 'pending',
                        'user_id'   => auth()->id() ?? 1,
                    ]);
                }
            });

            return back()->with('success', 'Orders sent to Barista!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Update the status (preparing, ready, or completed)
        $order->update(['status' => $request->status ?? 'completed']);

        // Notification text based on status
        $message = "Order #{$order->id} ({$order->item_name}) is now " . strtoupper($order->status) . "!";

        return back()->with('notification', $message);
    }
}