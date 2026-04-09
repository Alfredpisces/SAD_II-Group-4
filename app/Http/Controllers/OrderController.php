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
        $products = [
            (object)['name' => 'Spanish Latte', 'price' => 120.00, 'category' => 'Coffee'],
            (object)['name' => 'Americano', 'price' => 100.00, 'category' => 'Coffee'],
            (object)['name' => 'Caramel Macchiato', 'price' => 135.00, 'category' => 'Coffee'],
        ];

        return view('cashier.index', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Define Recipes and Prices
        $menuData = [
            'Spanish Latte' => [
                'price' => 120,
                'ingredients' => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Condensed Milk' => 30, 'Paper Cup' => 1]
            ],
            'Americano' => [
                'price' => 100,
                'ingredients' => ['Coffee Beans' => 18, 'Paper Cup' => 1]
            ],
            'Caramel Macchiato' => [
                'price' => 135,
                'ingredients' => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Paper Cup' => 1]
            ]
        ];

        // 2. CRITICAL FIX: Split the string from the cart into an array
        // Your JS sends "Spanish Latte, Americano", so we explode it.
        $selectedItems = explode(', ', $request->item_name);

        try {
            DB::transaction(function () use ($selectedItems, $menuData) {
                foreach ($selectedItems as $drinkName) {
                    $drinkName = trim($drinkName); // Clean up whitespace
                    
                    if (!isset($menuData[$drinkName])) {
                        throw new \Exception("Recipe for $drinkName not found!");
                    }

                    $recipe = $menuData[$drinkName]['ingredients'];
                    $price = $menuData[$drinkName]['price'];

                    // 3. Deduct Stock for EACH ingredient
                    foreach ($recipe as $ingredientName => $amountNeeded) {
                        $product = Product::where('name', $ingredientName)->first();

                        if (!$product || $product->stock < $amountNeeded) {
                            throw new \Exception("Insufficient stock of $ingredientName for $drinkName");
                        }

                        $product->decrement('stock', $amountNeeded);
                    }

                    // 4. Create a separate row for the Barista to see
                    Order::create([
                        'item_name' => $drinkName,
                        'quantity' => 1,
                        'price' => $price,
                        'total' => $price,
                        'status' => 'pending',
                        'user_id' => auth()->id() ?? 1
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