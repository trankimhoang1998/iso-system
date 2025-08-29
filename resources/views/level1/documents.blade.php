@extends('layouts.level1')

@section('title', 'Quản lý tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <div>
            <h1 class="level1-page__title">Quản lý tài liệu</h1>
            <p class="level1-page__subtitle">Tải lên và quản lý các tài liệu ISO của bạn</p>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.documents.permissions') }}" class="level1-btn level1-btn--secondary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Quản lý quyền
            </a>
            <button type="button" class="level1-btn level1-btn--primary" onclick="showUploadModal()">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Tải lên tài liệu
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level1-filter">
        <form method="GET" action="{{ route('level1.documents') }}" class="level1-filter__form">
            <div class="level1-filter__row">
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="level1-filter__input">
                </div>
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Loại tài liệu</label>
                    <select name="document_type" class="level1-filter__select">
                        <option value="">Tất cả</option>
                        <option value="policy" {{ request('document_type') == 'policy' ? 'selected' : '' }}>Chính sách</option>
                        <option value="procedure" {{ request('document_type') == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                        <option value="form" {{ request('document_type') == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                        <option value="manual" {{ request('document_type') == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                        <option value="report" {{ request('document_type') == 'report' ? 'selected' : '' }}>Báo cáo</option>
                        <option value="other" {{ request('document_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Trạng thái</label>
                    <select name="status" class="level1-filter__select">
                        <option value="">Tất cả</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                    </select>
                </div>
                <div class="level1-filter__actions">
                    <button type="submit" class="level1-btn level1-btn--primary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level1.documents') }}" class="level1-btn level1-btn--secondary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($documents->count() > 0)
    <div class="level1-table-container">
        <table class="level1-table">
            <thead class="level1-table__head">
                <tr>
                    <th class="level1-table__header">ID</th>
                    <th class="level1-table__header">Tiêu đề</th>
                    <th class="level1-table__header">Loại tài liệu</th>
                    <th class="level1-table__header">Phiên bản</th>
                    <th class="level1-table__header">Trạng thái</th>
                    <th class="level1-table__header">Kích thước</th>
                    <th class="level1-table__header">Công khai</th>
                    <th class="level1-table__header">Ngày tải lên</th>
                    <th class="level1-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="level1-table__body">
                @foreach($documents as $document)
                <tr class="level1-table__row">
                    <td class="level1-table__cell">{{ $document->id }}</td>
                    <td class="level1-table__cell">
                        <div class="level1-document-info">
                            <div class="level1-document-info__title">{{ $document->title }}</div>
                            @if($document->description)
                            <div class="level1-document-info__description">{{ Str::limit($document->description, 50) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="level1-table__cell">
                        <span class="level1-badge level1-badge--{{ $document->document_type }}">
                            {{ $document->getDocumentTypeName() }}
                        </span>
                    </td>
                    <td class="level1-table__cell">{{ $document->version }}</td>
                    <td class="level1-table__cell">
                        @if($document->status === 'draft')
                        <span class="level1-status level1-status--draft">{{ $document->getStatusName() }}</span>
                        @elseif($document->status === 'approved')
                        <span class="level1-status level1-status--approved">{{ $document->getStatusName() }}</span>
                        @else
                        <span class="level1-status level1-status--archived">{{ $document->getStatusName() }}</span>
                        @endif
                    </td>
                    <td class="level1-table__cell">{{ $document->getFormattedFileSize() }}</td>
                    <td class="level1-table__cell">
                        @if($document->is_public)
                        <span class="level1-badge level1-badge--success">Công khai</span>
                        @else
                        <span class="level1-badge level1-badge--secondary">Riêng tư</span>
                        @endif
                    </td>
                    <td class="level1-table__cell">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                    <td class="level1-table__cell">
                        <div class="level1-table__actions">
                            @if($document->canUserDownload(auth()->user()))
                            <a href="{{ route('level1.documents.download', $document) }}" 
                               class="level1-btn level1-btn--sm level1-btn--success" 
                               title="Tải xuống">
                                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                            @endif
                            
                            @if($document->uploaded_by === auth()->id())
                            <a href="{{ route('level1.documents.permissions') }}?document_id={{ $document->id }}" 
                               class="level1-btn level1-btn--sm level1-btn--warning" 
                               title="Quản lý quyền">
                                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="level1-pagination-wrapper">
        {{ $documents->links('components.level1-pagination') }}
    </div>
    @else
    <div class="level1-documents__empty">
        <div class="level1-empty-state">
            <svg class="level1-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="level1-empty-state__title">Chưa có tài liệu nào</h3>
            <p class="level1-empty-state__description">Bắt đầu bằng cách tải lên tài liệu đầu tiên của bạn</p>
            <button class="level1-empty-state__btn" onclick="showUploadModal()">
                Tải lên tài liệu
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="level1-modal" style="display: none;">
    <div class="level1-modal__backdrop" onclick="hideUploadModal()"></div>
    <div class="level1-modal__content">
        <div class="level1-modal__header">
            <h2 class="level1-modal__title">Tải lên tài liệu mới</h2>
            <button type="button" class="level1-modal__close" onclick="hideUploadModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('level1.documents.store') }}" method="POST" enctype="multipart/form-data" class="level1-form" id="uploadForm">
            @csrf
            <div class="level1-modal__body">
                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label level1-form__label--required">Tiêu đề</label>
                        <input type="text" name="title" required class="level1-form__input" placeholder="Nhập tiêu đề tài liệu">
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Mô tả</label>
                        <textarea name="description" rows="3" class="level1-form__textarea" placeholder="Nhập mô tả tài liệu (tùy chọn)"></textarea>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label level1-form__label--required">Loại tài liệu</label>
                        <select name="document_type" required class="level1-form__select">
                            <option value="">Chọn loại tài liệu</option>
                            <option value="policy">Chính sách</option>
                            <option value="procedure">Quy trình</option>
                            <option value="form">Biểu mẫu</option>
                            <option value="manual">Hướng dẫn</option>
                            <option value="report">Báo cáo</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="level1-form__group">
                        <label class="level1-form__label">Phiên bản</label>
                        <input type="text" name="version" class="level1-form__input" placeholder="1.0" value="1.0">
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group">
                        <label class="level1-form__label">Ngày có hiệu lực</label>
                        <input type="date" name="effective_date" class="level1-form__input">
                    </div>
                    <div class="level1-form__group">
                        <label class="level1-form__label">Ngày hết hiệu lực</label>
                        <input type="date" name="expiry_date" class="level1-form__input">
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Tags</label>
                        <input type="text" name="tags" class="level1-form__input" placeholder="Nhập tags phân cách bằng dấu phẩy">
                        <div class="level1-form__help">Ví dụ: ISO 9001, Chất lượng, Quy trình</div>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label level1-form__label--required">File tài liệu</label>
                        <div class="level1-file-upload">
                            <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" 
                                   class="level1-file-upload__input" id="fileInput">
                            <label for="fileInput" class="level1-file-upload__label">
                                <svg class="level1-file-upload__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span>Chọn file hoặc kéo thả vào đây</span>
                            </label>
                        </div>
                        <div class="level1-form__help">Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT (tối đa 50MB)</div>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <div class="level1-checkbox">
                            <input type="checkbox" name="is_public" value="1" id="isPublic" class="level1-checkbox__input">
                            <label for="isPublic" class="level1-checkbox__label">Công khai tài liệu (tất cả người dùng có thể xem và tải xuống)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="level1-modal__footer">
                <button type="button" class="level1-btn level1-btn--secondary" onclick="hideUploadModal()">Hủy</button>
                <button type="submit" class="level1-btn level1-btn--primary">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Tải lên
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showUploadModal() {
    document.getElementById('uploadModal').style.display = 'flex';
}

function hideUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
    document.getElementById('uploadForm').reset();
}

// File upload preview
document.getElementById('fileInput').addEventListener('change', function(e) {
    const label = document.querySelector('.level1-file-upload__label span');
    if (e.target.files.length > 0) {
        label.textContent = e.target.files[0].name;
    } else {
        label.textContent = 'Chọn file hoặc kéo thả vào đây';
    }
});
</script>
@endsection