<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Added for security checks

class StaffController extends Controller
{
    public function index()
    {
        // This gets all users so you can see them in your table
        // We exclude the current user from the list if you don't want to delete yourself by accident
        $staffs = User::all(); 
        return view('inventory.staff', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,barista,cashier' // Specific roles to prevent DB errors
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'New staff member added successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // SECURITY: Prevent the logged-in admin from deleting their own account
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Staff member removed.');
    }
}