<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternalDocumentCategory;
use Illuminate\Http\Request;

class InternalDocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = InternalDocumentCategory::with('parent', 'children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.internal-document-categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = $this->getCategoriesWithIndent();
        return view('admin.internal-document-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:internal_document_categories,id',
        ]);

        InternalDocumentCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.internal-document-categories.index')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }


    public function edit(InternalDocumentCategory $internalDocumentCategory)
    {
        $parentCategories = $this->getCategoriesWithIndent($internalDocumentCategory->id);
        return view('admin.internal-document-categories.edit', compact('internalDocumentCategory', 'parentCategories'));
    }

    public function update(Request $request, InternalDocumentCategory $internalDocumentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:internal_document_categories,id',
        ]);

        $internalDocumentCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.internal-document-categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(InternalDocumentCategory $internalDocumentCategory)
    {
        if ($internalDocumentCategory->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con.');
        }

        if ($internalDocumentCategory->documents()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        $internalDocumentCategory->delete();

        return redirect()->route('admin.internal-document-categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }

    private function getCategoriesWithIndent($excludeId = null)
    {
        $categories = InternalDocumentCategory::when($excludeId, function ($query) use ($excludeId) {
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
