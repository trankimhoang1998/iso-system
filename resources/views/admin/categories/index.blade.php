@extends('layouts.admin')

@section('title', 'Quản lý danh mục' . ($documentType ? ' - ' . $documentType->name : ''))

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý danh mục{{ $documentType ? ' - ' . $documentType->name : '' }}</h1>
            <p class="admin-page__subtitle">{{ $documentType ? 'Quản lý danh mục cho ' . $documentType->name : 'Chọn loại tài liệu để quản lý danh mục' }}</p>
        </div>
        <div class="admin-page__actions">
            @if($documentType)
                <a href="{{ route('admin.categories.create', ['document_type_id' => $documentType->id]) }}" class="admin-btn admin-btn--primary">
                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Thêm danh mục
                </a>
            @endif
        </div>
    </div>

    @if(!$documentType)
    <div class="admin-card">
        <div class="admin-document-types-grid">
            <h3 class="admin-card__title">Chọn loại tài liệu để quản lý danh mục</h3>
            <div class="admin-types-grid">
                @foreach($documentTypes as $type)
                <a href="{{ route('admin.categories.index', ['document_type_id' => $type->id]) }}" class="admin-type-card">
                    <div class="admin-type-card__icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="admin-type-card__title">{{ $type->name }}</h4>
                    <p class="admin-type-card__count">{{ $type->categories_count ?? 0 }} danh mục</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="admin-categories-simple">
        @forelse($categories as $category)
            @include('admin.categories.partials.category-item', ['category' => $category, 'level' => 0])
        @empty
            <div class="admin-empty-state">
                <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                <h3 class="admin-empty-state__title">Chưa có danh mục nào</h3>
                <p class="admin-empty-state__description">Tạo danh mục đầu tiên cho {{ $documentType->name }}</p>
                <a href="{{ route('admin.categories.create', ['document_type_id' => $documentType->id]) }}" class="admin-empty-state__btn">
                    Thêm danh mục đầu tiên
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="admin-pagination">
        {{ $categories->appends(['document_type_id' => $documentType->id])->links() }}
    </div>
    @endif
</div>

<style>
.admin-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.admin-type-card {
    background: white;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 20px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.admin-type-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #3b82f6;
}

.admin-type-card__icon {
    width: 48px;
    height: 48px;
    color: #6366f1;
    margin-bottom: 15px;
}

.admin-type-card__title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}

.admin-type-card__count {
    color: #6b7280;
    font-size: 14px;
}

.admin-categories-simple {
    padding: 20px;
}

.admin-category-simple-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    margin-bottom: 12px;
    background-color: #fff;
}

.admin-category-simple-content {
    flex: 1;
}

.admin-category-simple-name {
    font-size: 16px;
    font-weight: 500;
    color: #1f2937;
}

.admin-category-simple-children {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.admin-category-simple-child {
    background: #f3f4f6;
    color: #6b7280;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.admin-category-simple-actions {
    display: flex;
    gap: 8px;
}
</style>
@endsection