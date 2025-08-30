@extends('layouts.level1')

@section('title', 'Quản lý đề xuất sửa đổi - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <div>
            <h1 class="level1-page__title">Đề xuất sửa đổi</h1>
            <p class="level1-page__subtitle">Xem và xử lý các đề xuất sửa đổi từ các đơn vị cấp 2</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level1-filter">
        <form method="GET" action="{{ route('level1.proposals') }}" class="level1-filter__form">
            <div class="level1-filter__row">
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề đề xuất..." class="level1-filter__input">
                </div>
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Trạng thái</label>
                    <select name="status" class="level1-filter__select">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Chấp nhận</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                        <option value="implemented" {{ request('status') == 'implemented' ? 'selected' : '' }}>Đã thực hiện</option>
                    </select>
                </div>
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Loại đề xuất</label>
                    <select name="proposal_type" class="level1-filter__select">
                        <option value="">Tất cả</option>
                        <option value="content_correction" {{ request('proposal_type') == 'content_correction' ? 'selected' : '' }}>Sửa nội dung</option>
                        <option value="format_improvement" {{ request('proposal_type') == 'format_improvement' ? 'selected' : '' }}>Cải thiện định dạng</option>
                        <option value="additional_info" {{ request('proposal_type') == 'additional_info' ? 'selected' : '' }}>Bổ sung thông tin</option>
                        <option value="process_optimization" {{ request('proposal_type') == 'process_optimization' ? 'selected' : '' }}>Tối ưu quy trình</option>
                        <option value="other" {{ request('proposal_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level1-filter__actions">
                    <button type="submit" class="level1-btn level1-btn--primary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level1.proposals') }}" class="level1-btn level1-btn--secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    @if(isset($proposals) && $proposals->count() > 0)
    <div class="level1-proposals">
        @foreach($proposals as $proposal)
        <div class="level1-proposal-card">
            <div class="level1-proposal-card__header">
                <div class="level1-proposal-card__title">
                    <h3>{{ $proposal->title }}</h3>
                    <div class="level1-proposal-card__meta">
                        <span class="level1-badge level1-badge--{{ $proposal->proposal_type }}">
                            {{ $proposal->getProposalTypeName() }}
                        </span>
                        <span class="level1-badge level1-badge--priority-{{ $proposal->priority }}">
                            {{ $proposal->getPriorityName() }}
                        </span>
                        @if($proposal->status === 'pending')
                        <span class="level1-status level1-status--pending">{{ $proposal->getStatusName() }}</span>
                        @elseif($proposal->status === 'approved')
                        <span class="level1-status level1-status--approved">{{ $proposal->getStatusName() }}</span>
                        @elseif($proposal->status === 'rejected')
                        <span class="level1-status level1-status--rejected">{{ $proposal->getStatusName() }}</span>
                        @else
                        <span class="level1-status level1-status--implemented">{{ $proposal->getStatusName() }}</span>
                        @endif
                    </div>
                </div>
                <div class="level1-proposal-card__date">
                    <div class="level1-proposal-card__submitted">
                        <strong>Đơn vị:</strong> {{ $proposal->user->name }}
                    </div>
                    <div class="level1-proposal-card__time">
                        {{ $proposal->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="level1-proposal-card__document">
                <div class="level1-proposal-card__document-info">
                    <svg class="level1-proposal-card__document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <div class="level1-proposal-card__document-title">{{ $proposal->document->title }}</div>
                        <div class="level1-proposal-card__document-type">{{ $proposal->document->getDocumentTypeName() }}</div>
                    </div>
                </div>
                <a href="{{ route('level1.documents.download', $proposal->document) }}" 
                   class="level1-btn level1-btn--sm level1-btn--secondary" title="Tải xuống tài liệu">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Tải xuống
                </a>
            </div>

            <div class="level1-proposal-card__content">
                <div class="level1-proposal-card__description">
                    <strong>Mô tả vấn đề:</strong>
                    <p>{{ $proposal->description }}</p>
                </div>
                
                @if($proposal->proposed_content)
                <div class="level1-proposal-card__proposed">
                    <strong>Nội dung đề xuất:</strong>
                    <div class="level1-proposal-card__proposed-text">{{ $proposal->proposed_content }}</div>
                </div>
                @endif

                @if($proposal->reason)
                <div class="level1-proposal-card__reason">
                    <strong>Lý do sửa đổi:</strong>
                    <p>{{ $proposal->reason }}</p>
                </div>
                @endif
            </div>

            @if($proposal->response)
            <div class="level1-proposal-card__response">
                <div class="level1-proposal-card__response-header">
                    <strong>Phản hồi của bạn:</strong>
                    <span class="level1-text--muted">{{ $proposal->responded_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="level1-proposal-card__response-content">
                    {{ $proposal->response }}
                </div>
            </div>
            @endif

            <div class="level1-proposal-card__actions">
                <button type="button" class="level1-btn level1-btn--sm level1-btn--info" 
                        onclick="showProposalDetail({{ $proposal->id }})" title="Xem chi tiết">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Chi tiết
                </button>

                @if($proposal->status === 'approved' || $proposal->status === 'implemented')
                <a href="{{ route('level1.documents.edit', $proposal->document) }}" 
                   class="level1-btn level1-btn--sm level1-btn--primary" title="Sửa đổi tài liệu">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Sửa đổi
                </a>
                @endif
                
                @if($proposal->status === 'pending')
                <button type="button" class="level1-btn level1-btn--sm level1-btn--success" 
                        onclick="showResponseModal({{ $proposal->id }}, 'approved', '{{ $proposal->title }}')" title="Chấp nhận">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Chấp nhận
                </button>
                
                <button type="button" class="level1-btn level1-btn--sm level1-btn--danger" 
                        onclick="showResponseModal({{ $proposal->id }}, 'rejected', '{{ $proposal->title }}')" title="Từ chối">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Từ chối
                </button>
                @elseif($proposal->status === 'approved')
                <button type="button" class="level1-btn level1-btn--sm level1-btn--warning" 
                        onclick="showResponseModal({{ $proposal->id }}, 'implemented', '{{ $proposal->title }}')" title="Đánh dấu đã thực hiện">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Đã thực hiện
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="level1-pagination-wrapper">
        {{ $proposals->links('components.level1-pagination') }}
    </div>
    @else
    <div class="level1-proposals__empty">
        <div class="level1-empty-state">
            <svg class="level1-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
            <h3 class="level1-empty-state__title">Chưa có đề xuất nào</h3>
            <p class="level1-empty-state__description">Các đơn vị cấp 2 chưa gửi đề xuất sửa đổi nào</p>
        </div>
    </div>
    @endif
</div>

<!-- Response Modal -->
<div id="responseModal" class="level1-modal" style="display: none;">
    <div class="level1-modal__backdrop" onclick="hideResponseModal()"></div>
    <div class="level1-modal__content">
        <div class="level1-modal__header">
            <h2 class="level1-modal__title" id="responseModalTitle">Phản hồi đề xuất</h2>
            <button type="button" class="level1-modal__close" onclick="hideResponseModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="responseForm" method="POST" class="level1-form">
            @csrf
            @method('PATCH')
            <div class="level1-modal__body">
                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <div class="level1-alert level1-alert--info">
                            <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <strong>Đề xuất:</strong> <span id="responseProposalTitle"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label level1-form__label--required">Phản hồi</label>
                        <textarea name="response" rows="4" required class="level1-form__textarea" 
                                  placeholder="Nhập phản hồi của bạn về đề xuất này..."></textarea>
                    </div>
                </div>

                <input type="hidden" name="status" id="responseStatus">
            </div>
            <div class="level1-modal__footer">
                <button type="button" class="level1-btn level1-btn--secondary" onclick="hideResponseModal()">Hủy</button>
                <button type="submit" class="level1-btn level1-btn--primary" id="responseSubmitBtn">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Gửi phản hồi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showResponseModal(proposalId, status, proposalTitle) {
    const statusLabels = {
        'approved': 'Chấp nhận đề xuất',
        'rejected': 'Từ chối đề xuất', 
        'implemented': 'Đánh dấu đã thực hiện'
    };
    
    const buttonLabels = {
        'approved': 'Chấp nhận',
        'rejected': 'Từ chối',
        'implemented': 'Đã thực hiện'
    };

    document.getElementById('responseModalTitle').textContent = statusLabels[status];
    document.getElementById('responseProposalTitle').textContent = proposalTitle;
    document.getElementById('responseStatus').value = status;
    document.getElementById('responseSubmitBtn').textContent = buttonLabels[status];
    document.getElementById('responseForm').action = `/level1/proposals/${proposalId}`;
    document.getElementById('responseModal').style.display = 'flex';
}

function hideResponseModal() {
    document.getElementById('responseModal').style.display = 'none';
    document.getElementById('responseForm').reset();
}

function showProposalDetail(proposalId) {
    window.location.href = `/level1/proposals/${proposalId}`;
}
</script>
@endsection