<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternalDocument;
use App\Models\InternalDocumentCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InternalDocumentController extends Controller
{
    public function index()
    {
        $documents = InternalDocument::with(['category', 'department'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.internal-documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = InternalDocumentCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.internal-documents.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:internal_document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/internal', $fileName, 'public');

        InternalDocument::create([
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

        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(InternalDocument $internalDocument)
    {
        $internalDocument->load(['category', 'uploader', 'department']);
        return view('admin.internal-documents.show', compact('internalDocument'));
    }

    public function edit(InternalDocument $internalDocument)
    {
        $categories = InternalDocumentCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.internal-documents.edit', compact('internalDocument', 'categories', 'departments'));
    }

    public function update(Request $request, InternalDocument $internalDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:internal_document_categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:draft,approved,archived',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:51200', // 50MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? $internalDocument->status,
        ];

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($internalDocument->file_path && Storage::disk('public')->exists($internalDocument->file_path)) {
                Storage::disk('public')->delete($internalDocument->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents/internal', $fileName, 'public');

            $updateData = array_merge($updateData, [
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
            ]);
        }

        $internalDocument->update($updateData);

        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(InternalDocument $internalDocument)
    {
        // Delete file from storage
        if ($internalDocument->file_path && Storage::disk('public')->exists($internalDocument->file_path)) {
            Storage::disk('public')->delete($internalDocument->file_path);
        }

        $internalDocument->delete();

        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(InternalDocument $internalDocument)
    {
        if (Storage::disk('public')->exists($internalDocument->file_path)) {
            return Storage::disk('public')->download($internalDocument->file_path, $internalDocument->file_name);
        }

        return redirect()->route('admin.internal-documents.index')->with('error', 'File không tồn tại!');
    }
}
