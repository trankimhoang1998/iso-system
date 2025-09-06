@extends('layouts.admin')

@section('title', 'Danh mục Tài liệu nội bộ')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Danh mục Tài liệu nội bộ</h1>
            <p class="admin-page__subtitle">Quản lý danh mục cho Tài liệu nội bộ</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.internal-document-categories.create') }}" class="admin-btn admin-btn--primary">
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
                @include('admin.internal-document-categories.partials.category-item', ['category' => $category, 'level' => 0])
            @empty
                <div class="admin-empty-state">
                    <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="admin-empty-state__title">Chưa có danh mục nào</h3>
                    <p class="admin-empty-state__description">Tạo danh mục đầu tiên cho Tài liệu nội bộ</p>
                    <a href="{{ route('admin.internal-document-categories.create') }}" class="admin-empty-state__btn">
                        Thêm danh mục đầu tiên
                    </a>
                </div>
            @endforelse
        </div>

        @if($categories->hasPages())
            {{ $categories->links('components.pagination') }}
        @endif
    </div>
</div>

@endsection