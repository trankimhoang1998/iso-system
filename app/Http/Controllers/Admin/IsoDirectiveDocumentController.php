<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsoDirectiveDocument;
use App\Models\IsoDirectiveCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IsoDirectiveDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = IsoDirectiveDocument::with(['category', 'uploader', 'department']);

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
        $categories = IsoDirectiveCategory::orderBy('name')->get();

        return view('admin.iso-directive-documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = IsoDirectiveCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.iso-directive-documents.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:iso_directive_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/iso-directive', $fileName, 'public');

        IsoDirectiveDocument::create([
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

        return redirect()->route('admin.iso-directive-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(IsoDirectiveDocument $isoDirectiveDocument)
    {
        $isoDirectiveDocument->load(['category', 'uploader', 'department']);
        return view('admin.iso-directive-documents.show', compact('isoDirectiveDocument'));
    }

    public function edit(IsoDirectiveDocument $isoDirectiveDocument)
    {
        $categories = IsoDirectiveCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.iso-directive-documents.edit', compact('isoDirectiveDocument', 'categories', 'departments'));
    }

    public function update(Request $request, IsoDirectiveDocument $isoDirectiveDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:iso_directive_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? $isoDirectiveDocument->status,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($isoDirectiveDocument->file_path)) {
                Storage::disk('public')->delete($isoDirectiveDocument->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/iso-directive', $fileName, 'public');

            $updateData['file_name'] = $fileName;
            $updateData['file_path'] = $filePath;
            $updateData['file_type'] = $file->getClientOriginalExtension();
            $updateData['file_size'] = $file->getSize();
        }

        $isoDirectiveDocument->update($updateData);

        return redirect()->route('admin.iso-directive-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(IsoDirectiveDocument $isoDirectiveDocument)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($isoDirectiveDocument->file_path)) {
            Storage::disk('public')->delete($isoDirectiveDocument->file_path);
        }

        $isoDirectiveDocument->delete();

        return redirect()->route('admin.iso-directive-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(IsoDirectiveDocument $isoDirectiveDocument)
    {
        if (Storage::disk('public')->exists($isoDirectiveDocument->file_path)) {
            return Storage::disk('public')->download($isoDirectiveDocument->file_path, $isoDirectiveDocument->file_name);
        }

        return redirect()->route('admin.iso-directive-documents.index')->with('error', 'File không tồn tại!');
    }

}
