<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Make sure this line is here!

class BaristaController extends Controller
{
    // PASTE IT HERE
public function index()
{
    // ONLY show orders that are brand new or currently being made
    // This makes 'ready' or 'completed' orders vanish from this screen
    $orders = \App\Models\Order::whereIn('status', ['pending', 'preparing'])
                ->oldest()
                ->get();

    return view('barista.index', compact('orders'));
}

public function updateStatus(Request $request, $id)
{
    $order = \App\Models\Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Order updated!');
}

}