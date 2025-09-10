@extends('layouts.admin')

@section('title', 'Cập nhật Link Tài Liệu Hướng Dẫn')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.download-guide.index') }}" class="admin-breadcrumb__item">Quản lý Link Hướng Dẫn</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Cập nhật link</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Cập nhật Link Tài Liệu Hướng Dẫn</h1>
            <p class="admin-page__subtitle">Chỉnh sửa link tài liệu hướng dẫn sử dụng hiển thị trên trang chủ</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.download-guide.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.download-guide.update') }}" class="admin-form">
                @csrf
                @method('PUT')
                
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Link Tài Liệu Hướng Dẫn</label>
                        <input type="url" name="download_link" value="{{ old('download_link', $downloadGuide->download_link ?? '') }}" 
                               class="admin-form__input @error('download_link') admin-form__input--error @enderror"
                               placeholder="https://example.com/huong-dan-su-dung.pdf">
                        <div class="admin-form__help">
                            <svg class="admin-form__help-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Nhập URL đầy đủ của tài liệu hướng dẫn sử dụng (PDF, Word, v.v.)
                        </div>
                        @error('download_link')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <a href="{{ route('admin.download-guide.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection