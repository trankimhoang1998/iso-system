@extends('layouts.level2')

@section('title', 'Đề xuất sửa đổi - Cơ quan - Phân xưởng')

@section('content')
<div class="level2-page">
    <div class="level2-page__header">
        <div>
            <h1 class="level2-page__title">Đề xuất sửa đổi</h1>
            <p class="level2-page__subtitle">Quản lý các đề xuất sửa đổi tài liệu gửi lên Ban ISO</p>
        </div>
        <div class="level2-page__actions">
            <button type="button" class="level2-btn level2-btn--primary" onclick="showCreateProposalModal()">
                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tạo đề xuất mới
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level2-filter">
        <form method="GET" action="{{ route('level2.proposals') }}" class="level2-filter__form">
            <div class="level2-filter__row">
                <div class="level2-filter__group">
                    <label class="level2-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề đề xuất..." class="level2-filter__input">
                </div>
                <div class="level2-filter__group">
                    <label class="level2-filter__label">Trạng thái</label>
                    <select name="status" class="level2-filter__select">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Chấp nhận</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                        <option value="implemented" {{ request('status') == 'implemented' ? 'selected' : '' }}>Đã thực hiện</option>
                    </select>
                </div>
                <div class="level2-filter__group">
                    <label class="level2-filter__label">Loại đề xuất</label>
                    <select name="proposal_type" class="level2-filter__select">
                        <option value="">Tất cả</option>
                        <option value="content_correction" {{ request('proposal_type') == 'content_correction' ? 'selected' : '' }}>Sửa nội dung</option>
                        <option value="format_improvement" {{ request('proposal_type') == 'format_improvement' ? 'selected' : '' }}>Cải thiện định dạng</option>
                        <option value="additional_info" {{ request('proposal_type') == 'additional_info' ? 'selected' : '' }}>Bổ sung thông tin</option>
                        <option value="process_optimization" {{ request('proposal_type') == 'process_optimization' ? 'selected' : '' }}>Tối ưu quy trình</option>
                        <option value="other" {{ request('proposal_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level2-filter__actions">
                    <button type="submit" class="level2-btn level2-btn--primary">
                        <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level2.proposals') }}" class="level2-btn level2-btn--secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    @if(isset($proposals) && $proposals->count() > 0)
    <div class="level2-proposals">
        @foreach($proposals as $proposal)
        <div class="level2-proposal-card">
            <div class="level2-proposal-card__header">
                <div class="level2-proposal-card__title">
                    <h3>{{ $proposal->title }}</h3>
                    <div class="level2-proposal-card__meta">
                        <span class="level2-badge level2-badge--{{ $proposal->proposal_type }}">
                            {{ $proposal->getProposalTypeName() }}
                        </span>
                        <span class="level2-badge level2-badge--priority-{{ $proposal->priority }}">
                            {{ $proposal->getPriorityName() }}
                        </span>
                        @if($proposal->status === 'pending')
                        <span class="level2-status level2-status--pending">{{ $proposal->getStatusName() }}</span>
                        @elseif($proposal->status === 'approved')
                        <span class="level2-status level2-status--approved">{{ $proposal->getStatusName() }}</span>
                        @elseif($proposal->status === 'rejected')
                        <span class="level2-status level2-status--rejected">{{ $proposal->getStatusName() }}</span>
                        @else
                        <span class="level2-status level2-status--implemented">{{ $proposal->getStatusName() }}</span>
                        @endif
                    </div>
                </div>
                <div class="level2-proposal-card__date">
                    {{ $proposal->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="level2-proposal-card__document">
                <div class="level2-proposal-card__document-info">
                    <svg class="level2-proposal-card__document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <div class="level2-proposal-card__document-title">{{ $proposal->document->title }}</div>
                        <div class="level2-proposal-card__document-type">{{ $proposal->document->getDocumentTypeName() }}</div>
                    </div>
                </div>
            </div>

            <div class="level2-proposal-card__content">
                <div class="level2-proposal-card__description">
                    {{ Str::limit($proposal->description, 150) }}
                </div>
                
                @if($proposal->proposed_content)
                <div class="level2-proposal-card__proposed">
                    <strong>Nội dung đề xuất:</strong>
                    <div class="level2-proposal-card__proposed-text">{{ Str::limit($proposal->proposed_content, 100) }}</div>
                </div>
                @endif
            </div>

            @if($proposal->response)
            <div class="level2-proposal-card__response">
                <div class="level2-proposal-card__response-header">
                    <strong>Phản hồi từ Ban ISO:</strong>
                    <span class="level2-text--muted">{{ $proposal->responded_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="level2-proposal-card__response-content">
                    {{ $proposal->response }}
                </div>
            </div>
            @endif

            <div class="level2-proposal-card__actions">
                <button type="button" class="level2-btn level2-btn--sm level2-btn--info" 
                        onclick="showProposalDetail({{ $proposal->id }})" title="Xem chi tiết">
                    <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Chi tiết
                </button>
                
                @if($proposal->status === 'pending')
                <button type="button" class="level2-btn level2-btn--sm level2-btn--warning" 
                        onclick="showEditProposalModal({{ $proposal->id }})" title="Chỉnh sửa">
                    <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Chỉnh sửa
                </button>
                
                <button type="button" class="level2-btn level2-btn--sm level2-btn--danger" 
                        onclick="showDeleteProposalModal({{ $proposal->id }}, '{{ $proposal->title }}')" title="Xóa">
                    <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Xóa
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="level2-pagination-wrapper">
        {{ $proposals->links('components.level2-pagination') }}
    </div>
    @else
    <div class="level2-proposals__empty">
        <div class="level2-empty-state">
            <svg class="level2-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
            <h3 class="level2-empty-state__title">Chưa có đề xuất nào</h3>
            <p class="level2-empty-state__description">Bắt đầu bằng cách tạo đề xuất sửa đổi đầu tiên</p>
            <button class="level2-empty-state__btn" onclick="showCreateProposalModal()">
                Tạo đề xuất mới
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Create Proposal Modal -->
<div id="createProposalModal" class="level2-modal" style="display: none;">
    <div class="level2-modal__backdrop" onclick="hideCreateProposalModal()"></div>
    <div class="level2-modal__content">
        <div class="level2-modal__header">
            <h2 class="level2-modal__title">Tạo đề xuất sửa đổi mới</h2>
            <button type="button" class="level2-modal__close" onclick="hideCreateProposalModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="createProposalForm" method="POST" action="{{ route('level2.proposals.store') }}" class="level2-form">
            @csrf
            <div class="level2-modal__body">
                <div class="level2-form__row">
                    <div class="level2-form__group level2-form__group--full">
                        <label class="level2-form__label level2-form__label--required">Chọn tài liệu</label>
                        <select name="document_id" required class="level2-form__select">
                            <option value="">Chọn tài liệu muốn đề xuất sửa đổi</option>
                            @if(isset($availableDocuments))
                            @foreach($availableDocuments as $document)
                            <option value="{{ $document->id }}">{{ $document->title }} ({{ $document->getDocumentTypeName() }})</option>
                            @endforeach
                            @endif
                        </select>
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
                <button type="button" class="level2-btn level2-btn--secondary" onclick="hideCreateProposalModal()">Hủy</button>
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
function showCreateProposalModal() {
    document.getElementById('createProposalModal').style.display = 'flex';
}

function hideCreateProposalModal() {
    document.getElementById('createProposalModal').style.display = 'none';
    document.getElementById('createProposalForm').reset();
}

function showProposalDetail(proposalId) {
    // Implement proposal detail view
    window.location.href = `/level2/proposals/${proposalId}`;
}

function showEditProposalModal(proposalId) {
    // Implement edit functionality
    window.location.href = `/level2/proposals/${proposalId}/edit`;
}

function showDeleteProposalModal(proposalId, proposalTitle) {
    if (confirm(`Bạn có chắc chắn muốn xóa đề xuất "${proposalTitle}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/level2/proposals/${proposalId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection