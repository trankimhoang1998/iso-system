@extends('layouts.admin')

@section('title', 'Thêm tài liệu - Hệ thống ISO')

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
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Thêm văn bản mới</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Thêm tài liệu hệ thống ISO</h1>
            <p class="admin-page__subtitle">Tạo và quản lý tài liệu hệ thống ISO mới</p>
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
            <form method="POST" action="{{ route('admin.iso-system-documents.store') }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                

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
                                    <option value="{{ $categoryOption['id'] }}" 
                                        {{ (old('category_id') ?? (isset($category) ? $category->id : null)) == $categoryOption['id'] ? 'selected' : '' }}>
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
                        <label class="admin-form__label admin-form__label--required">Ký hiệu</label>
                        <input type="text" name="symbol" value="{{ old('symbol') }}" 
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
                        <input type="text" name="title" value="{{ old('title') }}" 
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
                        <label class="admin-form__label admin-form__label--required">Thời gian ban hành</label>
                        <input type="date" name="issued_date" value="{{ old('issued_date') }}" 
                               class="admin-form__input @error('issued_date') admin-form__input--error @enderror">
                        @error('issued_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Cập nhật mới nhất</label>
                        <input type="date" name="latest_update" value="{{ old('latest_update') }}" 
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
                                <option value="{{ $department->id }}" {{ in_array($department->id, old('department_ids', [])) ? 'selected' : '' }}>
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


                <!-- 7. File PDF -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">File PDF</label>
                        <div class="admin-file-upload">
                            <input type="file" name="pdf_file" accept=".pdf"
                                   class="admin-file-upload__input @error('pdf_file') admin-form__input--error @enderror" 
                                   id="adminPdfFileInput">
                            <label for="adminPdfFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file PDF hoặc kéo thả vào đây</span>
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
                    <a href="{{ isset($category) ? route('admin.iso-system-documents.category', $category) : route('admin.iso-system-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Tải lên
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
    'Chọn file PDF hoặc kéo thả vào đây',
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