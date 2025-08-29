@extends('layouts.admin')

@section('title', 'Quản lý tài liệu - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div>
            <h1 class="admin-page__title">Quản lý tài liệu</h1>
            <p class="admin-page__subtitle">Tải lên và quản lý các tài liệu của hệ thống</p>
        </div>
        <div class="admin-page__actions">
            <button type="button" class="admin-btn admin-btn--primary" onclick="showUploadModal()">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Tải lên tài liệu
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="admin-filter">
        <form method="GET" action="{{ route('admin.documents') }}" class="admin-filter__form">
            <div class="admin-filter__row">
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="admin-filter__input">
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Loại tài liệu</label>
                    <select name="document_type" class="admin-filter__select">
                        <option value="">Tất cả</option>
                        <option value="policy" {{ request('document_type') == 'policy' ? 'selected' : '' }}>Chính sách</option>
                        <option value="procedure" {{ request('document_type') == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                        <option value="form" {{ request('document_type') == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                        <option value="manual" {{ request('document_type') == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                        <option value="report" {{ request('document_type') == 'report' ? 'selected' : '' }}>Báo cáo</option>
                        <option value="other" {{ request('document_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Trạng thái</label>
                    <select name="status" class="admin-filter__select">
                        <option value="">Tất cả</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã phê duyệt</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                    </select>
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Người tải lên</label>
                    <input type="text" name="uploader" value="{{ request('uploader') }}" 
                           placeholder="Tên người tải lên..." class="admin-filter__input">
                </div>
                <div class="admin-filter__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('admin.documents') }}" class="admin-btn admin-btn--secondary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th class="admin-table__header">ID</th>
                    <th class="admin-table__header">Tiêu đề</th>
                    <th class="admin-table__header">Loại tài liệu</th>
                    <th class="admin-table__header">Phiên bản</th>
                    <th class="admin-table__header">Trạng thái</th>
                    <th class="admin-table__header">Kích thước</th>
                    <th class="admin-table__header">Người tải lên</th>
                    <th class="admin-table__header">Ngày tải lên</th>
                    <th class="admin-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="admin-table__body">
                @foreach($documents as $document)
                <tr class="admin-table__row">
                    <td class="admin-table__cell">{{ $document->id }}</td>
                    <td class="admin-table__cell">
                        <div class="admin-document-info">
                            <div class="admin-document-info__title">{{ $document->title }}</div>
                            @if($document->description)
                            <div class="admin-document-info__description">{{ Str::limit($document->description, 50) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="admin-table__cell">
                        <span class="admin-document-type-badge admin-document-type-badge--{{ $document->document_type }}">
                            {{ $document->getDocumentTypeName() }}
                        </span>
                    </td>
                    <td class="admin-table__cell">{{ $document->version }}</td>
                    <td class="admin-table__cell">
                        <span class="admin-status-badge 
                            @if($document->status == 'approved') admin-status-badge--active 
                            @elseif($document->status == 'draft') admin-status-badge--warning
                            @else admin-status-badge--inactive @endif">
                            {{ $document->getStatusName() }}
                        </span>
                    </td>
                    <td class="admin-table__cell">{{ $document->getFormattedFileSize() }}</td>
                    <td class="admin-table__cell">{{ $document->uploader->name }}</td>
                    <td class="admin-table__cell">{{ $document->created_at->format('d/m/Y') }}</td>
                    <td class="admin-table__cell">
                        <div class="admin-table__actions">
                            <a href="{{ route('admin.documents.download', $document) }}" 
                               class="admin-table__action-btn admin-table__action-btn--download" 
                               title="Tải xuống">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                            <button class="admin-table__action-btn admin-table__action-btn--edit" 
                                    title="Chỉnh sửa"
                                    onclick="editDocument({{ $document->id }})">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            @if($document->status == 'draft')
                            <button class="admin-table__action-btn admin-table__action-btn--approve" 
                                    title="Phê duyệt"
                                    onclick="approveDocument({{ $document->id }}, '{{ $document->title }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            @elseif($document->status == 'approved')
                            <button class="admin-table__action-btn admin-table__action-btn--revoke" 
                                    title="Hủy phê duyệt"
                                    onclick="revokeApproval({{ $document->id }}, '{{ $document->title }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            @endif
                            <button class="admin-table__action-btn admin-table__action-btn--delete" 
                                    title="Xóa"
                                    onclick="deleteDocument({{ $document->id }}, '{{ $document->title }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($documents->hasPages())
        {{ $documents->links('components.pagination') }}
    @endif
</div>

<!-- Upload Document Modal -->
<div id="uploadDocumentModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Tải lên tài liệu mới</h3>
            <button type="button" class="admin-modal__close" onclick="hideUploadModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form method="POST" action="{{ route('admin.documents.store') }}" class="admin-form" enctype="multipart/form-data">
                @csrf
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Tiêu đề tài liệu</label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           class="admin-form__input @error('title') admin-form__input--error @enderror">
                    @error('title')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Mô tả</label>
                    <textarea name="description" rows="3" 
                              class="admin-form__input @error('description') admin-form__input--error @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Loại tài liệu</label>
                    <select name="document_type" required 
                            class="admin-form__select @error('document_type') admin-form__select--error @enderror">
                        <option value="">-- Chọn loại tài liệu --</option>
                        <option value="policy" {{ old('document_type') == 'policy' ? 'selected' : '' }}>Chính sách</option>
                        <option value="procedure" {{ old('document_type') == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                        <option value="form" {{ old('document_type') == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                        <option value="manual" {{ old('document_type') == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                        <option value="report" {{ old('document_type') == 'report' ? 'selected' : '' }}>Báo cáo</option>
                        <option value="other" {{ old('document_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('document_type')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">File tài liệu</label>
                    <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"
                           class="admin-form__input @error('file') admin-form__input--error @enderror">
                    <small class="admin-form__help">Định dạng hỗ trợ: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT. Kích thước tối đa: 50MB</small>
                    @error('file')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Phiên bản</label>
                    <input type="text" name="version" value="{{ old('version', '1.0') }}" 
                           class="admin-form__input @error('version') admin-form__input--error @enderror">
                    @error('version')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Ngày có hiệu lực</label>
                    <input type="date" name="effective_date" value="{{ old('effective_date') }}" 
                           class="admin-form__input @error('effective_date') admin-form__input--error @enderror">
                    @error('effective_date')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Ngày hết hiệu lực</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" 
                           class="admin-form__input @error('expiry_date') admin-form__input--error @enderror">
                    @error('expiry_date')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Tags (phân tách bằng dấu phẩy)</label>
                    <input type="text" name="tags" value="{{ old('tags') }}" 
                           placeholder="ISO, quy trình, chính sách"
                           class="admin-form__input @error('tags') admin-form__input--error @enderror">
                    @error('tags')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        Công khai cho tất cả người dùng
                    </label>
                </div>

                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="hideUploadModal()">Hủy</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Tải lên</button>
                </div>
            </form>
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

<!-- Delete Document Modal -->
<div id="deleteDocumentModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận xóa tài liệu</h3>
            <button type="button" class="admin-modal__close" onclick="hideDeleteModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <p>Bạn có chắc chắn muốn xóa tài liệu <strong id="deleteDocumentTitle"></strong>?</p>
            <p>Hành động này không thể hoàn tác.</p>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="hideDeleteModal()">Hủy</button>
                <form method="POST" id="deleteDocumentForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--secondary" style="background: #dc3545;">Xóa</button>
                </form>
            </div>
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
// Upload modal functions
function showUploadModal() {
    document.getElementById('uploadDocumentModal').style.display = 'flex';
}

function hideUploadModal() {
    document.getElementById('uploadDocumentModal').style.display = 'none';
}

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
            toastr.error('Có lỗi xảy ra khi tải thông tin tài liệu');
        });
}

// Delete modal functions
function showDeleteModal() {
    document.getElementById('deleteDocumentModal').style.display = 'flex';
}

function hideDeleteModal() {
    document.getElementById('deleteDocumentModal').style.display = 'none';
}

function deleteDocument(documentId, documentTitle) {
    // Set document title in modal
    document.getElementById('deleteDocumentTitle').textContent = documentTitle;
    
    // Set form action
    document.getElementById('deleteDocumentForm').action = `/admin/documents/${documentId}`;
    
    // Show modal
    showDeleteModal();
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

// Show modal if there are validation errors
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    showUploadModal();
});
@endif
</script>
@endsection