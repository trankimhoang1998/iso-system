@extends('layouts.admin')

@section('title', 'Chỉnh sửa tài liệu - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.documents') }}" class="admin-breadcrumb__item">Quản lý tài liệu</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Chỉnh sửa: {{ Str::limit($document->title, 50) }}</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Chỉnh sửa tài liệu</h1>
            <p class="admin-page__subtitle">{{ $document->title }}</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.documents') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
            <a href="{{ route('admin.documents.show', $document) }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Xem chi tiết
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.documents.update', $document) }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Tiêu đề tài liệu</label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" required 
                               class="admin-form__input @error('title') admin-form__input--error @enderror"
                               placeholder="Nhập tiêu đề tài liệu">
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
                                  placeholder="Nhập mô tả tài liệu (tùy chọn)">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Loại tài liệu</label>
                        <select name="document_type" required 
                                class="admin-form__select @error('document_type') admin-form__select--error @enderror">
                            <option value="">-- Chọn loại tài liệu --</option>
                            <option value="policy" {{ old('document_type', $document->document_type) == 'policy' ? 'selected' : '' }}>Chính sách</option>
                            <option value="procedure" {{ old('document_type', $document->document_type) == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                            <option value="form" {{ old('document_type', $document->document_type) == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                            <option value="manual" {{ old('document_type', $document->document_type) == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                            <option value="report" {{ old('document_type', $document->document_type) == 'report' ? 'selected' : '' }}>Báo cáo</option>
                            <option value="other" {{ old('document_type', $document->document_type) == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('document_type')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form__group">
                        <label class="admin-form__label">Phiên bản</label>
                        <input type="text" name="version" value="{{ old('version', $document->version) }}" 
                               class="admin-form__input @error('version') admin-form__input--error @enderror"
                               placeholder="1.0">
                        @error('version')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Thay thế file (tùy chọn)</label>
                        <div class="admin-form__current-file">
                            <div class="admin-current-file">
                                <svg class="admin-current-file__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="admin-current-file__details">
                                    <div class="admin-current-file__name">{{ $document->file_name }}</div>
                                    <div class="admin-current-file__size">{{ $document->getFormattedFileSize() }}</div>
                                </div>
                                <a href="{{ route('admin.documents.download', $document) }}" 
                                   class="admin-btn admin-btn--sm admin-btn--secondary">Tải xuống</a>
                            </div>
                        </div>
                        <div class="admin-file-upload">
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                                   class="admin-file-upload__input @error('file') admin-form__input--error @enderror" 
                                   id="adminFileInput">
                            <label for="adminFileInput" class="admin-file-upload__label">
                                <svg class="admin-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file mới để thay thế</span>
                            </label>
                        </div>
                        <small class="admin-form__help">Để trống nếu không muốn thay đổi file hiện tại. Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Kích thước tối đa: 50MB</small>
                        @error('file')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Ngày có hiệu lực</label>
                        <input type="date" name="effective_date" value="{{ old('effective_date', $document->effective_date ? $document->effective_date->format('Y-m-d') : '') }}" 
                               class="admin-form__input @error('effective_date') admin-form__input--error @enderror">
                        @error('effective_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form__group">
                        <label class="admin-form__label">Ngày hết hiệu lực</label>
                        <input type="date" name="expiry_date" value="{{ old('expiry_date', $document->expiry_date ? $document->expiry_date->format('Y-m-d') : '') }}" 
                               class="admin-form__input @error('expiry_date') admin-form__input--error @enderror">
                        @error('expiry_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags', $document->tags ? implode(', ', $document->tags) : '') }}" 
                               class="admin-form__input @error('tags') admin-form__input--error @enderror"
                               placeholder="ISO, quy trình, chính sách (phân tách bằng dấu phẩy)">
                        <small class="admin-form__help">Phân tách các tag bằng dấu phẩy</small>
                        @error('tags')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__checkbox-label">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}
                                   class="admin-form__checkbox">
                            <span class="admin-form__checkbox-text">Công khai cho tất cả người dùng</span>
                        </label>
                    </div>
                </div>

                <div class="admin-form__actions">
                    <a href="{{ route('admin.documents.show', $document) }}" class="admin-btn admin-btn--secondary">Hủy</a>
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
        label.textContent = 'Chọn file mới để thay thế';
    }
});
</script>
@endsection