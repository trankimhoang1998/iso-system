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
    public function index(Request $request)
    {
        $query = InternalDocument::with(['category', 'department']);

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->where('department_id', $user->department_id);
        }

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('document_number', 'like', '%' . $request->search . '%')
                  ->orWhere('issuing_agency', 'like', '%' . $request->search . '%')
                  ->orWhere('summary', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Date range filter based on issued_date
        if ($request->filled('date_from')) {
            $query->whereDate('issued_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('issued_date', '<=', $request->date_to);
        }

        $documents = $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        
        // Load categories with hierarchical structure for filter dropdown
        $categories = InternalDocumentCategory::getFlatList();
        
        // Get all departments for filter
        $departments = Department::orderBy('id')->get();

        return view('admin.internal-documents.index', compact('documents', 'categories', 'departments'));
    }

    public function indexByCategory(InternalDocumentCategory $category, Request $request)
    {
        $query = InternalDocument::with(['category', 'department'])
                    ->where('category_id', $category->id);

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->where('department_id', $user->department_id);
        }

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('document_number', 'like', '%' . $request->search . '%')
                  ->orWhere('issuing_agency', 'like', '%' . $request->search . '%')
                  ->orWhere('summary', 'like', '%' . $request->search . '%');
            });
        }

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
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

        // Load categories with hierarchical structure for filter dropdown
        $categories = InternalDocumentCategory::getFlatList();
        
        // Get all departments for filter
        $departments = Department::orderBy('id')->get();

        return view('admin.internal-documents.index', compact('documents', 'categories', 'departments', 'category'));
    }

    public function create()
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can create
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        $categories = InternalDocumentCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.internal-documents.create', compact('categories', 'departments'));
    }

    public function createForCategory(InternalDocumentCategory $category)
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can create
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        $categories = InternalDocumentCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.internal-documents.create', compact('categories', 'departments', 'category'));
    }

    public function store(Request $request)
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can create
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        $request->validate([
            'issued_date' => 'required|date',
            'document_number' => 'required|string|max:255',
            'issuing_agency' => 'required|string|max:255',
            'summary' => 'required|string',
            'category_id' => 'required|exists:internal_document_categories,id',
            'department_id' => 'required|exists:departments,id',
            'pdf_file' => 'required|file|mimes:pdf|max:51200',
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200',
        ], [
            'issued_date.required' => 'Thời gian ban hành là bắt buộc.',
            'issued_date.date' => 'Thời gian ban hành phải là ngày hợp lệ.',
            'document_number.required' => 'Số văn bản là bắt buộc.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.required' => 'Cơ quan ban hành là bắt buộc.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.required' => 'Trích yếu là bắt buộc.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'department_id.required' => 'Đơn vị áp dụng là bắt buộc.',
            'department_id.exists' => 'Đơn vị áp dụng được chọn không hợp lệ.',
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
        $pdfFilePath = $pdfFile->storeAs('documents/internal/pdf', $pdfFileName, 'public');

        // Handle Word file upload (optional)
        $wordFileName = null;
        $wordFilePath = null;
        $wordFileType = null;
        $wordFileSize = null;

        if ($request->hasFile('word_file')) {
            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/internal/word', $wordFileName, 'public');
            $wordFileType = $wordFile->getClientOriginalExtension();
            $wordFileSize = $wordFile->getSize();
        }

        // Get next display order
        $maxOrder = InternalDocument::max('display_order') ?? 0;
        
        InternalDocument::create([
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
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
            'display_order' => $maxOrder + 1,
        ]);

        // Use category-based routes when category context exists
        if ($request->category_id) {
            $category = InternalDocumentCategory::find($request->category_id);
            if ($category) {
                return redirect()->route('admin.internal-documents.category', $category)
                    ->with('success', 'Tài liệu đã được tạo thành công.');
            }
        }
        
        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được tạo thành công.');
    }

    public function show(InternalDocument $internalDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $internalDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        $internalDocument->load(['category', 'uploader', 'department']);
        return view('admin.internal-documents.show', compact('internalDocument'));
    }

    public function showForCategory(InternalDocumentCategory $category, InternalDocument $internalDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $internalDocument->department_id !== $user->department_id) {
            abort(404);
        }

        // Verify document belongs to the category
        if ($internalDocument->category_id !== $category->id) {
            abort(404);
        }
        
        $internalDocument->load(['category', 'uploader', 'department']);
        return view('admin.internal-documents.show', compact('internalDocument', 'category'));
    }

    public function edit(InternalDocument $internalDocument)
    {
        $categories = InternalDocumentCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.internal-documents.edit', compact('internalDocument', 'categories', 'departments'));
    }

    public function editForCategory(InternalDocumentCategory $category, InternalDocument $internalDocument)
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can edit
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        // Verify document belongs to the category
        if ($internalDocument->category_id !== $category->id) {
            abort(404);
        }

        $categories = InternalDocumentCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.internal-documents.edit', compact('internalDocument', 'categories', 'departments', 'category'));
    }

    public function update(Request $request, InternalDocument $internalDocument)
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can update
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        $request->validate([
            'issued_date' => 'required|date',
            'document_number' => 'required|string|max:255',
            'issuing_agency' => 'required|string|max:255',
            'summary' => 'required|string',
            'category_id' => 'required|exists:internal_document_categories,id',
            'department_id' => 'required|exists:departments,id',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // PDF file optional for update, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'issued_date.required' => 'Thời gian ban hành là bắt buộc.',
            'issued_date.date' => 'Thời gian ban hành phải là ngày hợp lệ.',
            'document_number.required' => 'Số văn bản là bắt buộc.',
            'document_number.string' => 'Số văn bản phải là chuỗi văn bản.',
            'document_number.max' => 'Số văn bản không được vượt quá 255 ký tự.',
            'issuing_agency.required' => 'Cơ quan ban hành là bắt buộc.',
            'issuing_agency.string' => 'Cơ quan ban hành phải là chuỗi văn bản.',
            'issuing_agency.max' => 'Cơ quan ban hành không được vượt quá 255 ký tự.',
            'summary.required' => 'Trích yếu là bắt buộc.',
            'summary.string' => 'Trích yếu phải là chuỗi văn bản.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'department_id.required' => 'Đơn vị áp dụng là bắt buộc.',
            'department_id.exists' => 'Đơn vị áp dụng được chọn không hợp lệ.',
            'pdf_file.file' => 'PDF phải là một file.',
            'pdf_file.mimes' => 'File PDF phải có định dạng: pdf.',
            'pdf_file.max' => 'File PDF không được vượt quá 50MB.',
            'word_file.file' => 'Word phải là một file.',
            'word_file.mimes' => 'File Word phải có định dạng: doc, docx.',
            'word_file.max' => 'File Word không được vượt quá 50MB.',
        ]);

        $updateData = [
            'category_id' => $request->category_id,
            'department_id' => $request->department_id,
            'issued_date' => $request->issued_date,
            'document_number' => $request->document_number,
            'issuing_agency' => $request->issuing_agency,
            'summary' => $request->summary,
        ];

        // Handle PDF file update
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF file
            if ($internalDocument->pdf_file_path && Storage::disk('public')->exists($internalDocument->pdf_file_path)) {
                Storage::disk('public')->delete($internalDocument->pdf_file_path);
            }

            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_pdf_' . $pdfFile->getClientOriginalName();
            $pdfFilePath = $pdfFile->storeAs('documents/internal/pdf', $pdfFileName, 'public');

            $updateData['pdf_file_name'] = $pdfFileName;
            $updateData['pdf_file_path'] = $pdfFilePath;
            $updateData['pdf_file_type'] = $pdfFile->getClientOriginalExtension();
            $updateData['pdf_file_size'] = $pdfFile->getSize();
        }

        // Handle Word file update
        if ($request->hasFile('word_file')) {
            // Delete old Word file
            if ($internalDocument->word_file_path && Storage::disk('public')->exists($internalDocument->word_file_path)) {
                Storage::disk('public')->delete($internalDocument->word_file_path);
            }

            $wordFile = $request->file('word_file');
            $wordFileName = time() . '_word_' . $wordFile->getClientOriginalName();
            $wordFilePath = $wordFile->storeAs('documents/internal/word', $wordFileName, 'public');

            $updateData['word_file_name'] = $wordFileName;
            $updateData['word_file_path'] = $wordFilePath;
            $updateData['word_file_type'] = $wordFile->getClientOriginalExtension();
            $updateData['word_file_size'] = $wordFile->getSize();
        }

        $internalDocument->update($updateData);

        // Use category-based routes when category context exists
        if ($request->category_id) {
            $category = InternalDocumentCategory::find($request->category_id);
            if ($category) {
                return redirect()->route('admin.internal-documents.category', $category)
                    ->with('success', 'Tài liệu đã được cập nhật thành công.');
            }
        }
        
        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(Request $request, InternalDocument $internalDocument)
    {
        // Check permission - only roles 0 (Admin) and 2 (Cơ quan - Phân xưởng) can delete
        if (!in_array(auth()->user()->role, [0, 2])) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }
        
        // Delete PDF file from storage
        if ($internalDocument->pdf_file_path && Storage::disk('public')->exists($internalDocument->pdf_file_path)) {
            Storage::disk('public')->delete($internalDocument->pdf_file_path);
        }

        // Delete Word file from storage
        if ($internalDocument->word_file_path && Storage::disk('public')->exists($internalDocument->word_file_path)) {
            Storage::disk('public')->delete($internalDocument->word_file_path);
        }

        $internalDocument->delete();

        // Smart redirect based on referer URL
        $referer = $request->headers->get('referer');
        if ($referer) {
            // Check if referer is a category-based URL
            $pattern = '/\/internal-documents\/category\/(\d+)/';
            if (preg_match($pattern, $referer, $matches)) {
                $categoryId = $matches[1];
                $category = InternalDocumentCategory::find($categoryId);
                if ($category) {
                    return redirect()->route('admin.internal-documents.category', $category)
                        ->with('success', 'Tài liệu đã được xóa thành công.');
                }
            }
        }

        // Fallback: check for redirect_category parameter (legacy support)
        if ($request->has('redirect_category')) {
            $category = InternalDocumentCategory::find($request->redirect_category);
            if ($category) {
                return redirect()->route('admin.internal-documents.category', $category)
                    ->with('success', 'Tài liệu đã được xóa thành công.');
            }
        }
        
        return redirect()->route('admin.internal-documents.index')
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    public function view(InternalDocument $internalDocument, $type = 'pdf')
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $internalDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        if ($type === 'word' && $internalDocument->word_file_path) {
            if (Storage::disk('public')->exists($internalDocument->word_file_path)) {
                return Storage::disk('public')->response($internalDocument->word_file_path);
            }
        } elseif ($internalDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($internalDocument->pdf_file_path)) {
                return Storage::disk('public')->response($internalDocument->pdf_file_path);
            }
        }

        return redirect()->route('admin.internal-documents.index')->with('error', 'File không tồn tại!');
    }

    public function download(InternalDocument $internalDocument, $type = 'pdf')
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $internalDocument->department_id !== $user->department_id) {
            abort(404);
        }
        
        if ($type === 'word' && $internalDocument->word_file_path) {
            if (Storage::disk('public')->exists($internalDocument->word_file_path)) {
                return Storage::disk('public')->download($internalDocument->word_file_path, $internalDocument->word_file_name);
            }
        } elseif ($internalDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($internalDocument->pdf_file_path)) {
                return Storage::disk('public')->download($internalDocument->pdf_file_path, $internalDocument->pdf_file_name);
            }
        }

        return redirect()->route('admin.internal-documents.index')->with('error', 'File không tồn tại!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:internal_documents,id',
            'items.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            InternalDocument::where('id', $item['id'])
                ->update(['display_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
