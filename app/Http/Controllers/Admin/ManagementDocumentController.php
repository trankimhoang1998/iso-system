<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagementDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagementDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = ManagementDocument::with(['uploader']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('document_number', 'like', "%{$search}%")
                  ->orWhere('issuing_agency', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        // Date range filter based on issued_date
        if ($request->filled('date_from')) {
            $query->whereDate('issued_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('issued_date', '<=', $request->date_to);
        }


        $documents = $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());

        return view('admin.management-documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.management-documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'issued_date' => 'required|date',
            'document_number' => 'required|string|max:255',
            'issuing_agency' => 'required|string|max:255',
            'summary' => 'required|string',
            'pdf_file' => 'required|file|mimes:pdf|max:51200',
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200',
        ], [
            'issued_date.required' => 'Ngày ban hành là bắt buộc.',
            'issued_date.date' => 'Ngày ban hành phải là ngày hợp lệ.',
            'document_number.required' => 'Số văn bản là bắt buộc.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.required' => 'Cơ quan ban hành là bắt buộc.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.required' => 'Trích yếu là bắt buộc.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
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

        // Push all existing documents down by incrementing their display_order
        ManagementDocument::query()->increment('display_order');

        // Create new document with display_order = 0 (top position)
        ManagementDocument::create([
            'issued_date' => $request->issued_date,
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
            'display_order' => 0,
        ]);

        return redirect()->route('admin.management-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(ManagementDocument $managementDocument)
    {
        $managementDocument->load(['uploader']);
        return view('admin.management-documents.show', compact('managementDocument'));
    }

    public function edit(ManagementDocument $managementDocument)
    {
        return view('admin.management-documents.edit', compact('managementDocument'));
    }

    public function update(Request $request, ManagementDocument $managementDocument)
    {
        $request->validate([
            'issued_date' => 'required|date',
            'document_number' => 'required|string|max:255',
            'issuing_agency' => 'required|string|max:255',
            'summary' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200',
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200',
        ], [
            'issued_date.required' => 'Ngày ban hành là bắt buộc.',
            'issued_date.date' => 'Ngày ban hành phải là ngày hợp lệ.',
            'document_number.required' => 'Số văn bản là bắt buộc.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.required' => 'Cơ quan ban hành là bắt buộc.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.required' => 'Trích yếu là bắt buộc.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
            'pdf_file.file' => 'PDF phải là một file.',
            'pdf_file.mimes' => 'File PDF phải có định dạng: pdf.',
            'pdf_file.max' => 'File PDF không được vượt quá 50MB.',
            'word_file.file' => 'Word phải là một file.',
            'word_file.mimes' => 'File Word phải có định dạng: doc, docx.',
            'word_file.max' => 'File Word không được vượt quá 50MB.',
        ]);

        $updateData = [
            'issued_date' => $request->issued_date,
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

    public function view(ManagementDocument $managementDocument, $type = 'pdf')
    {
        if ($type === 'word' && $managementDocument->word_file_path) {
            if (Storage::disk('public')->exists($managementDocument->word_file_path)) {
                return Storage::disk('public')->response($managementDocument->word_file_path);
            }
        } elseif ($managementDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($managementDocument->pdf_file_path)) {
                return Storage::disk('public')->response($managementDocument->pdf_file_path);
            }
        }

        return redirect()->route('admin.management-documents.index')->with('error', 'File không tồn tại!');
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

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:management_documents,id',
            'items.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            ManagementDocument::where('id', $item['id'])
                ->update(['display_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
