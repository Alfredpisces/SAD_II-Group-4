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
            'Americano'         => ['Coffee Beans' => 18, 'Paper Cup' => 1],
            'Matcha Latte'      => ['Matcha Powder' => 15, 'Fresh Milk' => 200, 'Paper Cup' => 1],
            'Caramel Macchiato' => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Paper Cup' => 1],
            'Caffe Latte'       => ['Coffee Beans' => 18, 'Fresh Milk' => 150, 'Paper Cup' => 1],
        ];

        $selectedItems = explode(', ', $request->item_name);
        $lastOrderId = null;

        try {
            DB::transaction(function () use ($selectedItems, $recipes, &$lastOrderId) {
                foreach ($selectedItems as $rawName) {
                    // Parse quantity from "2x Spanish Latte" format
                    preg_match('/^(\d+)x\s+(.+)$/', trim($rawName), $matches);
                    $quantity = isset($matches[1]) ? (int)$matches[1] : 1;
                    $drinkName = isset($matches[2]) ? trim($matches[2]) : trim(preg_replace('/^\d+x\s+/', '', $rawName));
                    
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
                                ->lockForUpdate()
                                ->first();
                            if (!$ingredient) {
                                throw new \Exception("Ingredient '$ingredientName' not found in database!");
                            }
                            $totalNeeded = $amountNeeded * $quantity;
                            if ($ingredient->stock < $totalNeeded) {
                                throw new \Exception("Insufficient stock of $ingredientName for $drinkName. Need $totalNeeded, have {$ingredient->stock}.");
                            }
                            $ingredient->decrement('stock', $totalNeeded);
                        }
                    }

                    $order = Order::create([
                        'item_name' => $drinkName,
                        'quantity'  => $quantity,
                        'price'     => $price,
                        'total'     => $price * $quantity,
                        'status'    => 'pending',
                        'user_id'   => auth()->id() ?? 1,
                    ]);

                    $lastOrderId = $order->id;
                }
            });

            // Redirect to receipt page for printing
            return redirect()->route('cashier.receipt', $lastOrderId);

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

    /**
     * Display the receipt for printing
     */
    public function printReceipt($id)
    {
        $order = Order::findOrFail($id);
        return view('cashier.receipt', compact('order'));
    }
}