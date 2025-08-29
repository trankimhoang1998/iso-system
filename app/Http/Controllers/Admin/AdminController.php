<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    public function users(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', 'like', "%{$request->department}%");
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Preserve query parameters in pagination links
        $users->appends($request->all());

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
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vui lòng chọn phân quyền.',
            'role.in' => 'Phân quyền được chọn không hợp lệ.',
            'department.max' => 'Tên cơ quan/phòng ban không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Tài khoản cấp trên được chọn không tồn tại.',
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

    /**
     * Get user data for editing
     */
    public function editUser(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => $user->only(['id', 'name', 'email', 'role', 'department', 'parent_id', 'is_active'])
        ]);
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|integer|in:0,1,2,3',
            'department' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vui lòng chọn phân quyền.',
            'role.in' => 'Phân quyền được chọn không hợp lệ.',
            'department.max' => 'Tên cơ quan/phòng ban không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Tài khoản cấp trên được chọn không tồn tại.',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department' => $request->department,
            'parent_id' => $request->parent_id,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Không thể xóa tài khoản hiện tại!');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Đã xóa tài khoản thành công!');
    }
}