@extends('layouts.level3')

@section('title', $document->title . ' - Xem tài liệu - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <div class="level3-breadcrumb">
            <a href="{{ route('level3.documents') }}" class="level3-breadcrumb__item">Tài liệu</a>
            <svg class="level3-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="level3-breadcrumb__item level3-breadcrumb__item--current">{{ $document->title }}</span>
        </div>
        <h1 class="level3-page__title">{{ $document->title }}</h1>
    </div>

    <div class="level3-document-viewer">
        <div class="level3-document-header">
            <div class="level3-document-meta">
                <div class="level3-document-meta__item">
                    <span class="level3-document-meta__label">Loại tài liệu:</span>
                    <span class="level3-badge level3-badge--{{ $document->document_type }}">
                        {{ $document->getDocumentTypeName() }}
                    </span>
                </div>
                <div class="level3-document-meta__item">
                    <span class="level3-document-meta__label">Phiên bản:</span>
                    <span class="level3-document-meta__value">{{ $document->version }}</span>
                </div>
                <div class="level3-document-meta__item">
                    <span class="level3-document-meta__label">Kích thước:</span>
                    <span class="level3-document-meta__value">{{ $document->getFormattedFileSize() }}</span>
                </div>
                <div class="level3-document-meta__item">
                    <span class="level3-document-meta__label">Trạng thái:</span>
                    <span class="level3-badge level3-badge--{{ $document->status }}">
                        {{ $document->getStatusName() }}
                    </span>
                </div>
            </div>
            
            <div class="level3-document-actions">
                @php
                    $permission = $document->permissions->first();
                @endphp
                @if($permission && $permission->can_download)
                <a href="{{ route('level3.documents.download', $document) }}" 
                   class="level3-btn level3-btn--primary">
                    <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Tải xuống
                </a>
                @endif
            </div>
        </div>

        @if($document->description)
        <div class="level3-document-description">
            <h3 class="level3-document-description__title">Mô tả</h3>
            <div class="level3-document-description__content">
                {{ $document->description }}
            </div>
        </div>
        @endif

        <div class="level3-document-content">
            <h3 class="level3-document-content__title">Nội dung tài liệu</h3>
            <div class="level3-document-content__body">
                @if($document->content)
                    {!! nl2br(e($document->content)) !!}
                @else
                    <p class="level3-text--muted">Nội dung tài liệu sẽ được hiển thị khi mở file đính kèm</p>
                @endif
            </div>
        </div>

        @if($document->file_path)
        <div class="level3-document-file">
            <h3 class="level3-document-file__title">File đính kèm</h3>
            <div class="level3-document-file__info">
                <div class="level3-file-item">
                    <svg class="level3-file-item__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="level3-file-item__details">
                        <div class="level3-file-item__name">{{ basename($document->file_path) }}</div>
                        <div class="level3-file-item__size">{{ $document->getFormattedFileSize() }}</div>
                    </div>
                    @if($permission && $permission->can_download)
                    <a href="{{ route('level3.documents.download', $document) }}" 
                       class="level3-btn level3-btn--sm level3-btn--success">
                        <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tải xuống
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div class="level3-document-info">
            <h3 class="level3-document-info__title">Thông tin tài liệu</h3>
            <div class="level3-document-info__grid">
                @if($document->uploader)
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Người tải lên:</span>
                    <span class="level3-info-item__value">{{ $document->uploader->name }}</span>
                </div>
                @endif
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Ngày tạo:</span>
                    <span class="level3-info-item__value">{{ $document->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($document->approver)
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Người phê duyệt:</span>
                    <span class="level3-info-item__value">{{ $document->approver->name }}</span>
                </div>
                @endif
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Ngày cập nhật:</span>
                    <span class="level3-info-item__value">{{ $document->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($permission)
                <div class="level3-info-item">
                    <span class="level3-info-item__label">Ngày chia sẻ:</span>
                    <span class="level3-info-item__value">{{ $permission->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection