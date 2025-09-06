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


        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());

        // Get all categories for filter with hierarchical structure
        $categories = ManagementDocumentCategory::getFlatList();
        return view('admin.management-documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = ManagementDocumentCategory::getFlatList();
        return view('admin.management-documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:management_document_categories,id',
            'status' => 'nullable|in:draft,approved,archived',
            'symbol' => 'nullable|string|max:255',
            'issued_year' => 'nullable|integer|digits:4',
            'document_number' => 'nullable|string|max:255',
            'issuing_agency' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'pdf_file' => 'required|file|mimes:pdf|max:51200', // PDF file required, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'title.required' => 'Tiêu đề tài liệu là bắt buộc.',
            'title.string' => 'Tiêu đề tài liệu phải là chuỗi văn bản.',
            'title.max' => 'Tiêu đề tài liệu không được vượt quá 255 ký tự.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'status.in' => 'Trạng thái được chọn không hợp lệ.',
            'symbol.string' => 'Ký hiệu phải là chuỗi văn bản.',
            'symbol.max' => 'Ký hiệu không được vượt quá 255 ký tự.',
            'issued_year.integer' => 'Năm ban hành phải là số nguyên.',
            'issued_year.digits' => 'Năm ban hành phải có đúng 4 chữ số.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
            'summary.max' => 'Trích yếu không được vượt quá 1000 ký tự.',
            'pdf_file.required' => 'File PDF là bắt buộc.',
            'pdf_file.file' => 'PDF phải là một file.',
            'pdf_file.mimes' => 'File PDF phải có định dạng: pdf.',
            'pdf_file.max' => 'File PDF không được vượt quá 50MB.',
            'word_file.file' => 'Word phải là một file.',
            'word_file.mimes' => 'File Word phải có định dạng: doc, docx.',
            'word_file.max' => 'File Word không được vượt quá 50MB.',
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
            'issued_year' => $request->issued_year,
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

        $redirectUrl = route('admin.management-documents.index');
        if ($request->category_id) {
            $redirectUrl .= '?category_id=' . $request->category_id;
        }
        
        return redirect($redirectUrl)
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(ManagementDocument $managementDocument)
    {
        $managementDocument->load(['category', 'uploader']);
        return view('admin.management-documents.show', compact('managementDocument'));
    }

    public function edit(ManagementDocument $managementDocument)
    {
        $categories = ManagementDocumentCategory::getFlatList();
        return view('admin.management-documents.edit', compact('managementDocument', 'categories'));
    }

    public function update(Request $request, ManagementDocument $managementDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:management_document_categories,id',
            'status' => 'nullable|in:draft,approved,archived',
            'symbol' => 'nullable|string|max:255',
            'issued_year' => 'nullable|integer|digits:4',
            'document_number' => 'nullable|string|max:255',
            'issuing_agency' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // PDF file optional for update, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'title.required' => 'Tiêu đề tài liệu là bắt buộc.',
            'title.string' => 'Tiêu đề tài liệu phải là chuỗi văn bản.',
            'title.max' => 'Tiêu đề tài liệu không được vượt quá 255 ký tự.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'status.in' => 'Trạng thái được chọn không hợp lệ.',
            'symbol.string' => 'Ký hiệu phải là chuỗi văn bản.',
            'symbol.max' => 'Ký hiệu không được vượt quá 255 ký tự.',
            'issued_year.integer' => 'Năm ban hành phải là số nguyên.',
            'issued_year.digits' => 'Năm ban hành phải có đúng 4 chữ số.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
            'summary.max' => 'Trích yếu không được vượt quá 1000 ký tự.',
            'pdf_file.file' => 'PDF phải là một file.',
            'pdf_file.mimes' => 'File PDF phải có định dạng: pdf.',
            'pdf_file.max' => 'File PDF không được vượt quá 50MB.',
            'word_file.file' => 'Word phải là một file.',
            'word_file.mimes' => 'File Word phải có định dạng: doc, docx.',
            'word_file.max' => 'File Word không được vượt quá 50MB.',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status ?? $managementDocument->status,
            'symbol' => $request->symbol,
            'issued_year' => $request->issued_year,
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

        $redirectUrl = route('admin.management-documents.index');
        if ($request->category_id) {
            $redirectUrl .= '?category_id=' . $request->category_id;
        }
        
        return redirect($redirectUrl)
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(Request $request, ManagementDocument $managementDocument)
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

        // Redirect back to the same category if specified
        $redirectUrl = route('admin.management-documents.index');
        if ($request->has('redirect_category')) {
            $redirectUrl .= '?category_id=' . $request->redirect_category;
        }
        
        return redirect($redirectUrl)
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
