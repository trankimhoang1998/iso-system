<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('id')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:departments,name',
            ], [
                'name.required' => 'Tên phân xưởng là bắt buộc.',
                'name.string' => 'Tên phân xưởng phải là chuỗi văn bản.',
                'name.max' => 'Tên phân xưởng không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên phân xưởng đã tồn tại.',
            ]);

            Department::create($request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Phân xưởng đã được tạo thành công!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, Department $department)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            ], [
                'name.required' => 'Tên phân xưởng là bắt buộc.',
                'name.string' => 'Tên phân xưởng phải là chuỗi văn bản.',
                'name.max' => 'Tên phân xưởng không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên phân xưởng đã tồn tại.',
            ]);

            $department->update($request->only(['name']));

            return response()->json([
                'success' => true,
                'message' => 'Phân xưởng đã được cập nhật thành công!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
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