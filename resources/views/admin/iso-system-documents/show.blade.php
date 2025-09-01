@extends('layouts.admin')

@section('title', $isoSystemDocument->title . ' - Chi tiết văn bản - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.iso-system-documents.index') }}" class="admin-breadcrumb__item">Văn bản hệ thống ISO</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">{{ Str::limit($isoSystemDocument->title, 50) }}</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">{{ $isoSystemDocument->title }}</h1>
        </div>
        <div class="admin-page__actions">
            @if($isoSystemDocument->file_path)
            <a href="{{ route('admin.iso-system-documents.download', $isoSystemDocument) }}"
               class="admin-btn admin-btn--success">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tải xuống
            </a>
            @endif
            <a href="{{ route('admin.iso-system-documents.edit', $isoSystemDocument) }}" 
               class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
        </div>
    </div>

    <div class="admin-document-viewer">
        <div class="admin-document-header">
            <div class="admin-document-meta">
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Danh mục:</span>
                    <span class="admin-document-type-badge admin-document-type-badge--iso-system">
                        {{ $isoSystemDocument->category->name ?? 'Không có danh mục' }}
                    </span>
                </div>
                @if($isoSystemDocument->department)
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Phòng ban:</span>
                    <span class="admin-document-meta__value">{{ $isoSystemDocument->department->name }}</span>
                </div>
                @endif
                @if($isoSystemDocument->file_size)
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Kích thước:</span>
                    <span class="admin-document-meta__value">{{ $isoSystemDocument->getFormattedFileSize() }}</span>
                </div>
                @endif
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Trạng thái:</span>
                    <span class="admin-status-badge 
                        @if($isoSystemDocument->status == 'approved') admin-status-badge--active 
                        @elseif($isoSystemDocument->status == 'draft') admin-status-badge--warning
                        @else admin-status-badge--inactive @endif">
                        {{ $isoSystemDocument->getStatusName() }}
                    </span>
                </div>
            </div>
        </div>

        @if($isoSystemDocument->description)
        <div class="admin-document-description">
            <h3 class="admin-document-description__title">Mô tả</h3>
            <div class="admin-document-description__content">
                {{ $isoSystemDocument->description }}
            </div>
        </div>
        @endif

        @if($isoSystemDocument->file_path)
        <div class="admin-document-file">
            <h3 class="admin-document-file__title">File đính kèm</h3>
            <div class="admin-document-file__info">
                <div class="admin-file-item">
                    <svg class="admin-file-item__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="admin-file-item__details">
                        <div class="admin-file-item__name">{{ $isoSystemDocument->file_name }}</div>
                        @if($isoSystemDocument->file_size)
                        <div class="admin-file-item__size">{{ $isoSystemDocument->getFormattedFileSize() }}</div>
                        @endif
                        @if($isoSystemDocument->file_type)
                        <div class="admin-file-item__type">{{ strtoupper($isoSystemDocument->file_type) }}</div>
                        @endif
                    </div>
                    <a href="{{ route('admin.iso-system-documents.download', $isoSystemDocument) }}"
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
            <h3 class="admin-document-info__title">Thông tin văn bản</h3>
            <div class="admin-document-info__grid">
                @if($isoSystemDocument->uploader)
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Người tải lên:</span>
                    <span class="admin-info-item__value">{{ $isoSystemDocument->uploader->name }}</span>
                </div>
                @endif
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày tạo:</span>
                    <span class="admin-info-item__value">{{ $isoSystemDocument->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày cập nhật:</span>
                    <span class="admin-info-item__value">{{ $isoSystemDocument->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
