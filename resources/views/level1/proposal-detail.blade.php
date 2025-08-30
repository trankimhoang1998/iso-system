@extends('layouts.level1')

@section('title', 'Chi tiết đề xuất - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <div>
            <h1 class="level1-page__title">Chi tiết đề xuất</h1>
            <p class="level1-page__subtitle">Xem và xử lý đề xuất sửa đổi từ {{ $proposal->user->name }}</p>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.proposals') }}" class="level1-btn level1-btn--secondary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="level1-alert level1-alert--success">
        <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="level1-alert level1-alert--error">
        <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="level1-proposal-detail">
        <!-- Proposal Header -->
        <div class="level1-proposal-detail__header">
            <div class="level1-proposal-detail__title-section">
                <h2 class="level1-proposal-detail__title">{{ $proposal->title }}</h2>
                <div class="level1-proposal-detail__meta">
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
            <div class="level1-proposal-detail__info">
                <div class="level1-proposal-detail__submitter">
                    <strong>Đơn vị gửi:</strong> {{ $proposal->user->name }}
                </div>
                <div class="level1-proposal-detail__date">
                    <strong>Ngày gửi:</strong> {{ $proposal->created_at->format('d/m/Y H:i') }}
                </div>
                @if($proposal->responded_at)
                <div class="level1-proposal-detail__responded">
                    <strong>Ngày phản hồi:</strong> {{ $proposal->responded_at->format('d/m/Y H:i') }}
                </div>
                @endif
            </div>
        </div>

        <!-- Document Information -->
        <div class="level1-proposal-detail__document">
            <h3 class="level1-proposal-detail__section-title">Tài liệu liên quan</h3>
            <div class="level1-proposal-detail__document-card">
                <div class="level1-proposal-detail__document-info">
                    <svg class="level1-proposal-detail__document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <div class="level1-proposal-detail__document-title">{{ $proposal->document->title }}</div>
                        <div class="level1-proposal-detail__document-meta">
                            <span class="level1-proposal-detail__document-type">{{ $proposal->document->getDocumentTypeName() }}</span>
                            <span class="level1-proposal-detail__document-version">Phiên bản: {{ $proposal->document->version }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('level1.documents.download', $proposal->document) }}" 
                   class="level1-btn level1-btn--sm level1-btn--info" title="Tải xuống tài liệu">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Tải xuống
                </a>
            </div>
        </div>

        <!-- Proposal Content -->
        <div class="level1-proposal-detail__content">
            <h3 class="level1-proposal-detail__section-title">Nội dung đề xuất</h3>
            
            <div class="level1-proposal-detail__field">
                <h4 class="level1-proposal-detail__field-title">Mô tả vấn đề:</h4>
                <div class="level1-proposal-detail__field-content">
                    {{ $proposal->description }}
                </div>
            </div>

            @if($proposal->proposed_content)
            <div class="level1-proposal-detail__field">
                <h4 class="level1-proposal-detail__field-title">Nội dung đề xuất:</h4>
                <div class="level1-proposal-detail__field-content level1-proposal-detail__field-content--proposed">
                    {{ $proposal->proposed_content }}
                </div>
            </div>
            @endif

            @if($proposal->reason)
            <div class="level1-proposal-detail__field">
                <h4 class="level1-proposal-detail__field-title">Lý do sửa đổi:</h4>
                <div class="level1-proposal-detail__field-content">
                    {{ $proposal->reason }}
                </div>
            </div>
            @endif
        </div>

        <!-- Response Section -->
        @if($proposal->response)
        <div class="level1-proposal-detail__response">
            <h3 class="level1-proposal-detail__section-title">Phản hồi của bạn</h3>
            <div class="level1-proposal-detail__response-content">
                <div class="level1-proposal-detail__response-meta">
                    <strong>Người phản hồi:</strong> {{ $proposal->responder->name ?? 'Bạn' }}
                    <span class="level1-proposal-detail__response-date">{{ $proposal->responded_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="level1-proposal-detail__response-text">
                    {{ $proposal->response }}
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="level1-proposal-detail__actions">
            @if($proposal->status === 'approved' || $proposal->status === 'implemented')
            <a href="{{ route('level1.documents.edit', $proposal->document) }}" 
               class="level1-btn level1-btn--primary" title="Sửa đổi tài liệu theo đề xuất">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Sửa đổi tài liệu
            </a>
            @endif

            @if($proposal->status === 'pending')
            <button type="button" class="level1-btn level1-btn--success" 
                    onclick="showResponseModal({{ $proposal->id }}, 'approved', '{{ $proposal->title }}')" title="Chấp nhận đề xuất">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Chấp nhận
            </button>
            
            <button type="button" class="level1-btn level1-btn--danger" 
                    onclick="showResponseModal({{ $proposal->id }}, 'rejected', '{{ $proposal->title }}')" title="Từ chối đề xuất">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Từ chối
            </button>
            @elseif($proposal->status === 'approved')
            <button type="button" class="level1-btn level1-btn--warning" 
                    onclick="showResponseModal({{ $proposal->id }}, 'implemented', '{{ $proposal->title }}')" title="Đánh dấu đã thực hiện">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Đánh dấu đã thực hiện
            </button>
            @endif
        </div>
    </div>
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
</script>
@endsection