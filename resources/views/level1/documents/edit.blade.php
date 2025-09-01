@extends('layouts.level1')

@section('title', 'Chỉnh sửa tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-breadcrumb">
        <a href="{{ route('level1.documents') }}" class="level1-breadcrumb__item">Quản lý tài liệu</a>
        <svg class="level1-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="level1-breadcrumb__item level1-breadcrumb__item--current">Chỉnh sửa: {{ Str::limit($document->title, 50) }}</span>
    </div>
    
    <div class="level1-page__header">
        <div class="level1-page__title-section">
            <h1 class="level1-page__title">Chỉnh sửa tài liệu</h1>
            <p class="level1-page__subtitle">{{ $document->title }}</p>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.documents') }}" class="level1-btn level1-btn--secondary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
            <a href="{{ route('level1.documents.show', $document) }}" class="level1-btn level1-btn--primary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Xem chi tiết
            </a>
        </div>
    </div>

    <div class="level1-document-form">
        <div class="level1-card">
            <form method="POST" action="{{ route('level1.documents.update', $document) }}" class="level1-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label level1-form__label--required">Tiêu đề tài liệu</label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" required 
                               class="level1-form__input @error('title') level1-form__input--error @enderror"
                               placeholder="Nhập tiêu đề tài liệu">
                        @error('title')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Mô tả</label>
                        <textarea name="description" rows="4" 
                                  class="level1-form__input @error('description') level1-form__input--error @enderror"
                                  placeholder="Nhập mô tả tài liệu (tùy chọn)">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div> -->

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Mô tả</label>
                        <textarea name="description" rows="4" 
                                  class="level1-form__input @error('description') level1-form__input--error @enderror"
                                  placeholder="Nhập mô tả tài liệu (tùy chọn)">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row level1-form__row--split">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Danh mục</label>
                        <select name="category_id" 
                                class="level1-form__select @error('category_id') level1-form__select--error @enderror">
                            <option value="">-- Chọn danh mục (tùy chọn) --</option>
                            @foreach(\App\Models\Category::getFlatList() as $category)
                                <option value="{{ $category['id'] }}" {{ old('category_id', $document->category_id) == $category['id'] ? 'selected' : '' }}>
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="level1-form__group">
                        <label class="level1-form__label level1-form__label--required">Loại tài liệu</label>
                        <select name="document_type" required 
                                class="level1-form__select @error('document_type') level1-form__select--error @enderror">
                            <option value="">-- Chọn loại tài liệu --</option>
                            <option value="policy" {{ old('document_type', $document->document_type) == 'policy' ? 'selected' : '' }}>Chính sách</option>
                            <option value="procedure" {{ old('document_type', $document->document_type) == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                            <option value="form" {{ old('document_type', $document->document_type) == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                            <option value="manual" {{ old('document_type', $document->document_type) == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                            <option value="report" {{ old('document_type', $document->document_type) == 'report' ? 'selected' : '' }}>Báo cáo</option>
                            <option value="other" {{ old('document_type', $document->document_type) == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('document_type')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="level1-form__group">
                        <label class="level1-form__label">Phiên bản</label>
                        <input type="text" name="version" value="{{ old('version', $document->version) }}" 
                               class="level1-form__input @error('version') level1-form__input--error @enderror"
                               placeholder="1.0">
                        @error('version')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Thay thế file (tùy chọn)</label>
                        <div class="level1-form__current-file">
                            <div class="level1-current-file">
                                <svg class="level1-current-file__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="level1-current-file__details">
                                    <div class="level1-current-file__name">{{ $document->file_name }}</div>
                                    <div class="level1-current-file__size">{{ $document->getFormattedFileSize() }}</div>
                                </div>
                                <a href="{{ route('level1.documents.download', $document) }}" 
                                   class="level1-btn level1-btn--sm level1-btn--secondary">Tải xuống</a>
                            </div>
                        </div>
                        <div class="level1-file-upload">
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                                   class="level1-file-upload__input @error('file') level1-form__input--error @enderror" 
                                   id="level1FileInput">
                            <label for="level1FileInput" class="level1-file-upload__label">
                                <svg class="level1-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file mới để thay thế</span>
                            </label>
                        </div>
                        <small class="level1-form__help">Để trống nếu không muốn thay đổi file hiện tại. Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Kích thước tối đa: 50MB</small>
                        @error('file')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row level1-form__row--split">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Ngày có hiệu lực</label>
                        <input type="date" name="effective_date" value="{{ old('effective_date', $document->effective_date ? $document->effective_date->format('Y-m-d') : '') }}" 
                               class="level1-form__input @error('effective_date') level1-form__input--error @enderror">
                        @error('effective_date')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="level1-form__group">
                        <label class="level1-form__label">Ngày hết hiệu lực</label>
                        <input type="date" name="expiry_date" value="{{ old('expiry_date', $document->expiry_date ? $document->expiry_date->format('Y-m-d') : '') }}" 
                               class="level1-form__input @error('expiry_date') level1-form__input--error @enderror">
                        @error('expiry_date')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags', $document->tags ? implode(', ', $document->tags) : '') }}" 
                               class="level1-form__input @error('tags') level1-form__input--error @enderror"
                               placeholder="ISO, quy trình, chính sách (phân tách bằng dấu phẩy)">
                        <small class="level1-form__help">Phân tách các tag bằng dấu phẩy</small>
                        @error('tags')
                        <div class="level1-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__checkbox-label">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}
                                   class="level1-form__checkbox">
                            <span class="level1-form__checkbox-text">Công khai tài liệu (tất cả người dùng có thể truy cập)</span>
                        </label>
                    </div>
                </div>

                <div class="level1-form__actions">
                    <a href="{{ route('level1.documents.show', $document) }}" class="level1-btn level1-btn--secondary">Hủy</a>
                    <button type="submit" class="level1-btn level1-btn--primary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
document.getElementById('level1FileInput').addEventListener('change', function(e) {
    const label = document.querySelector('.level1-file-upload__label span');
    if (e.target.files.length > 0) {
        label.textContent = e.target.files[0].name;
    } else {
        label.textContent = 'Chọn file mới để thay thế';
    }
});
</script>
@endsection