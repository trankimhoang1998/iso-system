@extends('layouts.admin')

@section('title', 'Chi tiết danh mục: ' . $category->name)

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.categories.index') }}" class="admin-breadcrumb__item">Quản lý danh mục</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">{{ Str::limit($category->name, 50) }}</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">{{ $category->name }}</h1>
            @if($category->parent)
                <p class="admin-page__subtitle">Thuộc danh mục: {{ $category->parent->name }}</p>
            @endif
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-category-detail">
            <div class="admin-category-detail__header">
                <div class="admin-category-detail__meta">
                    <div class="admin-category-detail__meta-item">
                        <span class="admin-category-detail__meta-label">Slug:</span>
                        <span class="admin-category-detail__meta-value">{{ $category->slug }}</span>
                    </div>
                    <div class="admin-category-detail__meta-item">
                        <span class="admin-category-detail__meta-label">Thứ tự:</span>
                        <span class="admin-category-detail__meta-value">{{ $category->sort_order }}</span>
                    </div>
                    <div class="admin-category-detail__meta-item">
                        <span class="admin-category-detail__meta-label">Trạng thái:</span>
                        <span class="admin-status-badge {{ $category->is_active ? 'admin-status-badge--active' : 'admin-status-badge--inactive' }}">
                            {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                        </span>
                    </div>
                    <div class="admin-category-detail__meta-item">
                        <span class="admin-category-detail__meta-label">Số tài liệu:</span>
                        <span class="admin-category-detail__meta-value">{{ $category->documents->count() }}</span>
                    </div>
                </div>
            </div>

            @if($category->description)
                <div class="admin-category-detail__description">
                    <h3 class="admin-category-detail__section-title">Mô tả</h3>
                    <div class="admin-category-detail__description-content">
                        {{ $category->description }}
                    </div>
                </div>
            @endif

            @if($category->children->count() > 0)
                <div class="admin-category-detail__children">
                    <h3 class="admin-category-detail__section-title">Danh mục con ({{ $category->children->count() }})</h3>
                    <div class="admin-category-children-grid">
                        @foreach($category->children as $child)
                            <div class="admin-category-child-card">
                                <div class="admin-category-child-card__header">
                                    <h4 class="admin-category-child-card__name">
                                        <a href="{{ route('admin.categories.show', $child) }}">{{ $child->name }}</a>
                                    </h4>
                                    <span class="admin-status-badge admin-status-badge--sm {{ $child->is_active ? 'admin-status-badge--active' : 'admin-status-badge--inactive' }}">
                                        {{ $child->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </div>
                                @if($child->description)
                                    <p class="admin-category-child-card__description">{{ Str::limit($child->description, 120) }}</p>
                                @endif
                                <div class="admin-category-child-card__footer">
                                    <span class="admin-category-child-card__count">{{ $child->documents->count() }} tài liệu</span>
                                    <div class="admin-category-child-card__actions">
                                        <a href="{{ route('admin.categories.show', $child) }}" class="admin-btn admin-btn--xs admin-btn--secondary">Xem</a>
                                        <a href="{{ route('admin.categories.edit', $child) }}" class="admin-btn admin-btn--xs admin-btn--warning">Sửa</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($category->documents->count() > 0)
                <div class="admin-category-detail__documents">
                    <h3 class="admin-category-detail__section-title">
                        Tài liệu gần đây ({{ $category->documents->count() > 10 ? '10/' : '' }}{{ $category->documents->count() }})
                    </h3>
                    <div class="admin-documents-list">
                        @foreach($category->documents->take(10) as $document)
                            <div class="admin-document-item">
                                <div class="admin-document-item__icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                
                                <div class="admin-document-item__content">
                                    <h4 class="admin-document-item__title">
                                        <a href="{{ route('admin.documents.show', $document) }}">{{ $document->title }}</a>
                                    </h4>
                                    <div class="admin-document-item__meta">
                                        <span class="admin-document-type-badge admin-document-type-badge--{{ $document->getDocumentTypeCssClass() }}">
                                            {{ $document->getDocumentTypeName() }}
                                        </span>
                                        <span class="admin-status-badge admin-status-badge--sm {{ $document->status == 'approved' ? 'admin-status-badge--active' : ($document->status == 'draft' ? 'admin-status-badge--warning' : 'admin-status-badge--inactive') }}">
                                            {{ $document->getStatusName() }}
                                        </span>
                                        <span class="admin-document-item__date">{{ $document->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <div class="admin-document-item__actions">
                                    <a href="{{ route('admin.documents.show', $document) }}" class="admin-btn admin-btn--xs admin-btn--secondary">Xem</a>
                                    <a href="{{ route('admin.documents.edit', $document) }}" class="admin-btn admin-btn--xs admin-btn--warning">Sửa</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($category->documents->count() > 10)
                        <div class="admin-category-detail__show-more">
                            <a href="{{ route('admin.documents.index') }}?category_id={{ $category->id }}" class="admin-btn admin-btn--secondary">
                                Xem tất cả {{ $category->documents->count() }} tài liệu
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="admin-empty-state admin-empty-state--sm">
                    <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h4 class="admin-empty-state__title">Chưa có tài liệu nào</h4>
                    <p class="admin-empty-state__description">Danh mục này chưa có tài liệu nào được phân loại</p>
                </div>
            @endif
        </div>
    </div>

    <div class="admin-category-detail__info">
        <div class="admin-info-card">
            <h3 class="admin-info-card__title">Thông tin danh mục</h3>
            <div class="admin-info-grid">
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày tạo:</span>
                    <span class="admin-info-item__value">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Ngày cập nhật:</span>
                    <span class="admin-info-item__value">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($category->parent)
                    <div class="admin-info-item">
                        <span class="admin-info-item__label">Danh mục cha:</span>
                        <span class="admin-info-item__value">
                            <a href="{{ route('admin.categories.show', $category->parent) }}">{{ $category->parent->name }}</a>
                        </span>
                    </div>
                @endif
                <div class="admin-info-item">
                    <span class="admin-info-item__label">Cấp độ:</span>
                    <span class="admin-info-item__value">Cấp {{ $category->depth + 1 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection