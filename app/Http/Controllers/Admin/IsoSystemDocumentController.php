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

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
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

        // Get all categories for filter with hierarchical structure
        $categories = IsoSystemCategory::getFlatList();
        
        // Get all departments for filter
        $departments = Department::orderBy('name')->get();

        return view('admin.iso-system-documents.index', compact('documents', 'categories', 'departments'));
    }

    public function create()
    {
        $categories = IsoSystemCategory::getFlatList();
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
            'symbol' => 'nullable|string|max:255',
            'time_period' => 'nullable|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issuing_agency' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'pdf_file' => 'required|file|mimes:pdf|max:51200', // PDF file required, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ]);

        // Handle PDF file upload (required)
        $pdfFile = $request->file('pdf_file');
        $pdfFileName = time() . '_pdf_' . $pdfFile->getClientOriginalName();
        $pdfFilePath = $pdfFile->storeAs('documents/iso-system/pdf', $pdfFileName, 'public');

        // Handle Word file upload (optional)
        $wordFileName = null;
        $wordFilePath = null;
        $wordFileType = null;
        $wordFileSize = null;

        if ($request->hasFile('word_file')) {
            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/iso-system/word', $wordFileName, 'public');
            $wordFileType = $wordFile->getClientOriginalExtension();
            $wordFileSize = $wordFile->getSize();
        }

        IsoSystemDocument::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? 'draft',
            'symbol' => $request->symbol,
            'time_period' => $request->time_period,
            'document_number' => $request->document_number,
            'issuing_agency' => $request->issuing_agency,
            'summary' => $request->summary,
            // PDF file fields
            'pdf_file_name' => $pdfFileName,
            'pdf_file_path' => $pdfFilePath,
            'pdf_file_type' => $pdfFile->getClientOriginalExtension(),
            'pdf_file_size' => $pdfFile->getSize(),
            // Word file fields
            'word_file_name' => $wordFileName,
            'word_file_path' => $wordFilePath,
            'word_file_type' => $wordFileType,
            'word_file_size' => $wordFileSize,
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
        $categories = IsoSystemCategory::getFlatList();
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
            'symbol' => 'nullable|string|max:255',
            'time_period' => 'nullable|string|max:255',
            'document_number' => 'nullable|string|max:255',
            'issuing_agency' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // PDF file optional for update, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'status' => $request->status ?? $isoSystemDocument->status,
            'symbol' => $request->symbol,
            'time_period' => $request->time_period,
            'document_number' => $request->document_number,
            'issuing_agency' => $request->issuing_agency,
            'summary' => $request->summary,
        ];

        // Handle PDF file update
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF file
            if ($isoSystemDocument->pdf_file_path && Storage::disk('public')->exists($isoSystemDocument->pdf_file_path)) {
                Storage::disk('public')->delete($isoSystemDocument->pdf_file_path);
            }

            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_pdf_' . $pdfFile->getClientOriginalName();
            $pdfFilePath = $pdfFile->storeAs('documents/iso-system/pdf', $pdfFileName, 'public');

            $updateData['pdf_file_name'] = $pdfFileName;
            $updateData['pdf_file_path'] = $pdfFilePath;
            $updateData['pdf_file_type'] = $pdfFile->getClientOriginalExtension();
            $updateData['pdf_file_size'] = $pdfFile->getSize();
        }

        // Handle Word file update
        if ($request->hasFile('word_file')) {
            // Delete old Word file
            if ($isoSystemDocument->word_file_path && Storage::disk('public')->exists($isoSystemDocument->word_file_path)) {
                Storage::disk('public')->delete($isoSystemDocument->word_file_path);
            }

            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/iso-system/word', $wordFileName, 'public');

            $updateData['word_file_name'] = $wordFileName;
            $updateData['word_file_path'] = $wordFilePath;
            $updateData['word_file_type'] = $wordFile->getClientOriginalExtension();
            $updateData['word_file_size'] = $wordFile->getSize();
        }

        $isoSystemDocument->update($updateData);

        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(IsoSystemDocument $isoSystemDocument)
    {
        // Delete PDF file from storage
        if ($isoSystemDocument->pdf_file_path && Storage::disk('public')->exists($isoSystemDocument->pdf_file_path)) {
            Storage::disk('public')->delete($isoSystemDocument->pdf_file_path);
        }

        // Delete Word file from storage
        if ($isoSystemDocument->word_file_path && Storage::disk('public')->exists($isoSystemDocument->word_file_path)) {
            Storage::disk('public')->delete($isoSystemDocument->word_file_path);
        }

        $isoSystemDocument->delete();

        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(IsoSystemDocument $isoSystemDocument, $type = 'pdf')
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $isoSystemDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        if ($type === 'word' && $isoSystemDocument->word_file_path) {
            if (Storage::disk('public')->exists($isoSystemDocument->word_file_path)) {
                return Storage::disk('public')->download($isoSystemDocument->word_file_path, $isoSystemDocument->word_file_name);
            }
        } elseif ($isoSystemDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($isoSystemDocument->pdf_file_path)) {
                return Storage::disk('public')->download($isoSystemDocument->pdf_file_path, $isoSystemDocument->pdf_file_name);
            }
        }

        return redirect()->route('admin.iso-system-documents.index')->with('error', 'File không tồn tại!');
    }
}
