@extends('layouts.admin')

@section('title', 'Thêm tài liệu quản lý - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.management-documents.index') }}" class="admin-breadcrumb__item">Tài liệu quản lý</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Thêm tài liệu mới</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Thêm tài liệu quản lý</h1>
            <p class="admin-page__subtitle">Tạo và quản lý tài liệu quản lý mới</p>
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
            <form method="POST" action="{{ route('admin.management-documents.store') }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Tiêu đề tài liệu</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="admin-form__input @error('title') admin-form__input--error @enderror"
                               placeholder="Nhập tiêu đề tài liệu quản lý">
                        @error('title')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Mô tả</label>
                        <textarea name="description" rows="4" 
                                  class="admin-form__input @error('description') admin-form__input--error @enderror"
                                  placeholder="Nhập mô tả tài liệu (tùy chọn)">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Danh mục</label>
                        <select name="category_id" id="category_id" required
                                class="admin-form__select @error('category_id') admin-form__select--error @enderror">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- New fields section -->
                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Ký hiệu</label>
                        <input type="text" name="symbol" value="{{ old('symbol') }}" 
                               class="admin-form__input @error('symbol') admin-form__input--error @enderror"
                               placeholder="Nhập ký hiệu tài liệu">
                        @error('symbol')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label">Thời gian</label>
                        <input type="text" name="time_period" value="{{ old('time_period') }}" 
                               class="admin-form__input @error('time_period') admin-form__input--error @enderror"
                               placeholder="Nhập thời gian">
                        @error('time_period')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Số văn bản</label>
                        <input type="text" name="document_number" value="{{ old('document_number') }}" 
                               class="admin-form__input @error('document_number') admin-form__input--error @enderror"
                               placeholder="Nhập số văn bản">
                        @error('document_number')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
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

                <!-- PDF File Upload -->
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">File PDF</label>
                        <div class="admin-file-upload">
                            <input type="file" name="pdf_file" required accept=".pdf"
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

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Trạng thái</label>
                        <select name="status" class="admin-form__select @error('status') admin-form__select--error @enderror">
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                        </select>
                        @error('status')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <a href="{{ route('admin.management-documents.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Tạo tài liệu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// PDF File upload preview and validation
document.getElementById('adminPdfFileInput').addEventListener('change', function(e) {
    const label = this.parentNode.querySelector('.admin-file-upload__label span');
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        label.textContent = file.name;
        
        // File size validation
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('Kích thước file PDF không được vượt quá 50MB');
            this.value = '';
            label.textContent = 'Chọn file PDF hoặc kéo thả vào đây';
        }
    } else {
        label.textContent = 'Chọn file PDF hoặc kéo thả vào đây';
    }
});

// Word File upload preview and validation
document.getElementById('adminWordFileInput').addEventListener('change', function(e) {
    const label = this.parentNode.querySelector('.admin-file-upload__label span');
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        label.textContent = file.name;
        
        // File size validation
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('Kích thước file Word không được vượt quá 50MB');
            this.value = '';
            label.textContent = 'Chọn file Word hoặc kéo thả vào đây';
        }
    } else {
        label.textContent = 'Chọn file Word hoặc kéo thả vào đây';
    }
});
</script>

<style>
/* Page-specific styles - file upload styles are reused from documents/create.blade.php */
.admin-form__row--split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

@media (max-width: 768px) {
    .admin-form__row--split {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>
@endsection
