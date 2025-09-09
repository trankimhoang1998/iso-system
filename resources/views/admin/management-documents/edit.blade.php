@extends('layouts.admin')

@section('title', 'Chỉnh sửa văn bản - Quản lý')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.management-documents.index') }}" class="admin-breadcrumb__item">Tài liệu quản lý</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Sửa tài liệu</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Sửa văn bản quản lý</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin văn bản quản lý</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.management-documents.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.management-documents.update', $managementDocument) }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Số văn bản</label>
                        <input type="text" name="document_number" value="{{ old('document_number', $managementDocument->document_number) }}" 
                               class="admin-form__input @error('document_number') admin-form__input--error @enderror"
                               placeholder="Nhập số văn bản">
                        @error('document_number')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Ngày ban hành</label>
                        <input type="date" name="issued_date" value="{{ old('issued_date', $managementDocument->issued_date?->format('Y-m-d')) }}" 
                               class="admin-form__input @error('issued_date') admin-form__input--error @enderror">
                        @error('issued_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Cơ quan ban hành</label>
                        <input type="text" name="issuing_agency" value="{{ old('issuing_agency', $managementDocument->issuing_agency) }}" 
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
                                  placeholder="Nhập trích yếu tài liệu">{{ old('summary', $managementDocument->summary) }}</textarea>
                        @error('summary')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Current Files Section -->
                @if($managementDocument->hasPdfFile() || $managementDocument->hasWordFile())
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File hiện tại</label>
                        <div class="current-files-info">
                            @if($managementDocument->hasPdfFile())
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $managementDocument->pdf_file_name }}</div>
                                        <div class="current-file-info__meta">{{ $managementDocument->getFormattedPdfFileSize() }} • PDF</div>
                                    </div>
                                    <a href="{{ route('admin.management-documents.download', [$managementDocument, 'pdf']) }}" class="current-file-info__download">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($managementDocument->hasWordFile())
                            <div class="current-file-info">
                                <div class="current-file-info__item">
                                    <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div class="current-file-info__details">
                                        <div class="current-file-info__name">{{ $managementDocument->word_file_name }}</div>
                                        <div class="current-file-info__meta">{{ $managementDocument->getFormattedWordFileSize() }} • {{ strtoupper($managementDocument->word_file_type) }}</div>
                                    </div>
                                    <a href="{{ route('admin.management-documents.download', [$managementDocument, 'word']) }}" class="current-file-info__download">
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
                        <label class="admin-form__label {{ !$managementDocument->hasPdfFile() ? 'admin-form__label--required' : '' }}">File PDF {{ $managementDocument->hasPdfFile() ? '(Không bắt buộc - để trống nếu không đổi)' : '(Bắt buộc)' }}</label>
                        <div class="admin-file-upload">
                            <input type="file" name="pdf_file" accept=".pdf"
                                   class="admin-file-upload__input @error('pdf_file') admin-form__input--error @enderror" 
                                   id="adminPdfFileInput" {{ !$managementDocument->hasPdfFile() ? 'data-required="true"' : '' }}>
                            <label for="adminPdfFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>{{ $managementDocument->hasPdfFile() ? 'Chọn file PDF mới hoặc kéo thả vào đây (để trống nếu không đổi)' : 'Chọn file PDF hoặc kéo thả vào đây' }}</span>
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
                        <label class="admin-form__label">File Word (Không bắt buộc)</label>
                        <div class="admin-file-upload">
                            <input type="file" name="word_file" accept=".doc,.docx"
                                   class="admin-file-upload__input @error('word_file') admin-form__input--error @enderror" 
                                   id="adminWordFileInput">
                            <label for="adminWordFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file Word hoặc kéo thả vào đây (tùy chọn)</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Định dạng: DOC, DOCX. Kích thước tối đa: 50MB</small>
                        @error('word_file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="admin-form__actions">
                    <a href="{{ route('admin.management-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
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
const hasPdfFile = {{ $managementDocument->hasPdfFile() ? 'true' : 'false' }};
handleFileSelect(
    'adminPdfFileInput',
    'label[for="adminPdfFileInput"] span',
    hasPdfFile ? 'Chọn file PDF mới hoặc kéo thả vào đây (để trống nếu không đổi)' : 'Chọn file PDF hoặc kéo thả vào đây',
    50 * 1024 * 1024, // 50MB
    ['application/pdf']
);

// Initialize Word file upload
handleFileSelect(
    'adminWordFileInput',
    'label[for="adminWordFileInput"] span',
    'Chọn file Word hoặc kéo thả vào đây (tùy chọn)',
    50 * 1024 * 1024, // 50MB
    ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword']
);

</script>
@endsection