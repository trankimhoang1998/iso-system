<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('documents')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Get all categories with max depth of 3 (to allow max 4 levels)
        $parentCategories = Category::with('parent')
            ->active()
            ->get()
            ->filter(function ($category) {
                return $category->depth < 3; // Allow max 4 levels (0,1,2,3)
            })
            ->sortBy('full_name');

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
        ]);

        // Check depth limit (max 4 levels: 0,1,2,3)
        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            if ($parent && $parent->depth >= 3) {
                return back()->withErrors(['parent_id' => 'Không thể tạo danh mục con cho danh mục cấp 4. Hệ thống chỉ hỗ trợ tối đa 4 cấp.'])->withInput();
            }
        }

        $data = $request->only(['name', 'description', 'parent_id', 'sort_order']);
        
        if (empty($data['sort_order'])) {
            $data['sort_order'] = Category::where('parent_id', $data['parent_id'])->max('sort_order') + 1;
        }

        if (!$request->filled('slug')) {
            $data['slug'] = Str::slug($data['name']);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
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
        // Get potential parent categories, exclude current category and its descendants
        $excludeIds = $category->getAllDescendants()->pluck('id')->push($category->id)->toArray();
        
        $parentCategories = Category::with('parent')
            ->active()
            ->whereNotIn('id', $excludeIds)
            ->get()
            ->filter(function ($cat) {
                return $cat->depth < 3; // Allow max 4 levels
            })
            ->sortBy('full_name');

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Check depth limit and circular reference
        if ($request->filled('parent_id')) {
            $parent = Category::find($request->parent_id);
            if ($parent) {
                // Check if parent is a descendant of current category
                if ($category->getAllDescendants()->contains($parent->id)) {
                    return back()->withErrors(['parent_id' => 'Không thể chọn danh mục con làm danh mục cha.'])->withInput();
                }
                
                // Check depth limit
                if ($parent->depth >= 3) {
                    return back()->withErrors(['parent_id' => 'Không thể di chuyển danh mục đến cấp quá sâu. Hệ thống chỉ hỗ trợ tối đa 4 cấp.'])->withInput();
                }
            }
        }

        $data = $request->only(['name', 'description', 'parent_id', 'sort_order', 'is_active']);
        
        if ($request->filled('slug')) {
            $data['slug'] = $request->slug;
        } elseif ($category->isDirty('name')) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy(Category $category)
    {
        // Kiểm tra xem có tài liệu nào đang sử dụng danh mục này không
        if ($category->documents()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì còn có tài liệu đang sử dụng!');
        }

        // Kiểm tra xem có danh mục con nào không
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì còn có danh mục con!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
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
}