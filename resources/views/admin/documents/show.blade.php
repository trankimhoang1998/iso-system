@extends('layouts.admin')

@section('title', $document->title . ' - Chi tiết tài liệu - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.documents.index') }}" class="admin-breadcrumb__item">Quản lý tài liệu</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">{{ Str::limit($document->title, 50) }}</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">{{ $document->title }}</h1>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.documents.download', $document) }}" 
               class="admin-btn admin-btn--success">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tải xuống
            </a>
            <a href="{{ route('admin.documents.edit', $document) }}" 
               class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
            @if($document->status == 'draft')
            <button class="admin-btn admin-btn--success" 
                    onclick="approveDocument({{ $document->id }}, '{{ $document->title }}')">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Phê duyệt
            </button>
            @elseif($document->status == 'approved')
            <button class="admin-btn admin-btn--warning" 
                    onclick="revokeApproval({{ $document->id }}, '{{ $document->title }}')">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Hủy phê duyệt
            </button>
            @endif
        </div>
    </div>

    <div class="admin-document-viewer">
        <div class="admin-document-header">
            <div class="admin-document-meta">
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Loại tài liệu:</span>
                    <span class="admin-document-type-badge admin-document-type-badge--{{ $document->getDocumentTypeCssClass() }}">
                        {{ $document->getDocumentTypeName() }}
                    </span>
                </div>
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Phiên bản:</span>
                    <span class="admin-document-meta__value">{{ $document->version }}</span>
                </div>
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Kích thước:</span>
                    <span class="admin-document-meta__value">{{ $document->getFormattedFileSize() }}</span>
                </div>
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Trạng thái:</span>
                    <span class="admin-status-badge 
                        @if($document->status == 'approved') admin-status-badge--active 
                        @elseif($document->status == 'draft') admin-status-badge--warning
                        @else admin-status-badge--inactive @endif">
                        {{ $document->getStatusName() }}
                    </span>
                </div>
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Công khai:</span>
                    <span class="admin-document-meta__value">
                        @if($document->is_public)
                            <span class="admin-status-badge admin-status-badge--active">Có</span>
                        @else
                            <span class="admin-status-badge admin-status-badge--inactive">Không</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        @if($document->description)
        <div class="admin-document-description">
            <h3 class="admin-document-description__title">Mô tả</h3>
            <div class="admin-document-description__content">
                {{ $document->description }}
            </div>
        </div>
        @endif

        @if($document->tags && count($document->tags) > 0)
        <div class="admin-document-tags">
            <h3 class="admin-document-tags__title">Tags</h3>
            <div class="admin-document-tags__list">
                @foreach($document->tags as $tag)
                <span class="admin-tag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($document->effective_date || $document->expiry_date)
        <div class="admin-document-dates">
            <h3 class="admin-document-dates__title">Thời hạn hiệu lực</h3>
            <div class="admin-document-dates__content">
                @if($document->effective_date)
                <div class="admin-document-date">
                    <span class="admin-document-date__label">Ngày có hiệu lực:</span>
                    <span class="admin-document-date__value">{{ $document->effective_date->format('d/m/Y') }}</span>
                </div>
                @endif
                @if($document->expiry_date)
                <div class="admin-document-date">
                    <span class="admin-document-date__label">Ngày hết hiệu lực:</span>
                    <span class="admin-document-date__value">{{ $document->expiry_date->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($document->file_path)
        <div class="admin-document-file">
            <h3 class="admin-document-file__title">File đính kèm</h3>
            <div class="admin-document-file__info">
                <div class="admin-file-item">
                    <svg class="admin-file-item__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="admin-file-item__details">
                        <div class="admin-file-item__name">{{ $document->file_name }}</div>
                        <div class="admin-file-item__size">{{ $document->getFormattedFileSize() }}</div>
                        <div class="admin-file-item__type">{{ strtoupper($document->file_type) }}</div>
                    </div>
                    <a href="{{ route('admin.documents.download', $document) }}" 
                       class="admin-btn admin-btn--sm admin-btn--success">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tải xuống
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="admin-document-info">
            <h3 class="admin-document-info__title">Thông tin tài liệu</h3>
            <div class="admin-document-info__grid">
                @if($document->uploader)
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Người tải lên:</span>
                    <span class="admin-info-item__value">{{ $document->uploader->name }}</span>
                </div>
                @endif
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày tạo:</span>
                    <span class="admin-info-item__value">{{ $document->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($document->approver)
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Người phê duyệt:</span>
                    <span class="admin-info-item__value">{{ $document->approver->name }}</span>
                </div>
                @endif
                @if($document->approved_at)
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày phê duyệt:</span>
                    <span class="admin-info-item__value">{{ $document->approved_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày cập nhật:</span>
                    <span class="admin-info-item__value">{{ $document->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Document Modal -->
<div id="editDocumentModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Chỉnh sửa tài liệu</h3>
            <button type="button" class="admin-modal__close" onclick="hideEditModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form method="POST" id="editDocumentForm" class="admin-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Tiêu đề tài liệu</label>
                    <input type="text" name="title" id="edit_title" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Mô tả</label>
                    <textarea name="description" id="edit_description" rows="3" class="admin-form__input"></textarea>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Loại tài liệu</label>
                    <select name="document_type" id="edit_document_type" required class="admin-form__select">
                        <option value="">-- Chọn loại tài liệu --</option>
                        <option value="policy">Chính sách</option>
                        <option value="procedure">Quy trình</option>
                        <option value="form">Biểu mẫu</option>
                        <option value="manual">Hướng dẫn</option>
                        <option value="report">Báo cáo</option>
                        <option value="other">Khác</option>
                    </select>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Thay thế file (tùy chọn)</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                           class="admin-form__input">
                    <small class="admin-form__help">Để trống nếu không muốn thay đổi file hiện tại. Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Kích thước tối đa: 50MB</small>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Phiên bản</label>
                    <input type="text" name="version" id="edit_version" class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Ngày có hiệu lực</label>
                    <input type="date" name="effective_date" id="edit_effective_date" class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Ngày hết hiệu lực</label>
                    <input type="date" name="expiry_date" id="edit_expiry_date" class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Tags (phân tách bằng dấu phẩy)</label>
                    <input type="text" name="tags" id="edit_tags" class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">
                        <input type="hidden" name="is_public" value="0">
                        <input type="checkbox" name="is_public" id="edit_is_public" value="1">
                        Công khai cho tất cả người dùng
                    </label>
                </div>

                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="hideEditModal()">Hủy</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Approve Document Modal -->
<div id="approveDocumentModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận phê duyệt tài liệu</h3>
            <button type="button" class="admin-modal__close" onclick="hideApproveModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <p>Bạn có chắc chắn muốn phê duyệt tài liệu <strong id="approveDocumentTitle"></strong>?</p>
            <p>Sau khi phê duyệt, tài liệu sẽ chuyển sang trạng thái "Đã phê duyệt".</p>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="hideApproveModal()">Hủy</button>
                <form method="POST" id="approveDocumentForm" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="admin-btn admin-btn--primary" style="background: #28a745;">Phê duyệt</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Revoke Approval Modal -->
<div id="revokeApprovalModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận hủy phê duyệt tài liệu</h3>
            <button type="button" class="admin-modal__close" onclick="hideRevokeModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <p>Bạn có chắc chắn muốn hủy phê duyệt tài liệu <strong id="revokeDocumentTitle"></strong>?</p>
            <p>Sau khi hủy, tài liệu sẽ chuyển về trạng thái "Bản nháp".</p>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="hideRevokeModal()">Hủy</button>
                <form method="POST" id="revokeApprovalForm" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="admin-btn admin-btn--primary" style="background: #ffc107;">Hủy phê duyệt</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Edit modal functions
function showEditModal() {
    document.getElementById('editDocumentModal').style.display = 'flex';
}

function hideEditModal() {
    document.getElementById('editDocumentModal').style.display = 'none';
}

function editDocument(documentId) {
    // Fetch document data via AJAX
    fetch(`/admin/documents/${documentId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const doc = data.document;
                
                // Populate form fields
                document.getElementById('edit_title').value = doc.title;
                document.getElementById('edit_description').value = doc.description || '';
                document.getElementById('edit_document_type').value = doc.document_type;
                document.getElementById('edit_version').value = doc.version;
                document.getElementById('edit_effective_date').value = doc.effective_date || '';
                document.getElementById('edit_expiry_date').value = doc.expiry_date || '';
                document.getElementById('edit_tags').value = doc.tags || '';
                document.getElementById('edit_is_public').checked = doc.is_public;
                
                // Set form action
                document.getElementById('editDocumentForm').action = `/admin/documents/${documentId}`;
                
                // Show modal
                showEditModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi tải thông tin tài liệu');
        });
}

// Approve modal functions
function showApproveModal() {
    document.getElementById('approveDocumentModal').style.display = 'flex';
}

function hideApproveModal() {
    document.getElementById('approveDocumentModal').style.display = 'none';
}

function approveDocument(documentId, documentTitle) {
    // Set document title in modal
    document.getElementById('approveDocumentTitle').textContent = documentTitle;
    
    // Set form action
    document.getElementById('approveDocumentForm').action = `/admin/documents/${documentId}/approve`;
    
    // Show modal
    showApproveModal();
}

// Revoke approval modal functions
function showRevokeModal() {
    document.getElementById('revokeApprovalModal').style.display = 'flex';
}

function hideRevokeModal() {
    document.getElementById('revokeApprovalModal').style.display = 'none';
}

function revokeApproval(documentId, documentTitle) {
    // Set document title in modal
    document.getElementById('revokeDocumentTitle').textContent = documentTitle;
    
    // Set form action
    document.getElementById('revokeApprovalForm').action = `/admin/documents/${documentId}/revoke`;
    
    // Show modal
    showRevokeModal();
}
</script>
@endsection