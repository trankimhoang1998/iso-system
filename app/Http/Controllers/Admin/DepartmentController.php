<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create($request->only(['name']));

        return response()->json([
            'success' => true,
            'message' => 'Phân xưởng đã được tạo thành công!'
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update($request->only(['name']));

        return response()->json([
            'success' => true,
            'message' => 'Phân xưởng đã được cập nhật thành công!'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Phân xưởng đã được xóa thành công!'
        ]);
    }
}