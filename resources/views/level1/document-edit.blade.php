@extends('layouts.level1')

@section('title', 'Chỉnh sửa tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <div>
            <h1 class="level1-page__title">Chỉnh sửa tài liệu</h1>
            <p class="level1-page__subtitle">Cập nhật thông tin và nội dung tài liệu</p>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.documents') }}" class="level1-btn level1-btn--secondary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="level1-alert level1-alert--error">
        <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <strong>Có lỗi xảy ra:</strong>
            <ul style="margin: 4px 0 0 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="level1-card">
        <form method="POST" action="{{ route('level1.documents.update', $document) }}" enctype="multipart/form-data" class="level1-form">
            @csrf
            @method('PUT')
            
            <div class="level1-form__section">
                <h3 class="level1-form__section-title">Thông tin cơ bản</h3>
                
                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label level1-form__label--required">Tiêu đề tài liệu</label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" 
                               class="level1-form__input @error('title') level1-form__input--error @enderror" 
                               placeholder="Nhập tiêu đề tài liệu...">
                        @error('title')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Mô tả</label>
                        <textarea name="description" rows="3" 
                                  class="level1-form__textarea @error('description') level1-form__textarea--error @enderror" 
                                  placeholder="Mô tả ngắn gọn về tài liệu...">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--half">
                        <label class="level1-form__label level1-form__label--required">Loại tài liệu</label>
                        <select name="document_type" class="level1-form__select @error('document_type') level1-form__select--error @enderror">
                            <option value="">Chọn loại tài liệu...</option>
                            <option value="policy" {{ old('document_type', $document->document_type) == 'policy' ? 'selected' : '' }}>Chính sách</option>
                            <option value="procedure" {{ old('document_type', $document->document_type) == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                            <option value="form" {{ old('document_type', $document->document_type) == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                            <option value="manual" {{ old('document_type', $document->document_type) == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                            <option value="report" {{ old('document_type', $document->document_type) == 'report' ? 'selected' : '' }}>Báo cáo</option>
                            <option value="other" {{ old('document_type', $document->document_type) == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('document_type')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="level1-form__group level1-form__group--half">
                        <label class="level1-form__label">Phiên bản</label>
                        <input type="text" name="version" value="{{ old('version', $document->version) }}" 
                               class="level1-form__input @error('version') level1-form__input--error @enderror" 
                               placeholder="VD: 1.0, 2.1...">
                        <small class="level1-form__help">Phiên bản sẽ tự động tăng nếu thay đổi file</small>
                        @error('version')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="level1-form__section">
                <h3 class="level1-form__section-title">File tài liệu</h3>
                
                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">File hiện tại</label>
                        <div class="level1-form__current-file">
                            <div class="level1-form__file-info">
                                <svg class="level1-form__file-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <div class="level1-form__file-name">{{ $document->file_name }}</div>
                                    <div class="level1-form__file-meta">
                                        {{ strtoupper($document->file_type) }} • {{ number_format($document->file_size / 1024, 1) }} KB
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('level1.documents.download', $document) }}" 
                               class="level1-btn level1-btn--sm level1-btn--secondary">
                                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Tải xuống
                            </a>
                        </div>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Thay thế file (tùy chọn)</label>
                        <input type="file" name="file" 
                               class="level1-form__file @error('file') level1-form__file--error @enderror"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                        <small class="level1-form__help">Chấp nhận: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT (tối đa 50MB)</small>
                        @error('file')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="level1-form__section">
                <h3 class="level1-form__section-title">Thông tin bổ sung</h3>
                
                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--half">
                        <label class="level1-form__label">Ngày có hiệu lực</label>
                        <input type="date" name="effective_date" 
                               value="{{ old('effective_date', $document->effective_date ? $document->effective_date->format('Y-m-d') : '') }}" 
                               class="level1-form__input @error('effective_date') level1-form__input--error @enderror">
                        @error('effective_date')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="level1-form__group level1-form__group--half">
                        <label class="level1-form__label">Ngày hết hiệu lực</label>
                        <input type="date" name="expiry_date" 
                               value="{{ old('expiry_date', $document->expiry_date ? $document->expiry_date->format('Y-m-d') : '') }}" 
                               class="level1-form__input @error('expiry_date') level1-form__input--error @enderror">
                        @error('expiry_date')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Từ khóa (Tags)</label>
                        <input type="text" name="tags" 
                               value="{{ old('tags', $document->tags ? implode(', ', $document->tags) : '') }}" 
                               class="level1-form__input @error('tags') level1-form__input--error @enderror" 
                               placeholder="VD: chính sách, quy định, nhân sự...">
                        <small class="level1-form__help">Các từ khóa phân cách bởi dấu phẩy</small>
                        @error('tags')
                        <span class="level1-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <div class="level1-form__checkbox">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" id="is_public" name="is_public" value="1" 
                                   {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
                            <label for="is_public" class="level1-form__checkbox-label">
                                Công khai tài liệu (tất cả người dùng có thể truy cập)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="level1-form__actions">
                <button type="submit" class="level1-btn level1-btn--primary">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Cập nhật tài liệu
                </button>
                <a href="{{ route('level1.documents') }}" class="level1-btn level1-btn--secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>
@endsection