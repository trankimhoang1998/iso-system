<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsoSystemDocument;
use App\Models\IsoSystemCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IsoSystemDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = IsoSystemDocument::with(['category', 'uploader', 'department']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->where('department_id', $user->department_id);
        }

        // Uploader filter
        if ($request->filled('uploader')) {
            $query->whereHas('uploader', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->uploader}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());

        // Get all categories for filter
        $categories = IsoSystemCategory::orderBy('name')->get();

        return view('admin.iso-system-documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = IsoSystemCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.iso-system-documents.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:iso_system_categories,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/iso-system', $fileName, 'public');

        IsoSystemDocument::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? 'draft',
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(IsoSystemDocument $isoSystemDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $isoSystemDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        $isoSystemDocument->load(['category', 'uploader', 'department']);
        return view('admin.iso-system-documents.show', compact('isoSystemDocument'));
    }

    public function edit(IsoSystemDocument $isoSystemDocument)
    {
        $categories = IsoSystemCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.iso-system-documents.edit', compact('isoSystemDocument', 'categories', 'departments'));
    }

    public function update(Request $request, IsoSystemDocument $isoSystemDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:iso_system_categories,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? $isoSystemDocument->status,
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($isoSystemDocument->file_path && Storage::disk('public')->exists($isoSystemDocument->file_path)) {
                Storage::disk('public')->delete($isoSystemDocument->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/iso-system', $fileName, 'public');

            $updateData = array_merge($updateData, [
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        $isoSystemDocument->update($updateData);

        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(IsoSystemDocument $isoSystemDocument)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($isoSystemDocument->file_path)) {
            Storage::disk('public')->delete($isoSystemDocument->file_path);
        }

        $isoSystemDocument->delete();

        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(IsoSystemDocument $isoSystemDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $isoSystemDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        if (Storage::disk('public')->exists($isoSystemDocument->file_path)) {
            return Storage::disk('public')->download($isoSystemDocument->file_path, $isoSystemDocument->file_name);
        }

        return redirect()->route('admin.iso-system-documents.index')->with('error', 'File không tồn tại!');
    }
}
