@extends('layouts.admin')

@section('title', 'Chỉnh sửa tài liệu - Hệ thống ISO')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        @if(isset($category))
            <a href="{{ route('admin.iso-system-documents.category', $category) }}" class="admin-breadcrumb__item">{{ $category->name }}</a>
        @else
            <a href="{{ route('admin.iso-system-documents.index') }}" class="admin-breadcrumb__item">Văn bản hệ thống ISO</a>
        @endif
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Sửa văn bản</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Sửa văn bản hệ thống ISO</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin văn bản: {{ $isoSystemDocument->title }}</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ isset($category) ? route('admin.iso-system-documents.category', $category) : route('admin.iso-system-documents.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.iso-system-documents.update', $isoSystemDocument) }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                

                <!-- 1. Danh mục -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Danh mục</label>
                        @if(isset($category))
                            <!-- Category is pre-selected and disabled -->
                            <div class="admin-form__display">
                                <div class="admin-form__display-value">
                                    <svg class="admin-form__display-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    {{ $category->name }}
                                </div>
                                <div class="admin-form__display-note">
                                    Danh mục được chọn tự động dựa trên trang hiện tại
                                </div>
                            </div>
                            <!-- Hidden input to submit category_id -->
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                        @else
                            <!-- Normal dropdown when no category context -->
                            <select name="category_id" id="category_id"
                                    class="admin-form__select @error('category_id') admin-form__select--error @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $categoryOption)
                                    <option value="{{ $categoryOption['id'] }}" {{ old('category_id', $isoSystemDocument->category_id) == $categoryOption['id'] ? 'selected' : '' }}>
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

                <!-- 2. Ký hiệu -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Ký hiệu</label>
                        <input type="text" name="symbol" value="{{ old('symbol', $isoSystemDocument->symbol) }}" 
                               class="admin-form__input @error('symbol') admin-form__input--error @enderror"
                               placeholder="Nhập ký hiệu tài liệu">
                        @error('symbol')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 3. Tên tài liệu -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Tên tài liệu</label>
                        <input type="text" name="title" value="{{ old('title', $isoSystemDocument->title) }}" 
                               class="admin-form__input @error('title') admin-form__input--error @enderror"
                               placeholder="Nhập tên tài liệu hệ thống ISO">
                        @error('title')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 4. Thời gian ban hành và 5. Cập nhật mới nhất -->
                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Thời gian ban hành</label>
                        <input type="date" name="issued_date" value="{{ old('issued_date', $isoSystemDocument->issued_date ? $isoSystemDocument->issued_date->format('Y-m-d') : '') }}" 
                               class="admin-form__input @error('issued_date') admin-form__input--error @enderror">
                        @error('issued_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label">Cập nhật mới nhất</label>
                        <input type="date" name="latest_update" value="{{ old('latest_update', $isoSystemDocument->latest_update ? $isoSystemDocument->latest_update->format('Y-m-d') : '') }}" 
                               class="admin-form__input @error('latest_update') admin-form__input--error @enderror">
                        @error('latest_update')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 6. Đơn vị áp dụng -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Đơn vị áp dụng</label>
                        <select name="department_ids[]" id="department_ids" multiple
                                class="admin-form__select select2 @error('department_ids') admin-form__select--error @enderror">
                            <option value="all">Chọn tất cả</option>
                            @foreach($departments as $department)
                                @php
                                    $selected = false;
                                    if (old('department_ids')) {
                                        $selected = in_array($department->id, old('department_ids', []));
                                    } else {
                                        // For existing document, check if this department is selected in the pivot relationship
                                        $selected = $isoSystemDocument->departments && $isoSystemDocument->departments->contains('id', $department->id);
                                    }
                                @endphp
                                <option value="{{ $department->id }}" {{ $selected ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_ids')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                        @error('department_ids.*')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Current Files Section -->
                @if($isoSystemDocument->pdf_file_name || $isoSystemDocument->word_file_name)
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File hiện tại</label>
                        <div class="current-files-info">
                            @if($isoSystemDocument->pdf_file_name)
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $isoSystemDocument->pdf_file_name }}</div>
                                        <div class="current-file-info__meta">{{ number_format($isoSystemDocument->pdf_file_size / 1024 / 1024, 2) }}MB • PDF</div>
                                    </div>
                                    <a href="{{ route('admin.iso-system-documents.download', [$isoSystemDocument, 'pdf']) }}" class="current-file-info__download">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($isoSystemDocument->word_file_name)
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $isoSystemDocument->word_file_name }}</div>
                                        <div class="current-file-info__meta">{{ number_format($isoSystemDocument->word_file_size / 1024 / 1024, 2) }}MB • {{ strtoupper($isoSystemDocument->word_file_type) }}</div>
                                    </div>
                                    <a href="{{ route('admin.iso-system-documents.download', [$isoSystemDocument, 'word']) }}" class="current-file-info__download">
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

                <!-- 7. File PDF -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File PDF (Tùy chọn - để trống nếu không đổi)</label>
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

                <!-- 8. File Word -->
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
                                <span>Chọn file Word mới hoặc kéo thả vào đây</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Định dạng: DOC, DOCX. Kích thước tối đa: 50MB</small>
                        @error('word_file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <a href="{{ isset($category) ? route('admin.iso-system-documents.category', $category) : route('admin.iso-system-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật văn bản
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
    'Chọn file Word mới hoặc kéo thả vào đây',
    50 * 1024 * 1024, // 50MB
    ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword']
);

// Initialize Select2 for dropdowns
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $.fn.select2) {
        
        // Department dropdown (multiple selection)
        $('#department_ids').select2({
            placeholder: '-- Chọn đơn vị áp dụng (có thể chọn nhiều) --',
            allowClear: true,
            width: '100%',
            dropdownCssClass: 'select2-dropdown-small',
            containerCssClass: 'select2-container-small'
        });

        // Handle "Select All" functionality
        $('#department_ids').on('select2:select', function(e) {
            var selectedValue = e.params.data.id;
            
            if (selectedValue === 'all') {
                // Select all options except "Select All"
                var allValues = [];
                $('#department_ids option').each(function() {
                    if ($(this).val() !== 'all' && $(this).val() !== '') {
                        allValues.push($(this).val());
                    }
                });
                $('#department_ids').val(allValues).trigger('change');
            }
        });

        $('#department_ids').on('select2:unselect', function(e) {
            var unselectedValue = e.params.data.id;
            
            // If any individual item is unselected, also unselect "Select All"
            if (unselectedValue !== 'all') {
                var currentValues = $('#department_ids').val() || [];
                if (currentValues.includes('all')) {
                    var newValues = currentValues.filter(val => val !== 'all');
                    $('#department_ids').val(newValues).trigger('change');
                }
            }
        });
    }
});
</script>
@endsection
