@extends('layouts.admin')

@section('title', 'Thêm danh mục mới')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.categories.index', ['document_type_id' => request('document_type_id')]) }}" class="admin-breadcrumb__item">
            Quản lý danh mục{{ $documentType ? ' - ' . $documentType->name : '' }}
        </a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Thêm danh mục</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Thêm danh mục mới</h1>
            <p class="admin-page__subtitle">Tạo danh mục cho {{ $documentType ? $documentType->name : 'loại tài liệu' }}</p>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form">
            @csrf
            
            <!-- Document Type (hidden or display) -->
            @if($documentType)
                <input type="hidden" name="document_type_id" value="{{ $documentType->id }}">
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Loại tài liệu</label>
                        <div class="admin-form__display">{{ $documentType->name }}</div>
                    </div>
                </div>
            @else
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required" for="document_type_id">Loại tài liệu</label>
                        <select id="document_type_id" name="document_type_id" class="admin-form__select @error('document_type_id') admin-form__select--error @enderror" required>
                            <option value="">-- Chọn loại tài liệu --</option>
                            @foreach($documentTypes as $type)
                                <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('document_type_id')
                            <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif
            
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

            @if($parentCategories->count() > 0)
            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label" for="parent_id">Danh mục cha</label>
                    <select id="parent_id" name="parent_id" class="admin-form__select @error('parent_id') admin-form__select--error @enderror">
                        <option value="">-- Vui lòng chọn danh mục --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                    <div class="admin-form__help">Để trống nếu đây là danh mục cấp cha</div>
                </div>
            </div>
            @endif

            <div class="admin-form__actions">
                <a href="{{ route('admin.categories.index', ['document_type_id' => request('document_type_id')]) }}" class="admin-btn admin-btn--secondary">
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

<style>
.admin-form__display {
    padding: 12px 16px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    font-weight: 500;
}
</style>
@endsection