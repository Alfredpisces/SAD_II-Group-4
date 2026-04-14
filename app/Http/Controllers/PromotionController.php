<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();
        return view('inventory.promotions', compact('promotions'));
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
        ]);

        Promotion::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'discount_type'  => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'is_active'      => $request->has('is_active') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Promotion created successfully!');
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
