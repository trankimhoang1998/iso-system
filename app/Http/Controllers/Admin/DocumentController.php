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
        $query = Document::with(['uploader', 'approver']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Document type filter
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
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

        return view('admin.documents', compact('documents'));
    }

    /**
     * Upload new document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:policy,procedure,form,manual,report,other',
            'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            'version' => 'nullable|string|max:20',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'tags' => 'nullable|string',
            'is_public' => 'boolean',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề tài liệu.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'document_type.required' => 'Vui lòng chọn loại tài liệu.',
            'document_type.in' => 'Loại tài liệu được chọn không hợp lệ.',
            'file.required' => 'Vui lòng chọn file tải lên.',
            'file.max' => 'Kích thước file không được vượt quá 50MB.',
            'file.mimes' => 'File phải có định dạng: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
            'version.max' => 'Phiên bản không được vượt quá 20 ký tự.',
            'expiry_date.after' => 'Ngày hết hiệu lực phải sau ngày có hiệu lực.',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');
            
            // Process tags
            $tags = null;
            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->tags));
            }

            Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'document_type' => $request->document_type,
                'version' => $request->version ?: '1.0',
                'uploaded_by' => auth()->id(),
                'effective_date' => $request->effective_date,
                'expiry_date' => $request->expiry_date,
                'tags' => $tags,
                'is_public' => $request->boolean('is_public', false),
            ]);

            return redirect()->route('admin.documents')->with('success', 'Tải lên tài liệu thành công!');
        }

        return redirect()->route('admin.documents')->with('error', 'Có lỗi xảy ra khi tải lên tài liệu!');
    }

    /**
     * Get document data for editing
     */
    public function edit(Document $document)
    {
        return response()->json([
            'success' => true,
            'document' => [
                'id' => $document->id,
                'title' => $document->title,
                'description' => $document->description,
                'document_type' => $document->document_type,
                'version' => $document->version,
                'effective_date' => $document->effective_date ? $document->effective_date->format('Y-m-d') : null,
                'expiry_date' => $document->expiry_date ? $document->expiry_date->format('Y-m-d') : null,
                'tags' => $document->tags ? implode(', ', $document->tags) : '',
                'is_public' => $document->is_public,
            ]
        ]);
    }

    /**
     * Update document
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_type' => 'required|in:policy,procedure,form,manual,report,other',
            'file' => 'nullable|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
            'version' => 'nullable|string|max:20',
            'effective_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'tags' => 'nullable|string',
            'is_public' => 'boolean',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề tài liệu.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'document_type.required' => 'Vui lòng chọn loại tài liệu.',
            'document_type.in' => 'Loại tài liệu được chọn không hợp lệ.',
            'file.max' => 'Kích thước file không được vượt quá 50MB.',
            'file.mimes' => 'File phải có định dạng: pdf, doc, docx, xls, xlsx, ppt, pptx, txt.',
            'version.max' => 'Phiên bản không được vượt quá 20 ký tự.',
            'expiry_date.after' => 'Ngày hết hiệu lực phải sau ngày có hiệu lực.',
        ]);

        // Process tags
        $tags = null;
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
        }

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'document_type' => $request->document_type,
            'version' => $request->version ?: $document->version,
            'effective_date' => $request->effective_date,
            'expiry_date' => $request->expiry_date,
            'tags' => $tags,
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

        return redirect()->route('admin.documents')->with('success', 'Cập nhật tài liệu thành công!');
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

        return redirect()->route('admin.documents')->with('success', 'Đã xóa tài liệu thành công!');
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return redirect()->route('admin.documents')->with('error', 'File không tồn tại!');
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

        return redirect()->route('admin.documents')->with('success', 'Đã phê duyệt tài liệu thành công!');
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

        return redirect()->route('admin.documents')->with('success', 'Đã hủy phê duyệt tài liệu thành công!');
    }
}
