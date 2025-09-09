@extends('layouts.admin')

@section('title', 'Sửa danh mục Tài liệu nội bộ')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Sửa danh mục: {{ $internalDocumentCategory->name }}</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin danh mục Tài liệu nội bộ</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.internal-document-categories.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.internal-document-categories.update', $internalDocumentCategory) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="admin-form__row">
                <div class="admin-form__group admin-form__group--full">
                    <label for="name" class="admin-form__label">Tên danh mục <span class="admin-form__required">*</span></label>
                    <input type="text" id="name" name="name" class="admin-form__input @error('name') admin-form__input--error @enderror" value="{{ old('name', $internalDocumentCategory->name) }}">
                    @error('name')
                        <span class="admin-form__error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group admin-form__group--full">
                    <label for="description" class="admin-form__label">Thuyết minh</label>
                    <textarea id="description" name="description" rows="3" class="admin-form__input @error('description') admin-form__input--error @enderror" placeholder="Mô tả chi tiết về danh mục (tùy chọn)">{{ old('description', $internalDocumentCategory->description) }}</textarea>
                    @error('description')
                        <span class="admin-form__error">{{ $message }}</span>
                    @enderror
                    <div class="admin-form__help">
                        Thuyết minh về mục đích, phạm vi áp dụng của danh mục này
                    </div>
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group admin-form__group--full">
                    <label for="parent_id" class="admin-form__label">Danh mục cha</label>
                    <select id="parent_id" name="parent_id" class="admin-form__select @error('parent_id') admin-form__select--error @enderror">
                        <option value="">-- Chọn danh mục cha (tùy chọn) --</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id', $internalDocumentCategory->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="admin-form__error">{{ $message }}</span>
                    @enderror
                    <div class="admin-form__help">
                        Nếu không chọn danh mục cha, danh mục này sẽ là danh mục gốc
                    </div>
                </div>
            </div>

            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--primary">
                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Cập nhật danh mục
                </button>
                <a href="{{ route('admin.internal-document-categories.index') }}" class="admin-btn admin-btn--secondary">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection