@extends('layouts.level2')

@section('title', 'Chi tiết đề xuất - Cơ quan/Phân xưởng')

@section('content')
<div class="level2-page">
    <div class="level2-page__header">
        <div>
            <h1 class="level2-page__title">Chi tiết đề xuất</h1>
            <p class="level2-page__subtitle">Xem chi tiết đề xuất sửa đổi của bạn</p>
        </div>
        <div class="level2-page__actions">
            <a href="{{ route('level2.proposals') }}" class="level2-btn level2-btn--secondary">
                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="level2-alert level2-alert--success">
        <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="level2-alert level2-alert--error">
        <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="level2-proposal-detail">
        <!-- Proposal Header -->
        <div class="level2-proposal-detail__header">
            <div class="level2-proposal-detail__title-section">
                <h2 class="level2-proposal-detail__title">{{ $proposal->title }}</h2>
                <div class="level2-proposal-detail__meta">
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
            <div class="level2-proposal-detail__info">
                <div class="level2-proposal-detail__submitter">
                    <strong>Gửi bởi:</strong> Bạn
                </div>
                <div class="level2-proposal-detail__date">
                    <strong>Ngày gửi:</strong> {{ $proposal->created_at->format('d/m/Y H:i') }}
                </div>
                @if($proposal->responded_at)
                <div class="level2-proposal-detail__responded">
                    <strong>Ngày phản hồi:</strong> {{ $proposal->responded_at->format('d/m/Y H:i') }}
                </div>
                @endif
            </div>
        </div>

        <!-- Document Information -->
        <div class="level2-proposal-detail__document">
            <h3 class="level2-proposal-detail__section-title">Tài liệu liên quan</h3>
            <div class="level2-proposal-detail__document-card">
                <div class="level2-proposal-detail__document-info">
                    <svg class="level2-proposal-detail__document-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <div class="level2-proposal-detail__document-title">{{ $proposal->document->title }}</div>
                        <div class="level2-proposal-detail__document-meta">
                            <span class="level2-proposal-detail__document-type">{{ $proposal->document->getDocumentTypeName() }}</span>
                            <span class="level2-proposal-detail__document-version">Phiên bản: {{ $proposal->document->version }}</span>
                        </div>
                    </div>
                </div>
                @if($proposal->document->canUserDownload(auth()->user()))
                <a href="{{ route('level2.documents.download', $proposal->document) }}" 
                   class="level2-btn level2-btn--sm level2-btn--info" title="Tải xuống tài liệu">
                    <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Tải xuống
                </a>
                @endif
            </div>
        </div>

        <!-- Proposal Content -->
        <div class="level2-proposal-detail__content">
            <h3 class="level2-proposal-detail__section-title">Nội dung đề xuất</h3>
            
            <div class="level2-proposal-detail__field">
                <h4 class="level2-proposal-detail__field-title">Mô tả vấn đề:</h4>
                <div class="level2-proposal-detail__field-content">
                    {{ $proposal->description }}
                </div>
            </div>

            @if($proposal->proposed_content)
            <div class="level2-proposal-detail__field">
                <h4 class="level2-proposal-detail__field-title">Nội dung đề xuất:</h4>
                <div class="level2-proposal-detail__field-content level2-proposal-detail__field-content--proposed">
                    {{ $proposal->proposed_content }}
                </div>
            </div>
            @endif

            @if($proposal->reason)
            <div class="level2-proposal-detail__field">
                <h4 class="level2-proposal-detail__field-title">Lý do sửa đổi:</h4>
                <div class="level2-proposal-detail__field-content">
                    {{ $proposal->reason }}
                </div>
            </div>
            @endif
        </div>

        <!-- Response Section -->
        @if($proposal->response)
        <div class="level2-proposal-detail__response">
            <h3 class="level2-proposal-detail__section-title">Phản hồi từ Ban ISO</h3>
            <div class="level2-proposal-detail__response-content">
                <div class="level2-proposal-detail__response-meta">
                    <strong>Người phản hồi:</strong> {{ $proposal->responder->name ?? 'Ban ISO' }}
                    <span class="level2-proposal-detail__response-date">{{ $proposal->responded_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="level2-proposal-detail__response-text">
                    {{ $proposal->response }}
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="level2-proposal-detail__actions">
            @if($proposal->status === 'pending')
            <div class="level2-alert level2-alert--info">
                <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Đang chờ xử lý</strong><br>
                    Đề xuất của bạn đang được Ban ISO xem xét và phản hồi.
                </div>
            </div>
            @elseif($proposal->status === 'approved')
            <div class="level2-alert level2-alert--success">
                <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Đề xuất đã được chấp nhận</strong><br>
                    Ban ISO đã chấp nhận đề xuất của bạn và sẽ thực hiện sửa đổi tài liệu.
                </div>
            </div>
            @elseif($proposal->status === 'rejected')
            <div class="level2-alert level2-alert--error">
                <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Đề xuất đã bị từ chối</strong><br>
                    Ban ISO đã từ chối đề xuất của bạn. Vui lòng xem phản hồi chi tiết ở trên.
                </div>
            </div>
            @else
            <div class="level2-alert level2-alert--success">
                <svg class="level2-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong>Đề xuất đã được thực hiện</strong><br>
                    Ban ISO đã hoàn thành việc sửa đổi tài liệu theo đề xuất của bạn.
                </div>
            </div>
            @endif

            @if($proposal->status === 'pending' && $proposal->user_id === auth()->id())
            <a href="{{ route('level2.proposals.edit', $proposal) }}" 
               class="level2-btn level2-btn--secondary" title="Chỉnh sửa đề xuất">
                <svg class="level2-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa đề xuất
            </a>
            @endif
        </div>
    </div>
</div>
@endsection