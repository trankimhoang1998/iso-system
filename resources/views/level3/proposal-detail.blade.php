@extends('layouts.level3')

@section('title', $proposal->title . ' - Chi tiết đề xuất - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <div class="level3-breadcrumb">
            <a href="{{ route('level3.proposals') }}" class="level3-breadcrumb__item">Đề xuất</a>
            <svg class="level3-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="level3-breadcrumb__item level3-breadcrumb__item--current">{{ $proposal->title }}</span>
        </div>
        <div class="level3-page__title-row">
            <h1 class="level3-page__title">{{ $proposal->title }}</h1>
            <div class="level3-page__actions">
                @if($proposal->status === 'pending')
                <a href="{{ route('level3.proposals.edit', $proposal) }}" class="level3-btn level3-btn--warning">
                    <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Chỉnh sửa
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="level3-proposal-detail">
        <div class="level3-proposal-header">
            <div class="level3-proposal-meta">
                <div class="level3-proposal-meta__item">
                    <span class="level3-proposal-meta__label">Trạng thái:</span>
                    <span class="level3-badge level3-badge--status-{{ $proposal->status }}">
                        {{ $proposal->getStatusName() }}
                    </span>
                </div>
                <div class="level3-proposal-meta__item">
                    <span class="level3-proposal-meta__label">Loại đề xuất:</span>
                    <span class="level3-badge level3-badge--{{ $proposal->proposal_type }}">
                        {{ $proposal->getProposalTypeName() }}
                    </span>
                </div>
                <div class="level3-proposal-meta__item">
                    <span class="level3-proposal-meta__label">Mức độ ưu tiên:</span>
                    <span class="level3-badge level3-badge--priority-{{ $proposal->priority }}">
                        {{ $proposal->getPriorityName() }}
                    </span>
                </div>
                <div class="level3-proposal-meta__item">
                    <span class="level3-proposal-meta__label">Gửi đến:</span>
                    @if($proposal->level2_user_id)
                        @php
                            $level2User = \App\Models\User::find($proposal->level2_user_id);
                        @endphp
                        <span class="level3-proposal-meta__value">{{ $level2User ? $level2User->name : 'Cấp 2' }}</span>
                    @else
                        <span class="level3-proposal-meta__value">Cấp 2</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="level3-proposal-content">
            <div class="level3-section">
                <h3 class="level3-section__title">Tài liệu liên quan</h3>
                <div class="level3-document-info">
                    <div class="level3-document-info__main">
                        <div class="level3-document-info__title">{{ $proposal->document->title }}</div>
                        <div class="level3-document-info__version">Phiên bản: {{ $proposal->document->version }}</div>
                        @if($proposal->document->description)
                        <div class="level3-document-info__description">{{ $proposal->document->description }}</div>
                        @endif
                    </div>
                    <div class="level3-document-info__actions">
                        @php
                            $permission = $proposal->document->permissions->where('user_id', auth()->id())->first();
                        @endphp
                        @if($permission && $permission->can_view)
                        <a href="{{ route('level3.documents.view', $proposal->document) }}" 
                           class="level3-btn level3-btn--sm level3-btn--info">
                            <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Xem tài liệu
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="level3-section">
                <h3 class="level3-section__title">Mô tả đề xuất</h3>
                <div class="level3-section__content">
                    {{ $proposal->description }}
                </div>
            </div>

            @if($proposal->proposed_content)
            <div class="level3-section">
                <h3 class="level3-section__title">Nội dung đề xuất</h3>
                <div class="level3-section__content level3-section__content--code">
                    {{ $proposal->proposed_content }}
                </div>
            </div>
            @endif

            @if($proposal->reason)
            <div class="level3-section">
                <h3 class="level3-section__title">Lý do sửa đổi</h3>
                <div class="level3-section__content">
                    {{ $proposal->reason }}
                </div>
            </div>
            @endif

            @if($proposal->response)
            <div class="level3-section level3-section--response">
                <h3 class="level3-section__title">Phản hồi từ cấp 2</h3>
                <div class="level3-section__content">
                    {{ $proposal->response }}
                </div>
                @if($proposal->response_at)
                <div class="level3-section__meta">
                    <span class="level3-text--muted">Phản hồi lúc: {{ $proposal->response_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
            @endif
        </div>

        <div class="level3-proposal-info">
            <h3 class="level3-proposal-info__title">Thông tin đề xuất</h3>
            <div class="level3-proposal-info__grid">
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Người tạo:</span>
                    <span class="level3-info-item__value">{{ $proposal->user->name }}</span>
                </div>
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Ngày tạo:</span>
                    <span class="level3-info-item__value">{{ $proposal->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Lần cập nhật cuối:</span>
                    <span class="level3-info-item__value">{{ $proposal->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($proposal->status !== 'pending')
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Ngày xử lý:</span>
                    <span class="level3-info-item__value">
                        {{ $proposal->response_at ? $proposal->response_at->format('d/m/Y H:i') : '-' }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection