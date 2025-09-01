@extends('layouts.admin')

@section('title', 'Danh mục Ban chỉ đạo ISO')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Danh mục Ban chỉ đạo ISO</h1>
            <p class="admin-page__subtitle">Quản lý danh mục cho Ban chỉ đạo ISO</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.iso-directive-categories.create') }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm danh mục
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-categories-simple">
            @forelse($categories as $category)
                @include('admin.iso-directive-categories.partials.category-item', ['category' => $category, 'level' => 0])
            @empty
                <div class="admin-empty-state">
                    <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="admin-empty-state__title">Chưa có danh mục nào</h3>
                    <p class="admin-empty-state__description">Tạo danh mục đầu tiên cho Ban chỉ đạo ISO</p>
                    <a href="{{ route('admin.iso-directive-categories.create') }}" class="admin-empty-state__btn">
                        Thêm danh mục đầu tiên
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="admin-pagination">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

<style>
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


.admin-category-simple-actions {
    display: flex;
    gap: 8px;
}

.admin-empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.admin-empty-state__icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 20px;
    color: #d1d5db;
}

.admin-empty-state__title {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.admin-empty-state__description {
    margin-bottom: 24px;
}

.admin-empty-state__btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s ease;
}

.admin-empty-state__btn:hover {
    background: #2563eb;
    color: white;
    text-decoration: none;
}
</style>
@endsection