<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display the Staff Management dashboard.
     */
    public function index()
    {
        // Fetch users with staff-related roles
        // You can use User::all() if you want to see everyone, 
        // but filtering by role keeps the management focused.
        $staffs = User::whereIn('role', ['barista', 'cashier'])
                      ->latest()
                      ->get();

        return view('inventory.staff_index', compact('staffs'));
    }

    /**
     * Store a newly created staff member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:barista,cashier',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect()->route('staff.index')->with('success', 'New staff member added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not register staff. Please try again.');
        }
    }

    /**
     * Remove the staff member.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Security: Prevent deleting the currently logged-in admin
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account while logged in.');
        }

        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member removed from the system.');
    }
}