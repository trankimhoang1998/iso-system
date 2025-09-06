@extends('layouts.admin')

@section('title', 'Chi tiết tài liệu - Nội bộ')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.internal-documents.index') }}" class="admin-breadcrumb__item">Tài liệu nội bộ</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">{{ Str::limit($internalDocument->title, 50) }}</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">{{ $internalDocument->title }}</h1>
        </div>
        <div class="admin-page__actions">
            @if($internalDocument->pdf_file_path)
            <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'pdf']) }}"
               class="admin-btn admin-btn--success">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tải PDF
            </a>
            @endif
            @if($internalDocument->word_file_path)
            <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'word']) }}"
               class="admin-btn admin-btn--info">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Tải Word
            </a>
            @endif
            @if(in_array(auth()->user()->role, [0, 1, 2]))
            <a href="{{ route('admin.internal-documents.edit', $internalDocument) }}" 
               class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
            @endif
        </div>
    </div>

    <div class="admin-document-viewer">
        <div class="admin-document-header">
            <div class="admin-document-meta">
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Danh mục:</span>
                    <span class="admin-document-type-badge admin-document-type-badge--internal">
                        {{ $internalDocument->category->name ?? 'Không có danh mục' }}
                    </span>
                </div>
                @if($internalDocument->department)
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Phòng ban:</span>
                    <span class="admin-document-meta__value">{{ $internalDocument->department->name }}</span>
                </div>
                @endif
                <div class="admin-document-meta__item">
                    <span class="admin-document-meta__label">Trạng thái:</span>
                    <span class="admin-status-badge 
                        @if($internalDocument->status == 'approved') admin-status-badge--active 
                        @elseif($internalDocument->status == 'draft') admin-status-badge--warning
                        @else admin-status-badge--inactive @endif">
                        {{ $internalDocument->getStatusName() }}
                    </span>
                </div>
            </div>
        </div>

        @if($internalDocument->description)
        <div class="admin-document-description">
            <h3 class="admin-document-description__title">Mô tả</h3>
            <div class="admin-document-description__content">
                {{ $internalDocument->description }}
            </div>
        </div>
        @endif

        @if($internalDocument->pdf_file_path || $internalDocument->word_file_path)
        <div class="admin-document-file">
            <h3 class="admin-document-file__title">File đính kèm</h3>
            <div class="admin-document-file__info">
                @if($internalDocument->pdf_file_path)
                <div class="admin-file-item">
                    <svg class="admin-file-item__icon admin-file-item__icon--pdf" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="admin-file-item__details">
                        <div class="admin-file-item__name">{{ $internalDocument->pdf_file_name }}</div>
                        <div class="admin-file-item__size">{{ number_format($internalDocument->pdf_file_size / 1024 / 1024, 2) }}MB</div>
                        <div class="admin-file-item__type">PDF</div>
                    </div>
                    <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'pdf']) }}"
                       class="admin-btn admin-btn--sm admin-btn--success">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tải PDF
                    </a>
                </div>
                @endif
                
                @if($internalDocument->word_file_path)
                <div class="admin-file-item">
                    <svg class="admin-file-item__icon admin-file-item__icon--word" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="admin-file-item__details">
                        <div class="admin-file-item__name">{{ $internalDocument->word_file_name }}</div>
                        <div class="admin-file-item__size">{{ number_format($internalDocument->word_file_size / 1024 / 1024, 2) }}MB</div>
                        <div class="admin-file-item__type">{{ strtoupper($internalDocument->word_file_type) }}</div>
                    </div>
                    <a href="{{ route('admin.internal-documents.download', [$internalDocument, 'word']) }}"
                       class="admin-btn admin-btn--sm admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tải Word
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="admin-document-info">
            <h3 class="admin-document-info__title">Thông tin tài liệu</h3>
            <div class="admin-document-info__grid">
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ký hiệu:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->symbol ?: '_' }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Năm ban hành tài liệu:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->issued_year ?: '_' }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Số văn bản:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->document_number ?: '_' }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Cơ quan ban hành:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->issuing_agency ?: '_' }}</span>
                </div>
                @if($internalDocument->uploader)
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Người tải lên:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->uploader->name }}</span>
                </div>
                @endif
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày tạo:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày cập nhật:</span>
                    <span class="admin-info-item__value">{{ $internalDocument->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        @if($internalDocument->summary)
        <div class="admin-document-summary">
            <h3 class="admin-document-summary__title">Trích yếu</h3>
            <div class="admin-document-summary__content">
                {{ $internalDocument->summary }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection