<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $documentTypeId = $request->get('document_type_id');
        $isAjax = $request->get('ajax');
        
        // Load all document types with category counts
        $documentTypes = DocumentType::withCount('categories')->get();
        
        // Handle AJAX request for specific document type
        if ($isAjax && $documentTypeId) {
            $documentType = DocumentType::findOrFail($documentTypeId);
            
            $categories = Category::with('parent', 'children')
                ->where('document_type_id', $documentTypeId)
                ->whereNull('parent_id')
                ->orderBy('name')
                ->get();

            if ($categories->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'html' => ''
                ]);
            }

            $html = '';
            foreach ($categories as $category) {
                $html .= view('admin.categories.partials.category-item', [
                    'category' => $category, 
                    'level' => 0
                ])->render();
            }

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }

        // Regular page load - return view with all document types
        return view('admin.categories.index', compact('documentTypes'));
    }

    public function create(Request $request)
    {
        $documentTypeId = $request->get('document_type_id');
        $documentType = null;
        
        if ($documentTypeId) {
            $documentType = DocumentType::findOrFail($documentTypeId);
        }

        $parentCategories = $this->getCategoriesWithIndent($documentTypeId);

        $documentTypes = DocumentType::all();

        return view('admin.categories.create', compact('parentCategories', 'documentType', 'documentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'document_type_id' => $request->document_type_id,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index', ['document_type_id' => $category->document_type_id])
            ->with('success', 'Danh mục đã được tạo thành công.');
    }

    public function show(Category $category)
    {
        $category->load(['parent', 'children.children', 'documents' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = $this->getCategoriesWithIndent($category->document_type_id, $category->id);

        $documentTypes = DocumentType::all();

        return view('admin.categories.edit', compact('category', 'parentCategories', 'documentTypes'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type_id' => 'required|exists:document_types,id',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update([
            'name' => $request->name,
            'document_type_id' => $request->document_type_id,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index', ['document_type_id' => $category->document_type_id])
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(Category $category)
    {
        $documentTypeId = $category->document_type_id;
        
        // Check if category has children or documents
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con.');
        }

        if ($category->documents()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index', ['document_type_id' => $documentTypeId])
            ->with('success', 'Danh mục đã được xóa thành công.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer|min:0',
            'categories.*.parent_id' => 'nullable|exists:categories,id',
        ]);

        foreach ($request->categories as $categoryData) {
            Category::where('id', $categoryData['id'])
                ->update([
                    'sort_order' => $categoryData['sort_order'],
                    'parent_id' => $categoryData['parent_id'] ?? null,
                ]);
        }

        return response()->json(['message' => 'Thứ tự danh mục đã được cập nhật!']);
    }

    public function toggle(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'message' => 'Trạng thái danh mục đã được cập nhật!',
            'is_active' => $category->is_active
        ]);
    }

    public function getChildren(Category $category)
    {
        $children = $category->children()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json($children);
    }

    private function getCategoriesWithIndent($documentTypeId, $excludeId = null)
    {
        $categories = Category::when($documentTypeId, function ($query) use ($documentTypeId) {
                return $query->where('document_type_id', $documentTypeId);
            })
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
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

    public function getByDocumentType($documentTypeId)
    {
        $categories = Category::where('document_type_id', $documentTypeId)
            ->with('children.children.children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $result = collect();
        
        foreach ($categories as $category) {
            $this->addCategoryWithChildren($result, $category, 0);
        }
        
        return response()->json($result->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->display_name,
                'level' => $category->indent_level
            ];
        }));
    }
}