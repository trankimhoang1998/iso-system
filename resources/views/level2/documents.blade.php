@extends('layouts.level2')

@section('title', 'Tài liệu được chia sẻ - Cơ quan - Phân xưởng')

@section('content')
<div class="level2-page">
    <div class="level2-page__header">
        <div>
            <h1 class="level2-page__title">Tài liệu được chia sẻ</h1>
            <p class="level2-page__subtitle">Các tài liệu mà Ban ISO cho phép đơn vị truy cập</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level2-filter">
        <form method="GET" action="{{ route('level2.documents') }}" class="level2-filter__form">
            <div class="level2-filter__row">
                <div class="level2-filter__group">
                    <label class="level2-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="level2-filter__input">
                </div>
                <div class="level2-filter__group">
                    <label class="level2-filter__label">Loại tài liệu</label>
                    <select name="document_type" class="level2-filter__select">
                        <option value="">Tất cả</option>
                        <option value="policy" {{ request('document_type') == 'policy' ? 'selected' : '' }}>Chính sách</option>
                        <option value="procedure" {{ request('document_type') == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                        <option value="form" {{ request('document_type') == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                        <option value="manual" {{ request('document_type') == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                        <option value="report" {{ request('document_type') == 'report' ? 'selected' : '' }}>Báo cáo</option>
                        <option value="other" {{ request('document_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level2-filter__actions">
                    <button type="submit" class="level2-btn level2-btn--primary">
                        <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level2.documents') }}" class="level2-btn level2-btn--secondary">
                        <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if(isset($documents) && $documents->count() > 0)
    <div class="level2-table-container">
        <table class="level2-table">
            <thead class="level2-table__head">
                <tr>
                    <th class="level2-table__header">Tiêu đề</th>
                    <th class="level2-table__header">Loại tài liệu</th>
                    <th class="level2-table__header">Phiên bản</th>
                    <th class="level2-table__header">Kích thước</th>
                    <th class="level2-table__header">Quyền của bạn</th>
                    <th class="level2-table__header">Ngày chia sẻ</th>
                    <th class="level2-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="level2-table__body">
                @foreach($documents as $document)
                <tr class="level2-table__row">
                    <td class="level2-table__cell">
                        <div class="level2-document-info">
                            <div class="level2-document-info__title">{{ $document->title }}</div>
                            @if($document->description)
                            <div class="level2-document-info__description">{{ Str::limit($document->description, 50) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="level2-table__cell">
                        <span class="level2-badge level2-badge--{{ $document->document_type }}">
                            {{ $document->getDocumentTypeName() }}
                        </span>
                    </td>
                    <td class="level2-table__cell">{{ $document->version }}</td>
                    <td class="level2-table__cell">{{ $document->getFormattedFileSize() }}</td>
                    <td class="level2-table__cell">
                        <div class="level2-permissions">
                            @if($document->pivot->can_view)
                            <span class="level2-badge level2-badge--success level2-badge--sm">Xem</span>
                            @endif
                            @if($document->pivot->can_download)
                            <span class="level2-badge level2-badge--info level2-badge--sm">Tải xuống</span>
                            @endif
                        </div>
                    </td>
                    <td class="level2-table__cell">{{ $document->pivot->created_at->format('d/m/Y H:i') }}</td>
                    <td class="level2-table__cell">
                        <div class="level2-table__actions">
                            @if($document->pivot->can_view)
                            <button type="button" class="level2-btn level2-btn--sm level2-btn--info" 
                                    onclick="showDocumentModal({{ $document->id }}, '{{ $document->title }}')" 
                                    title="Xem tài liệu">
                                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            @endif
                            
                            @if($document->pivot->can_download)
                            <a href="{{ route('level2.documents.download', $document) }}" 
                               class="level2-btn level2-btn--sm level2-btn--success" 
                               title="Tải xuống">
                                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                            @endif
                            
                            <button type="button" class="level2-btn level2-btn--sm level2-btn--warning" 
                                    onclick="showProposalModal({{ $document->id }}, '{{ $document->title }}')" 
                                    title="Đề xuất sửa đổi">
                                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="level2-pagination-wrapper">
        {{ $documents->links('components.level2-pagination') }}
    </div>
    @else
    <div class="level2-documents__empty">
        <div class="level2-empty-state">
            <svg class="level2-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="level2-empty-state__title">Chưa có tài liệu nào được chia sẻ</h3>
            <p class="level2-empty-state__description">Ban ISO chưa chia sẻ tài liệu nào cho đơn vị của bạn</p>
        </div>
    </div>
    @endif
</div>

<!-- Document View Modal -->
<div id="documentModal" class="level2-modal" style="display: none;">
    <div class="level2-modal__backdrop" onclick="hideDocumentModal()"></div>
    <div class="level2-modal__content level2-modal__content--large">
        <div class="level2-modal__header">
            <h2 class="level2-modal__title" id="documentTitle">Xem tài liệu</h2>
            <button type="button" class="level2-modal__close" onclick="hideDocumentModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="level2-modal__body">
            <div id="documentContent" class="level2-document-viewer">
                <p>Đang tải...</p>
            </div>
        </div>
    </div>
</div>

<!-- Proposal Modal -->
<div id="proposalModal" class="level2-modal" style="display: none;">
    <div class="level2-modal__backdrop" onclick="hideProposalModal()"></div>
    <div class="level2-modal__content">
        <div class="level2-modal__header">
            <h2 class="level2-modal__title">Đề xuất sửa đổi tài liệu</h2>
            <button type="button" class="level2-modal__close" onclick="hideProposalModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="proposalForm" method="POST" action="{{ route('level2.proposals.store') }}" class="level2-form">
            @csrf
            <input type="hidden" name="document_id" id="proposalDocumentId">
            <div class="level2-modal__body">
                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <div class="level2-alert level2-alert--info">
                            <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <strong>Tài liệu:</strong> <span id="proposalDocumentTitle"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <label class="level2-form__label level2-form__label--required">Tiêu đề đề xuất</label>
                        <input type="text" name="title" required class="level2-form__input" 
                               placeholder="Nhập tiêu đề cho đề xuất của bạn">
                    </div>
                </div>

                <div class="level2-form__row">
                    <div class="level2-form__group">
                        <label class="level2-form__label level2-form__label--required">Loại đề xuất</label>
                        <select name="proposal_type" required class="level2-form__select">
                            <option value="">Chọn loại đề xuất</option>
                            <option value="content_correction">Sửa nội dung</option>
                            <option value="format_improvement">Cải thiện định dạng</option>
                            <option value="additional_info">Bổ sung thông tin</option>
                            <option value="process_optimization">Tối ưu quy trình</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="level2-form__group">
                        <label class="level2-form__label level2-form__label--required">Mức độ ưu tiên</label>
                        <select name="priority" required class="level2-form__select">
                            <option value="">Chọn mức độ</option>
                            <option value="low">Thấp</option>
                            <option value="medium">Trung bình</option>
                            <option value="high">Cao</option>
                            <option value="urgent">Khẩn cấp</option>
                        </select>
                    </div>
                </div>

                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <label class="level2-form__label level2-form__label--required">Mô tả chi tiết</label>
                        <textarea name="description" rows="4" required class="level2-form__textarea" 
                                  placeholder="Mô tả chi tiết về đề xuất sửa đổi của bạn..."></textarea>
                    </div>
                </div>

                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <label class="level2-form__label">Nội dung đề xuất (nếu có)</label>
                        <textarea name="proposed_content" rows="3" class="level2-form__textarea" 
                                  placeholder="Nội dung cụ thể bạn đề xuất thay đổi..."></textarea>
                    </div>
                </div>

                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <label class="level2-form__label">Lý do sửa đổi</label>
                        <textarea name="reason" rows="2" class="level2-form__textarea" 
                                  placeholder="Lý do tại sao cần sửa đổi..."></textarea>
                    </div>
                </div>
            </div>
            <div class="level2-modal__footer">
                <button type="button" class="level2-btn level2-btn--secondary" onclick="hideProposalModal()">Hủy</button>
                <button type="submit" class="level2-btn level2-btn--primary">
                    <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Gửi đề xuất
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showDocumentModal(documentId, documentTitle) {
    document.getElementById('documentTitle').textContent = documentTitle;
    document.getElementById('documentContent').innerHTML = '<p>Đang tải...</p>';
    document.getElementById('documentModal').style.display = 'flex';
    
    // Load document content via AJAX
    fetch(`/level2/documents/${documentId}/view`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('documentContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('documentContent').innerHTML = '<p class="level2-error">Không thể tải nội dung tài liệu.</p>';
        });
}

function hideDocumentModal() {
    document.getElementById('documentModal').style.display = 'none';
}

function showProposalModal(documentId, documentTitle) {
    document.getElementById('proposalDocumentId').value = documentId;
    document.getElementById('proposalDocumentTitle').textContent = documentTitle;
    document.getElementById('proposalModal').style.display = 'flex';
}

function hideProposalModal() {
    document.getElementById('proposalModal').style.display = 'none';
    document.getElementById('proposalForm').reset();
}
</script>
@endsection