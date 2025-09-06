<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsoDirectiveCategory;
use Illuminate\Http\Request;

class IsoDirectiveCategoryController extends Controller
{
    public function index()
    {
        $categories = IsoDirectiveCategory::with('parent', 'children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.iso-directive-categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = $this->getCategoriesWithIndent();
        return view('admin.iso-directive-categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:iso_directive_categories,id',
        ]);

        IsoDirectiveCategory::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.iso-directive-categories.index')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }


    public function edit(IsoDirectiveCategory $isoDirectiveCategory)
    {
        $parentCategories = $this->getCategoriesWithIndent($isoDirectiveCategory->id);
        return view('admin.iso-directive-categories.edit', compact('isoDirectiveCategory', 'parentCategories'));
    }

    public function update(Request $request, IsoDirectiveCategory $isoDirectiveCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:iso_directive_categories,id',
        ]);

        $isoDirectiveCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.iso-directive-categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(IsoDirectiveCategory $isoDirectiveCategory)
    {
        // Check if category has children or documents
        if ($isoDirectiveCategory->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con.');
        }

        if ($isoDirectiveCategory->documents()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        $isoDirectiveCategory->delete();

        return redirect()->route('admin.iso-directive-categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }

    private function getCategoriesWithIndent($excludeId = null)
    {
        $categories = IsoDirectiveCategory::when($excludeId, function ($query) use ($excludeId) {
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
