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
                'is_active' => false, // New accounts start as inactive and require admin activation
            ]);

            return redirect()->route('staff.index')->with('success', 'New staff member added successfully! Account is pending activation.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not register staff. Please try again.');
        }
    }

    /**
     * Show the edit form for a staff member.
     */
    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $staffs = User::whereIn('role', ['barista', 'cashier'])->latest()->get();

        return view('inventory.staff_index', compact('staff', 'staffs'));
    }

    /**
     * Update the staff member.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:barista,cashier',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            // Only update password if provided
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            return redirect()->route('staff.index')->with('success', 'Staff member updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not update staff. Please try again.');
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

    /**
     * Toggle staff member activation status.
     */
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);

        // Security: Prevent disabling the currently logged-in admin
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change the status of your own account while logged in.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $action = $user->is_active ? 'activated' : 'deactivated';
        $message = $user->is_active 
            ? "Account activated! {$user->name} can now log in." 
            : "Account deactivated. {$user->name} cannot log in until reactivated.";

        return redirect()->route('staff.index')->with('success', $message);
    }
}
