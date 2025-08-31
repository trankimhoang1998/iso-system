<?php

namespace App\Http\Controllers\Level3;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get documents that the user has permission to view
        $query = Document::whereHas('permissions', function ($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('can_view', true);
        })->with(['category', 'permissions']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        // Apply document type filter
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->orderBy('updated_at', 'desc')->paginate(20);

        return view('level3.documents', compact('documents'));
    }

    public function view(Document $document)
    {
        $user = Auth::user();
        
        // Check if user has permission to view this document
        $hasPermission = DocumentPermission::where('document_id', $document->id)
            ->where('user_id', $user->id)
            ->where('can_view', true)
            ->first();

        if (!$hasPermission) {
            abort(403, 'Bạn không có quyền xem tài liệu này');
        }

        $document->load(['category', 'createdBy', 'updatedBy']);
        
        return view('level3.document-view', compact('document'));
    }

    public function download(Document $document)
    {
        $user = Auth::user();
        
        // Check if user has permission to download this document
        $hasPermission = DocumentPermission::where('document_id', $document->id)
            ->where('user_id', $user->id)
            ->where('can_download', true)
            ->first();

        if (!$hasPermission) {
            abort(403, 'Bạn không có quyền tải xuống tài liệu này');
        }

        if (!$document->file_path || !Storage::exists($document->file_path)) {
            return back()->with('error', 'Không tìm thấy file tài liệu');
        }

        return Storage::download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }
}