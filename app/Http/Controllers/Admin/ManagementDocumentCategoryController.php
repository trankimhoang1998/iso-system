<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementDocumentCategory;
use Illuminate\Http\Request;

class ManagementDocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = ManagementDocumentCategory::with('parent', 'children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.management-document-categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = $this->getCategoriesWithIndent();
        return view('admin.management-document-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:management_document_categories,id',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi văn bản.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Danh mục cha được chọn không hợp lệ.',
        ]);

        ManagementDocumentCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.management-document-categories.index')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }


    public function edit(ManagementDocumentCategory $managementDocumentCategory)
    {
        $parentCategories = $this->getCategoriesWithIndent($managementDocumentCategory->id);
        return view('admin.management-document-categories.edit', compact('managementDocumentCategory', 'parentCategories'));
    }

    public function update(Request $request, ManagementDocumentCategory $managementDocumentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:management_document_categories,id',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.string' => 'Tên danh mục phải là chuỗi văn bản.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Danh mục cha được chọn không hợp lệ.',
        ]);

        $managementDocumentCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.management-document-categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(ManagementDocumentCategory $managementDocumentCategory)
    {
        if ($managementDocumentCategory->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con.');
        }

        if ($managementDocumentCategory->documents()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        $managementDocumentCategory->delete();

        return redirect()->route('admin.management-document-categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }

    private function getCategoriesWithIndent($excludeId = null)
    {
        $categories = ManagementDocumentCategory::when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        $result = collect();
        
        foreach ($categories as $category) {
            $this->addCategoryWithChildren($result, $category, 0);
        }
        
        return $result;
    }

    private function addCategoryWithChildren($collection, $category, $level)
    {
        $category->indent_level = $level;
        $category->display_name = str_repeat('— ', $level) . $category->name;
        $collection->push($category);
        
        foreach ($category->children as $child) {
            $this->addCategoryWithChildren($collection, $child, $level + 1);
        }
    }
}
