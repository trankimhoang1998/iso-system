<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show users management page
     */
    public function index(Request $request)
    {
        $query = User::with('department');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
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
            $query->where('department_id', $request->department);
        }

        $users = $query->orderBy('id')->paginate(20);
        
        // Preserve query parameters in pagination links
        $users->appends($request->all());

        // Get departments for the department selection dropdown
        $departments = Department::orderBy('id')->get();

        return view('admin.users.index', compact('users', 'departments'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
        $departments = Department::orderBy('id')->get();
        return view('admin.users.create', compact('departments'));
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|integer|in:0,1,2,3',
        ];

        // Add department_id validation for roles 2 and 3
        if (in_array($request->role, [2, 3])) {
            $rules['department_id'] = 'required|exists:departments,id';
        }

        $request->validate($rules, [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.max' => 'Tên đăng nhập không được vượt quá 255 ký tự.',
            'username.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vui lòng chọn phân quyền.',
            'role.in' => 'Phân quyền được chọn không hợp lệ.',
            'department_id.required' => 'Vui lòng chọn phân xưởng.',
            'department_id.exists' => 'Phân xưởng được chọn không tồn tại.',
        ]);

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];

        // Add department_id for roles 2 and 3
        if (in_array($request->role, [2, 3])) {
            $userData['department_id'] = $request->department_id;
        }

        User::create($userData);

        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Show edit user form
     */
    public function edit(User $user)
    {
        $departments = Department::orderBy('id')->get();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|integer|in:0,1,2,3',
            'is_active' => 'boolean',
        ];

        // Add department_id validation for roles 2 and 3
        if (in_array($request->role, [2, 3])) {
            $rules['department_id'] = 'required|exists:departments,id';
        }

        $request->validate($rules, [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.max' => 'Tên đăng nhập không được vượt quá 255 ký tự.',
            'username.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vui lòng chọn phân quyền.',
            'role.in' => 'Phân quyền được chọn không hợp lệ.',
            'department_id.required' => 'Vui lòng chọn phân xưởng.',
            'department_id.exists' => 'Phân xưởng được chọn không tồn tại.',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', true),
        ];

        // Add department_id for roles 2 and 3, null for others
        if (in_array($request->role, [2, 3])) {
            $updateData['department_id'] = $request->department_id;
        } else {
            $updateData['department_id'] = null;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản hiện tại!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa tài khoản thành công!');
    }
}