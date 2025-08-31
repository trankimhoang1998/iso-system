@extends('layouts.level3')

@section('title', 'Tài liệu có thể truy cập - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <h1 class="level3-page__title">Tài liệu có thể truy cập</h1>
        <p class="level3-page__subtitle">Các tài liệu mà bạn được phép xem và tải xuống</p>
    </div>

    <!-- Filter Form -->
    <div class="level3-filter">
        <form method="GET" action="{{ route('level3.documents') }}" class="level3-filter__form">
            <div class="level3-filter__row">
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="level3-filter__input">
                </div>
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Loại tài liệu</label>
                    <select name="document_type" class="level3-filter__select">
                        <option value="">Tất cả</option>
                        <option value="policy" {{ request('document_type') == 'policy' ? 'selected' : '' }}>Chính sách</option>
                        <option value="procedure" {{ request('document_type') == 'procedure' ? 'selected' : '' }}>Quy trình</option>
                        <option value="form" {{ request('document_type') == 'form' ? 'selected' : '' }}>Biểu mẫu</option>
                        <option value="manual" {{ request('document_type') == 'manual' ? 'selected' : '' }}>Hướng dẫn</option>
                        <option value="report" {{ request('document_type') == 'report' ? 'selected' : '' }}>Báo cáo</option>
                        <option value="other" {{ request('document_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Trạng thái</label>
                    <select name="status" class="level3-filter__select">
                        <option value="">Tất cả</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hiệu lực</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                    </select>
                </div>
                <div class="level3-filter__actions">
                    <button type="submit" class="level3-btn level3-btn--primary">
                        <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level3.documents') }}" class="level3-btn level3-btn--secondary">
                        <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if(isset($documents) && $documents->count() > 0)
    <div class="level3-table-container">
        <table class="level3-table">
            <thead class="level3-table__head">
                <tr>
                    <th class="level3-table__header">Tiêu đề</th>
                    <th class="level3-table__header">Loại tài liệu</th>
                    <th class="level3-table__header">Phiên bản</th>
                    <th class="level3-table__header">Kích thước</th>
                    <th class="level3-table__header">Quyền của bạn</th>
                    <th class="level3-table__header">Ngày chia sẻ</th>
                    <th class="level3-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="level3-table__body">
                @foreach($documents as $document)
                @php
                    $permission = $document->permissions->first();
                @endphp
                <tr class="level3-table__row">
                    <td class="level3-table__cell">
                        <div class="level3-document-info">
                            <div class="level3-document-info__title">{{ $document->title }}</div>
                            @if($document->description)
                            <div class="level3-document-info__description">{{ Str::limit($document->description, 50) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="level3-table__cell">
                        <span class="level3-badge level3-badge--{{ $document->document_type }}">
                            {{ $document->getDocumentTypeName() }}
                        </span>
                    </td>
                    <td class="level3-table__cell">{{ $document->version }}</td>
                    <td class="level3-table__cell">{{ $document->getFormattedFileSize() }}</td>
                    <td class="level3-table__cell">
                        <div class="level3-permissions">
                            @if($permission && $permission->can_view)
                            <span class="level3-badge level3-badge--success level3-badge--sm">Xem</span>
                            @endif
                            @if($permission && $permission->can_download)
                            <span class="level3-badge level3-badge--info level3-badge--sm">Tải xuống</span>
                            @endif
                        </div>
                    </td>
                    <td class="level3-table__cell">
                        {{ $permission ? $permission->created_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="level3-table__cell">
                        <div class="level3-table__actions">
                            @if($permission && $permission->can_view)
                            <a href="{{ route('level3.documents.view', $document) }}" 
                               class="level3-btn level3-btn--sm level3-btn--info" 
                               title="Xem tài liệu">
                                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            @endif
                            
                            @if($permission && $permission->can_download)
                            <a href="{{ route('level3.documents.download', $document) }}" 
                               class="level3-btn level3-btn--sm level3-btn--success" 
                               title="Tải xuống">
                                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="level3-pagination-wrapper">
        {{ $documents->links('components.level3-pagination') }}
    </div>
    @else
    <div class="level3-documents__empty">
        <div class="level3-empty-state">
            <svg class="level3-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="level3-empty-state__title">Chưa có tài liệu nào được chia sẻ</h3>
            <p class="level3-empty-state__description">Hiện tại chưa có tài liệu nào được chia sẻ cho bạn</p>
        </div>
    </div>
    @endif
</div>
@endsection