@extends('layouts.admin')

@section('title', 'Sửa tài liệu: ' . $managementDocument->title)

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
            <h1 class="admin-page__title">Sửa tài liệu quản lý</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin tài liệu: {{ $managementDocument->title }}</p>
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
                        <label class="admin-form__label admin-form__label--required">Tiêu đề tài liệu</label>
                        <input type="text" name="title" value="{{ old('title', $managementDocument->title) }}" required 
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
                                  placeholder="Nhập mô tả tài liệu (tùy chọn)">{{ old('description', $managementDocument->description) }}</textarea>
                        @error('description')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Danh mục</label>
                        <select name="category_id" id="category_id" required
                                class="admin-form__select @error('category_id') admin-form__select--error @enderror">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $managementDocument->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label">Phòng ban</label>
                        <select name="department_id" id="department_id"
                                class="admin-form__select @error('department_id') admin-form__select--error @enderror">
                            <option value="">-- Chọn phòng ban --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $managementDocument->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @if($managementDocument->file_name)
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File hiện tại</label>
                        <div class="current-file-info">
                            <div class="current-file-info__item">
                                <svg class="current-file-info__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="current-file-info__details">
                                    <div class="current-file-info__name">{{ $managementDocument->file_name }}</div>
                                    <div class="current-file-info__meta">{{ $managementDocument->getFormattedFileSize() }} • {{ strtoupper($managementDocument->file_type) }}</div>
                                </div>
                                <a href="{{ route('admin.management-documents.download', $managementDocument) }}" target="_blank" class="current-file-info__download">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">File tài liệu {{ $managementDocument->file_name ? '(Tùy chọn - để trống nếu không đổi)' : '(Bắt buộc)' }}</label>
                        <div class="admin-file-upload">
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                                   class="admin-file-upload__input @error('file') admin-form__input--error @enderror" 
                                   id="adminFileInput" {{ !$managementDocument->file_name ? 'required' : '' }}>
                            <label for="adminFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file mới hoặc kéo thả vào đây</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Kích thước tối đa: 50MB</small>
                        @error('file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Trạng thái</label>
                        <select name="status" class="admin-form__select @error('status') admin-form__select--error @enderror">
                            <option value="draft" {{ old('status', $managementDocument->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="approved" {{ old('status', $managementDocument->status) == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
                            <option value="archived" {{ old('status', $managementDocument->status) == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
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
// File upload preview
document.getElementById('adminFileInput').addEventListener('change', function(e) {
    const label = document.querySelector('.admin-file-upload__label span');
    if (e.target.files.length > 0) {
        label.textContent = e.target.files[0].name;
    } else {
        label.textContent = 'Chọn file mới hoặc kéo thả vào đây';
    }
});

// File size validation
document.getElementById('adminFileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('Kích thước file không được vượt quá 50MB');
            this.value = '';
            document.querySelector('.admin-file-upload__label span').textContent = 'Chọn file mới hoặc kéo thả vào đây';
        }
    }
});
</script>

<style>
.admin-form__row--split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.current-file-info {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px;
    background: #f9fafb;
}

.current-file-info__item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.current-file-info__icon {
    width: 24px;
    height: 24px;
    color: #3b82f6;
    flex-shrink: 0;
}

.current-file-info__details {
    flex: 1;
}

.current-file-info__name {
    font-weight: 500;
    color: #374151;
    margin-bottom: 2px;
}

.current-file-info__meta {
    font-size: 12px;
    color: #6b7280;
}

.current-file-info__download {
    width: 20px;
    height: 20px;
    color: #3b82f6;
    transition: color 0.2s ease;
}

.current-file-info__download:hover {
    color: #2563eb;
}

.current-file-info__download svg {
    width: 100%;
    height: 100%;
}

@media (max-width: 768px) {
    .admin-form__row--split {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>
@endsection