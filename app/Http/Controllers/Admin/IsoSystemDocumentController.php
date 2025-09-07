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

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Year filter based on issued_year
        if ($request->filled('year')) {
            $year = $request->year;
            $query->where('issued_year', $year);
        }

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->where('department_id', $user->department_id);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());

        // Get all categories for filter with hierarchical structure
        $categories = IsoSystemCategory::getFlatList();
        
        // Get all departments for filter
        $departments = Department::orderBy('id')->get();

        return view('admin.iso-system-documents.index', compact('documents', 'categories', 'departments'));
    }

    public function indexByCategory(IsoSystemCategory $category, Request $request)
    {
        $query = IsoSystemDocument::with(['category', 'uploader', 'department'])
                    ->where('category_id', $category->id);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Year filter based on issued_year
        if ($request->filled('year')) {
            $year = $request->year;
            $query->where('issued_year', $year);
        }

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->where('department_id', $user->department_id);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Preserve query parameters in pagination links
        $documents->appends($request->all());

        // Get all categories for filter with hierarchical structure
        $categories = IsoSystemCategory::getFlatList();
        
        // Get all departments for filter
        $departments = Department::orderBy('id')->get();

        return view('admin.iso-system-documents.index', compact('documents', 'categories', 'departments', 'category'));
    }

    public function create()
    {
        $categories = IsoSystemCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.iso-system-documents.create', compact('categories', 'departments'));
    }

    public function createForCategory(IsoSystemCategory $category)
    {
        $categories = IsoSystemCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.iso-system-documents.create', compact('categories', 'departments', 'category'));
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
            'issued_year' => 'nullable|integer|digits:4',
            'document_number' => 'nullable|string|max:255',
            'issuing_agency' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'pdf_file' => 'required|file|mimes:pdf|max:51200', // PDF file required, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'title.required' => 'Tiêu đề văn bản là bắt buộc.',
            'title.string' => 'Tiêu đề văn bản phải là chuỗi văn bản.',
            'title.max' => 'Tiêu đề văn bản không được vượt quá 255 ký tự.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'department_id.required' => 'Phòng ban là bắt buộc.',
            'department_id.exists' => 'Phòng ban được chọn không hợp lệ.',
            'status.in' => 'Trạng thái được chọn không hợp lệ.',
            'symbol.string' => 'Ký hiệu phải là chuỗi văn bản.',
            'symbol.max' => 'Ký hiệu không được vượt quá 255 ký tự.',
            'issued_year.integer' => 'Thời gian ban hành phải là số nguyên.',
            'issued_year.digits' => 'Thời gian ban hành phải có đúng 4 chữ số.',
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

        // Use category-based routes when category context exists
        if ($request->category_id) {
            $category = IsoSystemCategory::find($request->category_id);
            if ($category) {
                return redirect()->route('admin.iso-system-documents.category', $category)
                    ->with('success', 'Tài liệu đã được tạo thành công.');
            }
        }
        
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

    public function showForCategory(IsoSystemCategory $category, IsoSystemDocument $isoSystemDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && $isoSystemDocument->department_id !== $user->department_id) {
            abort(404);
        }

        // Verify document belongs to the category
        if ($isoSystemDocument->category_id !== $category->id) {
            abort(404);
        }
        
        $isoSystemDocument->load(['category', 'uploader', 'department']);
        return view('admin.iso-system-documents.show', compact('isoSystemDocument', 'category'));
    }

    public function edit(IsoSystemDocument $isoSystemDocument)
    {
        $categories = IsoSystemCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.iso-system-documents.edit', compact('isoSystemDocument', 'categories', 'departments'));
    }

    public function editForCategory(IsoSystemCategory $category, IsoSystemDocument $isoSystemDocument)
    {
        // Verify document belongs to the category
        if ($isoSystemDocument->category_id !== $category->id) {
            abort(404);
        }

        $categories = IsoSystemCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.iso-system-documents.edit', compact('isoSystemDocument', 'categories', 'departments', 'category'));
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
            'issued_year' => 'nullable|integer|digits:4',
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
            'issued_year' => $request->issued_year,
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

        // Use category-based routes when category context exists
        if ($request->category_id) {
            $category = IsoSystemCategory::find($request->category_id);
            if ($category) {
                return redirect()->route('admin.iso-system-documents.category', $category)
                    ->with('success', 'Tài liệu đã được cập nhật thành công.');
            }
        }
        
        return redirect()->route('admin.iso-system-documents.index')
            ->with('success', 'Tài liệu đã được cập nhật thành công.');
    }

    public function destroy(Request $request, IsoSystemDocument $isoSystemDocument)
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

        // Smart redirect based on referer URL
        $referer = $request->headers->get('referer');
        if ($referer) {
            // Check if referer is a category-based URL
            $pattern = '/\/iso-system-documents\/category\/(\d+)/';
            if (preg_match($pattern, $referer, $matches)) {
                $categoryId = $matches[1];
                $category = IsoSystemCategory::find($categoryId);
                if ($category) {
                    return redirect()->route('admin.iso-system-documents.category', $category)
                        ->with('success', 'Tài liệu đã được xóa thành công.');
                }
            }
        }

        // Fallback: check for redirect_category parameter (legacy support)
        if ($request->has('redirect_category')) {
            $category = IsoSystemCategory::find($request->redirect_category);
            if ($category) {
                return redirect()->route('admin.iso-system-documents.category', $category)
                    ->with('success', 'Tài liệu đã được xóa thành công.');
            }
        }
        
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
