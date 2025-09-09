@extends('layouts.admin')

@section('title', 'Chỉnh sửa tài liệu - Nội bộ')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        @if(isset($category))
            <a href="{{ route('admin.internal-documents.category', $category) }}" class="admin-breadcrumb__item">{{ $category->name }}</a>
        @else
            <a href="{{ route('admin.internal-documents.index') }}" class="admin-breadcrumb__item">Tài liệu nội bộ</a>
        @endif
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Sửa tài liệu</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Sửa tài liệu nội bộ</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin tài liệu: {{ $internalDocument->document_number ?: 'Tài liệu nội bộ' }}</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ isset($category) ? route('admin.internal-documents.category', $category) : route('admin.internal-documents.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.internal-documents.update', $internalDocument) }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                


                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Danh mục</label>
                        @if(isset($category))
                            <div class="admin-form__display">
                                <div class="admin-form__display-value">
                                    <svg class="admin-form__display-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $category->name }}
                                </div>
                                <div class="admin-form__display-note">
                                    Danh mục được chọn tự động dựa trên trang hiện tại
                                </div>
                            </div>
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                        @else
                            <select name="category_id" id="category_id"
                                    class="admin-form__select @error('category_id') admin-form__select--error @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $categoryOption)
                                    <option value="{{ $categoryOption['id'] }}" {{ old('category_id', $internalDocument->category_id) == $categoryOption['id'] ? 'selected' : '' }}>
                                        {{ $categoryOption['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('category_id')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Đơn vị áp dụng</label>
                        @if(auth()->user()->role == 2 && auth()->user()->department_id)
                            <!-- Role 2 can only edit documents for their own department -->
                            <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                            <div class="admin-form__readonly">{{ auth()->user()->department->name }}</div>
                        @else
                            <!-- Role 0,1 can choose any department -->
                            <select name="department_id" id="department_id"
                                    class="admin-form__select select2 @error('department_id') admin-form__select--error @enderror">
                                <option value="">-- Chọn đơn vị áp dụng --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $internalDocument->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('department_id')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Thời gian ban hành</label>
                        <input type="date" name="issued_date" value="{{ old('issued_date', $internalDocument->issued_date ? $internalDocument->issued_date->format('Y-m-d') : '') }}" 
                               class="admin-form__input @error('issued_date') admin-form__input--error @enderror">
                        @error('issued_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Số văn bản</label>
                        <input type="text" name="document_number" value="{{ old('document_number', $internalDocument->document_number) }}" 
                               class="admin-form__input @error('document_number') admin-form__input--error @enderror"
                               placeholder="Nhập số văn bản">
                        @error('document_number')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Cơ quan ban hành</label>
                        <input type="text" name="issuing_agency" value="{{ old('issuing_agency', $internalDocument->issuing_agency) }}" 
                               class="admin-form__input @error('issuing_agency') admin-form__input--error @enderror"
                               placeholder="Nhập cơ quan ban hành">
                        @error('issuing_agency')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Trích yếu</label>
                        <textarea name="summary" rows="3" 
                                  class="admin-form__input @error('summary') admin-form__input--error @enderror"
                                  placeholder="Nhập trích yếu tài liệu">{{ old('summary', $internalDocument->summary) }}</textarea>
                        @error('summary')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Current Files Section -->
                @if($internalDocument->pdf_file_name || $internalDocument->word_file_name)
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File hiện tại</label>
                        <div class="current-files-info">
                            @if($internalDocument->pdf_file_name)
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $internalDocument->pdf_file_name }}</div>
                                        <div class="current-file-info__meta">{{ number_format($internalDocument->pdf_file_size / 1024 / 1024, 2) }}MB • PDF</div>
                                    </div>
                                    <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'pdf']) }}" class="current-file-info__download">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($internalDocument->word_file_name)
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $internalDocument->word_file_name }}</div>
                                        <div class="current-file-info__meta">{{ number_format($internalDocument->word_file_size / 1024 / 1024, 2) }}MB • {{ strtoupper($internalDocument->word_file_type) }}</div>
                                    </div>
                                    <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'word']) }}" class="current-file-info__download">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- PDF File Upload -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label {{ !$internalDocument->pdf_file_name ? 'admin-form__label--required' : '' }}">File PDF {{ $internalDocument->pdf_file_name ? '(Tùy chọn - để trống nếu không đổi)' : '(Bắt buộc)' }}</label>
                        <div class="admin-file-upload">
                            <input type="file" name="pdf_file" accept=".pdf"
                                   class="admin-file-upload__input @error('pdf_file') admin-form__input--error @enderror" 
                                   id="adminPdfFileInput">
                            <label for="adminPdfFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file PDF mới hoặc kéo thả vào đây</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Định dạng: PDF. Kích thước tối đa: 50MB</small>
                        @error('pdf_file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Word File Upload -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File Word (Tùy chọn)</label>
                        <div class="admin-file-upload">
                            <input type="file" name="word_file" accept=".doc,.docx"
                                   class="admin-file-upload__input @error('word_file') admin-form__input--error @enderror" 
                                   id="adminWordFileInput">
                            <label for="adminWordFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file Word hoặc kéo thả vào đây</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Định dạng: DOC, DOCX. Kích thước tối đa: 50MB</small>
                        @error('word_file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="admin-form__actions">
                    <a href="{{ isset($category) ? route('admin.internal-documents.category', $category) : route('admin.internal-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật tài liệu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Function to handle file validation and preview
function handleFileSelect(inputId, labelSelector, defaultText, maxSize, acceptedTypes) {
    const input = document.getElementById(inputId);
    const label = document.querySelector(labelSelector);
    
    function validateAndPreview(file) {
        // Check file size
        if (file.size > maxSize) {
            const maxSizeMB = maxSize / (1024 * 1024);
            alert(`Kích thước file không được vượt quá ${maxSizeMB}MB`);
            input.value = '';
            label.textContent = defaultText;
            return false;
        }
        
        // Check file type
        if (acceptedTypes && !acceptedTypes.includes(file.type)) {
            alert('Định dạng file không được hỗ trợ');
            input.value = '';
            label.textContent = defaultText;
            return false;
        }
        
        // Update label with filename
        label.textContent = file.name;
        return true;
    }
    
    // Handle input change
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            validateAndPreview(file);
        } else {
            label.textContent = defaultText;
        }
    });
    
    // Handle drag and drop
    const dropArea = label.parentElement;
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropArea.classList.add('admin-file-upload--dragover');
    }
    
    function unhighlight() {
        dropArea.classList.remove('admin-file-upload--dragover');
    }
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            const file = files[0];
            if (validateAndPreview(file)) {
                // Create a new FileList-like object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            }
        }
    }
}

// Initialize PDF file upload
handleFileSelect(
    'adminPdfFileInput',
    'label[for="adminPdfFileInput"] span',
    'Chọn file PDF mới hoặc kéo thả vào đây',
    50 * 1024 * 1024, // 50MB
    ['application/pdf']
);

// Initialize Word file upload
handleFileSelect(
    'adminWordFileInput',
    'label[for="adminWordFileInput"] span',
    'Chọn file Word hoặc kéo thả vào đây',
    50 * 1024 * 1024, // 50MB
    ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword']
);

// Initialize Select2 for dropdowns
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $.fn.select2) {
        // Department dropdown
        $('#department_id').select2({
            placeholder: '-- Chọn đơn vị áp dụng --',
            allowClear: true,
            width: '100%',
            dropdownCssClass: 'select2-dropdown-small',
            containerCssClass: 'select2-container-small'
        });
    }
});
</script>
@endsection