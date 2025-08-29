<?php

namespace App\Http\Controllers\Level1;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Show documents management page for Level 1 (Ban ISO)
     */
    public function index(Request $request)
    {
        $query = Document::with(['uploader', 'approver']);

        // Level 1 can only see documents they uploaded or public documents
        $query->where(function($q) {
            $q->where('uploaded_by', auth()->id())
              ->orWhere('is_public', true);
        });

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

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        $documents->appends($request->all());

        return view('level1.documents', compact('documents'));
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

            return redirect()->route('level1.documents')->with('success', 'Tải lên tài liệu thành công!');
        }

        return redirect()->route('level1.documents')->with('error', 'Có lỗi xảy ra khi tải lên tài liệu!');
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        if (!$document->canUserDownload(auth()->user())) {
            return redirect()->route('level1.documents')->with('error', 'Bạn không có quyền tải xuống tài liệu này!');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return redirect()->route('level1.documents')->with('error', 'File không tồn tại!');
    }

    /**
     * Show permissions management page
     */
    public function permissions(Request $request)
    {
        $query = Document::with(['uploader', 'permissions.user'])
                        ->where('uploaded_by', auth()->id());

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        $documents->appends($request->all());

        // Get Level 2 users for permission assignment
        $level2Users = User::where('role', User::ROLE_LEVEL2)
                          ->where('is_active', true)
                          ->orderBy('name')
                          ->get();

        return view('level1.document-permissions', compact('documents', 'level2Users'));
    }

    /**
     * Grant permission to user
     */
    public function grantPermission(Request $request, Document $document)
    {
        // Only allow if current user uploaded the document
        if ($document->uploaded_by !== auth()->id()) {
            return redirect()->route('level1.documents.permissions')->with('error', 'Bạn không có quyền cấp phép cho tài liệu này!');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'can_view' => 'boolean',
            'can_download' => 'boolean',
        ]);

        // Check if user is Level 2
        $user = User::find($request->user_id);
        if ($user->role !== User::ROLE_LEVEL2) {
            return redirect()->route('level1.documents.permissions')->with('error', 'Chỉ có thể cấp quyền cho tài khoản Cơ quan/Phân xưởng!');
        }

        DocumentPermission::updateOrCreate(
            [
                'document_id' => $document->id,
                'user_id' => $request->user_id,
            ],
            [
                'can_view' => $request->boolean('can_view', true),
                'can_download' => $request->boolean('can_download', true),
                'granted_by' => auth()->id(),
                'granted_at' => now(),
            ]
        );

        return redirect()->route('level1.documents.permissions')->with('success', 'Đã cấp quyền thành công!');
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(Document $document, User $user)
    {
        // Only allow if current user uploaded the document
        if ($document->uploaded_by !== auth()->id()) {
            return redirect()->route('level1.documents.permissions')->with('error', 'Bạn không có quyền thu hồi quyền cho tài liệu này!');
        }

        DocumentPermission::where('document_id', $document->id)
                          ->where('user_id', $user->id)
                          ->delete();

        return redirect()->route('level1.documents.permissions')->with('success', 'Đã thu hồi quyền thành công!');
    }
}
