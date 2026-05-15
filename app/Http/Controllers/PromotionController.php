<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('products')->latest()->get();
        $menuProducts = Product::whereNotIn('category', ['Raw Material'])
            ->orderBy('name')
            ->get();

        return view('inventory.promotions', compact('promotions', 'menuProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'is_active'      => 'sometimes|boolean',
            'product_ids'    => 'required|array|min:1',
            'product_ids.*'  => 'exists:products,id',
        ]);

        $promotion = Promotion::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'discount_type'  => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'is_active'      => $request->boolean('is_active'),
        ]);

        $promotion->products()->sync($request->product_ids);

        return redirect()->back()->with('success', 'Promotion created and applied to selected products!');
    }

    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Promotion removed successfully.');
    }

    public function toggle($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['is_active' => !$promotion->is_active]);
        return redirect()->back()->with('success', 'Promotion status updated.');
    }
}
