@extends('layouts.level1')

@section('title', $document->title . ' - Chi tiết tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-breadcrumb">
        <a href="{{ route('level1.documents') }}" class="level1-breadcrumb__item">Quản lý tài liệu</a>
        <svg class="level1-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="level1-breadcrumb__item level1-breadcrumb__item--current">{{ Str::limit($document->title, 50) }}</span>
    </div>
    
    <div class="level1-page__header">
        <div class="level1-page__title-section">
            <h1 class="level1-page__title">{{ $document->title }}</h1>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.documents.download', $document) }}" 
               class="level1-btn level1-btn--success">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tải xuống
            </a>
            @if($document->uploaded_by == auth()->id() || $document->is_public)
            <a href="{{ route('level1.documents.edit', $document) }}" 
               class="level1-btn level1-btn--primary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
            @endif
        </div>
    </div>

    <div class="level1-document-viewer">
        <div class="level1-document-header">
            <div class="level1-document-meta">
                <div class="level1-document-meta__item">
                    <span class="level1-document-meta__label">Loại tài liệu:</span>
                    <span class="level1-document-type-badge level1-document-type-badge--{{ $document->document_type }}">
                        {{ $document->getDocumentTypeName() }}
                    </span>
                </div>
                <div class="level1-document-meta__item">
                    <span class="level1-document-meta__label">Phiên bản:</span>
                    <span class="level1-document-meta__value">{{ $document->version }}</span>
                </div>
                <div class="level1-document-meta__item">
                    <span class="level1-document-meta__label">Kích thước:</span>
                    <span class="level1-document-meta__value">{{ $document->getFormattedFileSize() }}</span>
                </div>
                <div class="level1-document-meta__item">
                    <span class="level1-document-meta__label">Trạng thái:</span>
                    <span class="level1-status-badge 
                        @if($document->status == 'approved') level1-status-badge--active 
                        @elseif($document->status == 'draft') level1-status-badge--warning
                        @else level1-status-badge--inactive @endif">
                        {{ $document->getStatusName() }}
                    </span>
                </div>
                <div class="level1-document-meta__item">
                    <span class="level1-document-meta__label">Công khai:</span>
                    <span class="level1-document-meta__value">
                        @if($document->is_public)
                            <span class="level1-status-badge level1-status-badge--active">Có</span>
                        @else
                            <span class="level1-status-badge level1-status-badge--inactive">Không</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        @if($document->description)
        <div class="level1-document-description">
            <h3 class="level1-document-description__title">Mô tả</h3>
            <div class="level1-document-description__content">
                {{ $document->description }}
            </div>
        </div>
        @endif

        @if($document->tags && count($document->tags) > 0)
        <div class="level1-document-tags">
            <h3 class="level1-document-tags__title">Tags</h3>
            <div class="level1-document-tags__list">
                @foreach($document->tags as $tag)
                <span class="level1-tag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($document->effective_date || $document->expiry_date)
        <div class="level1-document-dates">
            <h3 class="level1-document-dates__title">Thời hạn hiệu lực</h3>
            <div class="level1-document-dates__content">
                @if($document->effective_date)
                <div class="level1-document-date">
                    <span class="level1-document-date__label">Ngày có hiệu lực:</span>
                    <span class="level1-document-date__value">{{ $document->effective_date->format('d/m/Y') }}</span>
                </div>
                @endif
                @if($document->expiry_date)
                <div class="level1-document-date">
                    <span class="level1-document-date__label">Ngày hết hiệu lực:</span>
                    <span class="level1-document-date__value">{{ $document->expiry_date->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($document->file_path)
        <div class="level1-document-file">
            <h3 class="level1-document-file__title">File đính kèm</h3>
            <div class="level1-document-file__info">
                <div class="level1-file-item">
                    <svg class="level1-file-item__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="level1-file-item__details">
                        <div class="level1-file-item__name">{{ $document->file_name }}</div>
                        <div class="level1-file-item__size">{{ $document->getFormattedFileSize() }}</div>
                        <div class="level1-file-item__type">{{ strtoupper($document->file_type) }}</div>
                    </div>
                    <a href="{{ route('level1.documents.download', $document) }}" 
                       class="level1-btn level1-btn--sm level1-btn--success">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tải xuống
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="level1-document-info">
            <h3 class="level1-document-info__title">Thông tin tài liệu</h3>
            <div class="level1-document-info__grid">
                @if($document->uploader)
                <div class="level1-info-item">
                    <span class="level1-info-item__label">Người tải lên:</span>
                    <span class="level1-info-item__value">{{ $document->uploader->name }}</span>
                </div>
                @endif
                <div class="level1-info-item">
                    <span class="level1-info-item__label">Ngày tạo:</span>
                    <span class="level1-info-item__value">{{ $document->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($document->approver)
                <div class="level1-info-item">
                    <span class="level1-info-item__label">Người phê duyệt:</span>
                    <span class="level1-info-item__value">{{ $document->approver->name }}</span>
                </div>
                @endif
                @if($document->approved_at)
                <div class="level1-info-item">
                    <span class="level1-info-item__label">Ngày phê duyệt:</span>
                    <span class="level1-info-item__value">{{ $document->approved_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                <div class="level1-info-item">
                    <span class="level1-info-item__label">Ngày cập nhật:</span>
                    <span class="level1-info-item__value">{{ $document->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection