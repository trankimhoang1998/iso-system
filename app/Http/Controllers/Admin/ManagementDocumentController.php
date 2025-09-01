<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementDocument;
use App\Models\ManagementDocumentCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagementDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ManagementDocument::with(['category', 'uploader', 'department']);

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
        $categories = ManagementDocumentCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.management-documents.index', compact('documents', 'categories', 'departments'));
    }

    public function create()
    {
        $categories = ManagementDocumentCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.management-documents.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:management_document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/management', $fileName, 'public');

        ManagementDocument::create([
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

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(ManagementDocument $managementDocument)
    {
        $managementDocument->load(['category', 'uploader', 'department']);
        return view('admin.management-documents.show', compact('managementDocument'));
    }

    public function edit(ManagementDocument $managementDocument)
    {
        $categories = ManagementDocumentCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.management-documents.edit', compact('managementDocument', 'categories', 'departments'));
    }

    public function update(Request $request, ManagementDocument $managementDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:management_document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? $managementDocument->status,
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($managementDocument->file_path && Storage::disk('public')->exists($managementDocument->file_path)) {
                Storage::disk('public')->delete($managementDocument->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/management', $fileName, 'public');

            $updateData = array_merge($updateData, [
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        $managementDocument->update($updateData);

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(ManagementDocument $managementDocument)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($managementDocument->file_path)) {
            Storage::disk('public')->delete($managementDocument->file_path);
        }

        $managementDocument->delete();

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(ManagementDocument $managementDocument)
    {
        if (Storage::disk('public')->exists($managementDocument->file_path)) {
            return Storage::disk('public')->download($managementDocument->file_path, $managementDocument->file_name);
        }

        return redirect()->route('admin.management-documents.index')->with('error', 'File không tồn tại!');
    }
}
