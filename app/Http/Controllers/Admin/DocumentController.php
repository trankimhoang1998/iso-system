<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Show documents management page
     */
    public function index(Request $request)
    {
        $query = Document::with(['uploader', 'approver', 'documentType', 'category']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Document type filter
        if ($request->filled('document_type_id')) {
            $query->where('document_type_id', $request->document_type_id);
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

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());
        
        // Get document type info if filtered
        $documentType = null;
        if ($request->filled('document_type_id')) {
            $documentType = \App\Models\DocumentType::find($request->document_type_id);
        }
        
        // Get all document types for filter
        $documentTypes = \App\Models\DocumentType::all();

        return view('admin.documents.index', compact('documents', 'documentType', 'documentTypes'));
    }

    /**
     * Show create document form
     */
    public function create(Request $request)
    {
        $documentTypes = \App\Models\DocumentType::all();
        
        // Get document type if specified
        $selectedDocumentType = null;
        if ($request->filled('document_type_id')) {
            $selectedDocumentType = \App\Models\DocumentType::find($request->document_type_id);
        }
        
        return view('admin.documents.create', compact('documentTypes', 'selectedDocumentType'));
    }

    /**
     * Upload new document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type_id' => 'required|exists:document_types,id',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            'is_public' => 'boolean',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề tài liệu.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'document_type_id.required' => 'Vui lòng chọn loại tài liệu.',
            'document_type_id.exists' => 'Loại tài liệu được chọn không hợp lệ.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'file.required' => 'Vui lòng chọn file tải lên.',
            'file.max' => 'Kích thước file không được vượt quá 50MB.',
            'file.mimes' => 'File phải có định dạng: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');
            
            Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'document_type_id' => $request->document_type_id,
                'category_id' => $request->category_id,
                'uploaded_by' => auth()->id(),
                'is_public' => $request->boolean('is_public', false),
            ]);

            return redirect()->route('admin.documents.index')->with('success', 'Tải lên tài liệu thành công!');
        }

        return redirect()->route('admin.documents.index')->with('error', 'Có lỗi xảy ra khi tải lên tài liệu!');
    }

    /**
     * Show document detail page
     */
    public function show(Document $document)
    {
        $document->load(['uploader', 'approver', 'documentType', 'category']);
        return view('admin.documents.show', compact('document'));
    }


    /**
     * Show edit document form
     */
    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Update document
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type_id' => 'required|exists:document_types,id',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            'is_public' => 'boolean',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề tài liệu.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'document_type_id.required' => 'Vui lòng chọn loại tài liệu.',
            'document_type_id.exists' => 'Loại tài liệu được chọn không hợp lệ.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'file.max' => 'Kích thước file không được vượt quá 50MB.',
            'file.mimes' => 'File phải có định dạng: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'document_type_id' => $request->document_type_id,
            'category_id' => $request->category_id,
            'is_public' => $request->boolean('is_public', false),
        ];

        // Handle file replacement if uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Delete old file
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Store new file
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');
            
            // Update file-related data
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_path'] = $filePath;
            $updateData['file_type'] = $file->getClientOriginalExtension();
            $updateData['file_size'] = $file->getSize();
        }

        $document->update($updateData);

        return redirect()->route('admin.documents.index')->with('success', 'Cập nhật tài liệu thành công!');
    }

    /**
     * Delete document
     */
    public function destroy(Document $document)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Đã xóa tài liệu thành công!');
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return redirect()->route('admin.documents.index')->with('error', 'File không tồn tại!');
    }

    /**
     * Approve document
     */
    public function approve(Document $document)
    {
        $document->update([
            'status' => Document::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Đã phê duyệt tài liệu thành công!');
    }

    /**
     * Revoke document approval
     */
    public function revokeApproval(Document $document)
    {
        $document->update([
            'status' => Document::STATUS_DRAFT,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Đã hủy phê duyệt tài liệu thành công!');
    }
}
