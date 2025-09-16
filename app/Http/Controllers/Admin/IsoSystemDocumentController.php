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
        $query = IsoSystemDocument::with(['category', 'uploader', 'departments']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('symbol', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->whereHas('departments', function($q) use ($request) {
                $q->where('departments.id', $request->department_id);
            });
        }

        // Date range filter based on issued_date
        if ($request->filled('date_from')) {
            $query->whereDate('issued_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('issued_date', '<=', $request->date_to);
        }

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->whereHas('departments', function($q) use ($user) {
                $q->where('departments.id', $user->department_id);
            });
        }

        $documents = $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        
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
        $query = IsoSystemDocument::with(['category', 'uploader', 'departments'])
                    ->where('category_id', $category->id);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('symbol', 'like', "%{$search}%");
            });
        }

        // Department filter (for search/filter)
        if ($request->filled('department_id')) {
            $query->whereHas('departments', function($q) use ($request) {
                $q->where('departments.id', $request->department_id);
            });
        }

        // Date range filter based on issued_date
        if ($request->filled('date_from')) {
            $query->whereDate('issued_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('issued_date', '<=', $request->date_to);
        }

        // Department filter for roles 2,3 - only see documents from their department
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id) {
            $query->whereHas('departments', function($q) use ($user) {
                $q->where('departments.id', $user->department_id);
            });
        }

        $documents = $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc')->paginate(15);
        
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
            'category_id' => 'required|exists:iso_system_categories,id',
            'symbol' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'latest_update' => 'required|date',
            'department_ids' => 'required|array|min:1',
            'department_ids.*' => 'exists:departments,id',
            'pdf_file' => 'required|file|mimes:pdf|max:51200', // PDF file required, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'symbol.required' => 'Ký hiệu là bắt buộc.',
            'symbol.string' => 'Ký hiệu phải là chuỗi văn bản.',
            'symbol.max' => 'Ký hiệu không được vượt quá 255 ký tự.',
            'title.required' => 'Tên tài liệu là bắt buộc.',
            'title.string' => 'Tên tài liệu phải là chuỗi văn bản.',
            'title.max' => 'Tên tài liệu không được vượt quá 255 ký tự.',
            'issued_date.required' => 'Thời gian ban hành là bắt buộc.',
            'issued_date.date' => 'Thời gian ban hành phải là ngày hợp lệ.',
            'latest_update.required' => 'Cập nhật mới nhất là bắt buộc.',
            'latest_update.date' => 'Cập nhật mới nhất phải là ngày hợp lệ.',
            'department_ids.required' => 'Đơn vị áp dụng là bắt buộc.',
            'department_ids.array' => 'Đơn vị áp dụng phải là mảng.',
            'department_ids.min' => 'Phải chọn ít nhất một đơn vị áp dụng.',
            'department_ids.*.exists' => 'Đơn vị áp dụng được chọn không hợp lệ.',
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

        // Push all existing documents down by incrementing their display_order
        IsoSystemDocument::query()->increment('display_order');

        // Create new document with display_order = 0 (top position)
        $document = IsoSystemDocument::create([
            'category_id' => $request->category_id,
            'symbol' => $request->symbol,
            'title' => $request->title,
            'issued_date' => $request->issued_date,
            'latest_update' => $request->latest_update,
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

        // Attach departments to the document
        $document->departments()->attach($request->department_ids);

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
        if (in_array($user->role, [2, 3]) && $user->department_id && !$isoSystemDocument->departments->contains('id', $user->department_id)) {
            abort(404);
        }
        
        $isoSystemDocument->load(['category', 'uploader', 'department']);
        return view('admin.iso-system-documents.show', compact('isoSystemDocument'));
    }

    public function showForCategory(IsoSystemCategory $category, IsoSystemDocument $isoSystemDocument)
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && !$isoSystemDocument->departments->contains('id', $user->department_id)) {
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
        $isoSystemDocument->load('departments');
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

        $isoSystemDocument->load('departments');
        $categories = IsoSystemCategory::getFlatList();
        $departments = Department::orderBy('id')->get();
        return view('admin.iso-system-documents.edit', compact('isoSystemDocument', 'categories', 'departments', 'category'));
    }

    public function update(Request $request, IsoSystemDocument $isoSystemDocument)
    {
        $request->validate([
            'category_id' => 'required|exists:iso_system_categories,id',
            'symbol' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'latest_update' => 'required|date',
            'department_ids' => 'required|array|min:1',
            'department_ids.*' => 'exists:departments,id',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // PDF file optional for update, 50MB max
            'word_file' => 'nullable|file|mimes:doc,docx|max:51200', // Word file optional, 50MB max
        ], [
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục được chọn không hợp lệ.',
            'symbol.required' => 'Ký hiệu là bắt buộc.',
            'symbol.string' => 'Ký hiệu phải là chuỗi văn bản.',
            'symbol.max' => 'Ký hiệu không được vượt quá 255 ký tự.',
            'title.required' => 'Tên tài liệu là bắt buộc.',
            'title.string' => 'Tên tài liệu phải là chuỗi văn bản.',
            'title.max' => 'Tên tài liệu không được vượt quá 255 ký tự.',
            'issued_date.required' => 'Thời gian ban hành là bắt buộc.',
            'issued_date.date' => 'Thời gian ban hành phải là ngày hợp lệ.',
            'latest_update.required' => 'Cập nhật mới nhất là bắt buộc.',
            'latest_update.date' => 'Cập nhật mới nhất phải là ngày hợp lệ.',
            'department_ids.required' => 'Đơn vị áp dụng là bắt buộc.',
            'department_ids.array' => 'Đơn vị áp dụng phải là mảng.',
            'department_ids.min' => 'Phải chọn ít nhất một đơn vị áp dụng.',
            'department_ids.*.exists' => 'Đơn vị áp dụng được chọn không hợp lệ.',
            'pdf_file.file' => 'PDF phải là một file.',
            'pdf_file.mimes' => 'File PDF phải có định dạng: pdf.',
            'pdf_file.max' => 'File PDF không được vượt quá 50MB.',
            'word_file.file' => 'Word phải là một file.',
            'word_file.mimes' => 'File Word phải có định dạng: doc, docx.',
            'word_file.max' => 'File Word không được vượt quá 50MB.',
        ]);

        $updateData = [
            'category_id' => $request->category_id,
            'symbol' => $request->symbol,
            'title' => $request->title,
            'issued_date' => $request->issued_date,
            'latest_update' => $request->latest_update,
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

        // Sync departments to the document
        $isoSystemDocument->departments()->sync($request->department_ids);

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

    public function view(IsoSystemDocument $isoSystemDocument, $type = 'pdf')
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && !$isoSystemDocument->departments->contains('id', $user->department_id)) {
            abort(404);
        }
        
        if ($type === 'word' && $isoSystemDocument->word_file_path) {
            if (Storage::disk('public')->exists($isoSystemDocument->word_file_path)) {
                return Storage::disk('public')->response($isoSystemDocument->word_file_path);
            }
        } elseif ($isoSystemDocument->pdf_file_path) {
            if (Storage::disk('public')->exists($isoSystemDocument->pdf_file_path)) {
                return Storage::disk('public')->response($isoSystemDocument->pdf_file_path);
            }
        }

        return redirect()->route('admin.iso-system-documents.index')->with('error', 'File không tồn tại!');
    }

    public function download(IsoSystemDocument $isoSystemDocument, $type = 'pdf')
    {
        // Check if user can access this document
        $user = auth()->user();
        if (in_array($user->role, [2, 3]) && $user->department_id && !$isoSystemDocument->departments->contains('id', $user->department_id)) {
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

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:iso_system_documents,id',
            'items.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            IsoSystemDocument::where('id', $item['id'])
                ->update(['display_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
