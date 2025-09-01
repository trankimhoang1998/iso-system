@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục: ' . $category->name)

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
            <h1 class="admin-page__title">Chỉnh sửa danh mục</h1>
            <p class="admin-page__subtitle">{{ $category->name }}</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.categories.show', $category) }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Xem chi tiết
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required" for="name">Tên danh mục</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="admin-form__input @error('name') admin-form__input--error @enderror" 
                           value="{{ old('name', $category->name) }}" 
                           required>
                    @error('name')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="slug">Slug</label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           class="admin-form__input @error('slug') admin-form__input--error @enderror" 
                           value="{{ old('slug', $category->slug) }}">
                    @error('slug')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                    <div class="admin-form__help">Để trống để tự động tạo từ tên danh mục</div>
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="parent_id">Danh mục cha</label>
                    <select id="parent_id" name="parent_id" class="admin-form__select @error('parent_id') admin-form__select--error @enderror">
                        <option value="">-- Chọn danh mục cha (tùy chọn) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" 
                                    {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}
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
                        Để trống nếu đây là danh mục cấp 1. Danh mục hiện tại: <strong>Cấp {{ $category->depth + 1 }}</strong>
                        <br><small>Hệ thống hỗ trợ tối đa 4 cấp danh mục.</small>
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
                              placeholder="Mô tả chi tiết về danh mục...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row admin-form__row--split">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="sort_order">Thứ tự sắp xếp</label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           class="admin-form__input @error('sort_order') admin-form__input--error @enderror" 
                           value="{{ old('sort_order', $category->sort_order) }}" 
                           min="0">
                    @error('sort_order')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__checkbox-label">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               class="admin-form__checkbox" 
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <span class="admin-form__checkbox-text">Trạng thái hoạt động</span>
                    </label>
                    @error('is_active')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
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
                    Cập nhật danh mục
                </button>
            </div>
        </form>
    </div>
</div>
@endsection