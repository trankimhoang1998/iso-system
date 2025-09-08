@extends('layouts.admin')

@section('title', 'Thêm văn bản - Ban chỉ đạo ISO')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        @if(isset($category))
            <a href="{{ route('admin.iso-directive-documents.category', $category) }}" class="admin-breadcrumb__item">{{ $category->name }}</a>
        @else
            <a href="{{ route('admin.iso-directive-documents.index') }}" class="admin-breadcrumb__item">Văn bản chỉ đạo ISO</a>
        @endif
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Thêm văn bản mới</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Cập nhật văn bản pháp lý thuộc HTQLCL ISO 9001:2015</h1>
            <p class="admin-page__subtitle">Tải lên và quản lý văn bản pháp lý mới thuộc HTQLCL ISO 9001:2015</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ isset($category) ? route('admin.iso-directive-documents.category', $category) : route('admin.iso-directive-documents.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.iso-directive-documents.store') }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                

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
                                        {{ old('category_id') == $categoryOption['id'] ? 'selected' : '' }}>
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
                        <label class="admin-form__label">Thời gian ban hành</label>
                        <input type="date" name="issued_date" value="{{ old('issued_date') }}" 
                               class="admin-form__input @error('issued_date') admin-form__input--error @enderror">
                        @error('issued_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label">Số văn bản</label>
                        <input type="text" name="document_number" value="{{ old('document_number') }}" 
                               class="admin-form__input @error('document_number') admin-form__input--error @enderror"
                               placeholder="Nhập số văn bản">
                        @error('document_number')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Cơ quan ban hành</label>
                        <input type="text" name="issuing_agency" value="{{ old('issuing_agency') }}" 
                               class="admin-form__input @error('issuing_agency') admin-form__input--error @enderror"
                               placeholder="Nhập cơ quan ban hành">
                        @error('issuing_agency')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Trích yếu</label>
                        <textarea name="summary" rows="3" 
                                  class="admin-form__input @error('summary') admin-form__input--error @enderror"
                                  placeholder="Nhập trích yếu tài liệu (tùy chọn)">{{ old('summary') }}</textarea>
                        @error('summary')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- PDF File Upload (Required) -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">File PDF (Bắt buộc)</label>
                        <div class="admin-file-upload">
                            <input type="file" name="pdf_file" accept=".pdf"
                                   class="admin-file-upload__input @error('pdf_file') admin-form__input--error @enderror" 
                                   id="adminPdfFileInput" data-required="true">
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

                <!-- Word File Upload (Optional) -->
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
                    <a href="{{ isset($category) ? route('admin.iso-directive-documents.category', $category) : route('admin.iso-directive-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
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
// PDF File upload preview
document.getElementById('adminPdfFileInput').addEventListener('change', function(e) {
    const label = document.querySelector('label[for="adminPdfFileInput"] span');
    if (e.target.files.length > 0) {
        label.textContent = e.target.files[0].name;
    } else {
        label.textContent = 'Chọn file PDF hoặc kéo thả vào đây';
    }
});

// Word File upload preview
document.getElementById('adminWordFileInput').addEventListener('change', function(e) {
    const label = document.querySelector('label[for="adminWordFileInput"] span');
    if (e.target.files.length > 0) {
        label.textContent = e.target.files[0].name;
    } else {
        label.textContent = 'Chọn file Word hoặc kéo thả vào đây (tùy chọn)';
    }
});

// PDF File size validation
document.getElementById('adminPdfFileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('Kích thước file PDF không được vượt quá 50MB');
            this.value = '';
            document.querySelector('label[for="adminPdfFileInput"] span').textContent = 'Chọn file PDF hoặc kéo thả vào đây';
            return false;
        }
    }
});

// Word File size validation
document.getElementById('adminWordFileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('Kích thước file Word không được vượt quá 50MB');
            this.value = '';
            document.querySelector('label[for="adminWordFileInput"] span').textContent = 'Chọn file Word hoặc kéo thả vào đây (tùy chọn)';
            return false;
        }
    }
});

</script>
@endsection