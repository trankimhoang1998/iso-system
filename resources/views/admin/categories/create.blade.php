@extends('layouts.admin')

@section('title', 'Thêm danh mục mới')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.categories.index') }}" class="admin-breadcrumb__item">Quản lý danh mục</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Thêm danh mục</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Thêm danh mục mới</h1>
            <p class="admin-page__subtitle">Tạo danh mục mới để phân loại tài liệu</p>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required" for="name">Tên danh mục</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="admin-form__input @error('name') admin-form__input--error @enderror" 
                           value="{{ old('name') }}" 
                           required>
                    @error('name')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="parent_id">Danh mục cha</label>
                    <select id="parent_id" name="parent_id" class="admin-form__select @error('parent_id') admin-form__select--error @enderror">
                        <option value="">-- Chọn danh mục cha (tùy chọn) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" 
                                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}
                                    data-depth="{{ $parent->depth }}">
                                {{ $parent->full_name }} 
                                @if($parent->depth > 0)
                                    <span class="category-level">(Cấp {{ $parent->depth + 1 }})</span>
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                    <div class="admin-form__help">
                        Để trống nếu đây là danh mục cấp 1. Hệ thống hỗ trợ tối đa 4 cấp danh mục.
                        <br><small>Cấp 1 → Cấp 2 → Cấp 3 → Cấp 4</small>
                    </div>
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="description">Mô tả</label>
                    <textarea id="description" 
                              name="description" 
                              class="admin-form__textarea @error('description') admin-form__textarea--error @enderror" 
                              rows="4" 
                              placeholder="Mô tả chi tiết về danh mục...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="sort_order">Thứ tự sắp xếp</label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           class="admin-form__input @error('sort_order') admin-form__input--error @enderror" 
                           value="{{ old('sort_order', 0) }}" 
                           min="0">
                    @error('sort_order')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                    <div class="admin-form__help">Số càng nhỏ sẽ hiển thị trước (mặc định: 0)</div>
                </div>
            </div>

            <div class="admin-form__actions">
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--secondary">
                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hủy
                </a>
                <button type="submit" class="admin-btn admin-btn--primary">
                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tạo danh mục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection