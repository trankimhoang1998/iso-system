<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementDocument;
use App\Models\ManagementDocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagementDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ManagementDocument::with(['category', 'uploader']);

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
        return view('admin.management-documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = ManagementDocumentCategory::orderBy('name')->get();
        return view('admin.management-documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:management_document_categories,id',
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
        $pdfFilePath = $pdfFile->storeAs('documents/management/pdf', $pdfFileName, 'public');

        // Handle Word file upload (optional)
        $wordFileName = null;
        $wordFilePath = null;
        $wordFileType = null;
        $wordFileSize = null;

        if ($request->hasFile('word_file')) {
            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/management/word', $wordFileName, 'public');
            $wordFileType = $wordFile->getClientOriginalExtension();
            $wordFileSize = $wordFile->getSize();
        }

        ManagementDocument::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
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

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(ManagementDocument $managementDocument)
    {
        $managementDocument->load(['category', 'uploader']);
        return view('admin.management-documents.show', compact('managementDocument'));
    }

    public function edit(ManagementDocument $managementDocument)
    {
        $categories = ManagementDocumentCategory::orderBy('name')->get();
        return view('admin.management-documents.edit', compact('managementDocument', 'categories'));
    }

    public function update(Request $request, ManagementDocument $managementDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:management_document_categories,id',
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
            'status' => $request->status ?? $managementDocument->status,
            'symbol' => $request->symbol,
            'time_period' => $request->time_period,
            'document_number' => $request->document_number,
            'issuing_agency' => $request->issuing_agency,
            'summary' => $request->summary,
        ];

        // Handle PDF file update
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF file
            if ($managementDocument->pdf_file_path && Storage::disk('public')->exists($managementDocument->pdf_file_path)) {
                Storage::disk('public')->delete($managementDocument->pdf_file_path);
            }

            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_pdf_' . $pdfFile->getClientOriginalName();
            $pdfFilePath = $pdfFile->storeAs('documents/management/pdf', $pdfFileName, 'public');

            $updateData['pdf_file_name'] = $pdfFileName;
            $updateData['pdf_file_path'] = $pdfFilePath;
            $updateData['pdf_file_type'] = $pdfFile->getClientOriginalExtension();
            $updateData['pdf_file_size'] = $pdfFile->getSize();
        }

        // Handle Word file update
        if ($request->hasFile('word_file')) {
            // Delete old Word file
            if ($managementDocument->word_file_path && Storage::disk('public')->exists($managementDocument->word_file_path)) {
                Storage::disk('public')->delete($managementDocument->word_file_path);
            }

            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/management/word', $wordFileName, 'public');

            $updateData['word_file_name'] = $wordFileName;
            $updateData['word_file_path'] = $wordFilePath;
            $updateData['word_file_type'] = $wordFile->getClientOriginalExtension();
            $updateData['word_file_size'] = $wordFile->getSize();
        }

        $managementDocument->update($updateData);

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(ManagementDocument $managementDocument)
    {
        // Delete PDF file from storage
        if ($managementDocument->pdf_file_path && Storage::disk('public')->exists($managementDocument->pdf_file_path)) {
            Storage::disk('public')->delete($managementDocument->pdf_file_path);
        }

        // Delete Word file from storage
        if ($managementDocument->word_file_path && Storage::disk('public')->exists($managementDocument->word_file_path)) {
            Storage::disk('public')->delete($managementDocument->word_file_path);
        }

        $managementDocument->delete();

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function download(ManagementDocument $managementDocument, $type = 'pdf')
    {
        if ($type === 'word' && $managementDocument->word_file_path) {
            if (Storage::disk('public')->exists($managementDocument->word_file_path)) {
                return Storage::disk('public')->download($managementDocument->word_file_path, $managementDocument->word_file_name);
            }
        } elseif ($managementDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($managementDocument->pdf_file_path)) {
                return Storage::disk('public')->download($managementDocument->pdf_file_path, $managementDocument->pdf_file_name);
            }
        }

        return redirect()->route('admin.management-documents.index')->with('error', 'File không tồn tại!');
    }
}
