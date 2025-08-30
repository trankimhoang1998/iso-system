<?php

namespace App\Http\Controllers\Level2;

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
        
        // Get documents that current user has permission to access
        $query = Document::whereHas('permissions', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['permissions' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }]);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Add pivot data for permissions
        foreach ($documents as $document) {
            $permission = $document->permissions->first();
            if ($permission) {
                $document->pivot = $permission;
            }
        }

        return view('level2.documents', compact('documents'));
    }

    public function download(Document $document)
    {
        $user = Auth::user();
        
        // Check if user has download permission
        $permission = DocumentPermission::where('document_id', $document->id)
            ->where('user_id', $user->id)
            ->where('can_download', true)
            ->first();

        if (!$permission) {
            abort(403, 'Bạn không có quyền tải xuống tài liệu này');
        }

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File không tồn tại');
        }

        return Storage::download($document->file_path, $document->original_filename);
    }

    public function view(Document $document)
    {
        $user = Auth::user();
        
        // Check if user has view permission
        $permission = DocumentPermission::where('document_id', $document->id)
            ->where('user_id', $user->id)
            ->where('can_view', true)
            ->first();

        if (!$permission) {
            abort(403, 'Bạn không có quyền xem tài liệu này');
        }

        // For now, return a simple document info view
        // In production, you might want to integrate a document viewer
        $content = [
            'title' => $document->title,
            'description' => $document->description,
            'document_type' => $document->getDocumentTypeName(),
            'version' => $document->version,
            'file_size' => $document->getFormattedFileSize(),
            'created_at' => $document->created_at->format('d/m/Y H:i'),
            'effective_date' => $document->effective_date ? $document->effective_date->format('d/m/Y') : null,
            'expiry_date' => $document->expiry_date ? $document->expiry_date->format('d/m/Y') : null,
            'tags' => $document->tags ? explode(',', $document->tags) : []
        ];

        return view('level2.document-viewer', compact('document', 'content'));
    }
}