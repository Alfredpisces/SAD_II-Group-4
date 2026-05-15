<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::orderBy('name')->get();

        return view('inventory.staff', compact('staffs'));
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $staffs = User::orderBy('name')->get();

        return view('inventory.staff', compact('staffs', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,barista,cashier',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('staff.index')->with('success', 'New staff member added successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,barista,cashier',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully!');
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account!');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $message = $user->is_active
            ? "{$user->name}'s account has been activated."
            : "{$user->name}'s account has been deactivated.";

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own admin account!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Staff member removed.');
    }
}
