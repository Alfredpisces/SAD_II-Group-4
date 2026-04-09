<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Make sure this line is here!

class BaristaController extends Controller
{
    // PASTE IT HERE
public function index()
{
    // This will now catch all individual rows created by the loop above
    $orders = \App\Models\Order::whereIn('status', ['pending', 'preparing'])
                ->orderBy('created_at', 'desc')
                ->get();

    return view('barista.index', compact('orders'));
}
}