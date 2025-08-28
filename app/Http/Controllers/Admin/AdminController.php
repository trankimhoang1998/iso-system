<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('role', User::ROLE_ADMIN)->where('is_active', true)->count(),
            'level1_users' => User::where('role', User::ROLE_LEVEL1)->where('is_active', true)->count(),
            'level2_users' => User::where('role', User::ROLE_LEVEL2)->where('is_active', true)->count(),
            'level3_users' => User::where('role', User::ROLE_LEVEL3)->where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show users management page
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Create new user
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|integer|in:0,1,2,3',
            'department' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:users,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'department' => $request->department,
            'parent_id' => $request->parent_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users')->with('success', 'Tạo tài khoản thành công!');
    }
}