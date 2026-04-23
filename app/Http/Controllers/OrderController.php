<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $selectedItems = explode(', ', $request->item_name);

        try {
            DB::transaction(function () use ($selectedItems, $menuData) {
                foreach ($selectedItems as $rawName) {
                    $drinkName = trim(preg_replace('/^\d+x\s+/', '', $rawName));
                    
                    if (!isset($menuData[$drinkName])) {
                        throw new \Exception("Recipe for '$drinkName' not found!");
                    }

                    $recipe = $menuData[$drinkName]['ingredients'];
                    $price = $menuData[$drinkName]['price'];

                    foreach ($recipe as $ingredientName => $amountNeeded) {
                        $product = Product::where('name', trim($ingredientName))->lockForUpdate()->first();

                        if (!$product) {
                            throw new \Exception("Product '$ingredientName' not found in database!");
                        }

                        if ($product->stock < $amountNeeded) {
                            throw new \Exception("Insufficient stock: $ingredientName.");
                        }

                        $product->decrement('stock', $amountNeeded);
                    }

                    Order::create([
                        'item_name'  => $drinkName,
                        'quantity'   => 1,
                        'price'      => $price,
                        'total'      => $price,
                        'status'     => 'pending',
                        'user_id'    => Auth::id() ?? 1 
                    ]);
                }
            });

            return back()->with('success', "Order sent to Barista!");

        } catch (\Exception $e) {
            dd("ERROR SAVING ORDER: " . $e->getMessage());
        }
    }

    // THIS IS THE PART YOU WERE MISSING
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Update the status to 'ready' or 'preparing' based on the button clicked
        $order->update([
            'status' => $request->status ?? 'completed'
        ]);

        return back()->with('success', "Order #$id status updated!");
    }
}