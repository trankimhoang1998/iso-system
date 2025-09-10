@extends('layouts.admin')

@section('title', 'Chỉnh sửa quy trình mới')

@section('content')
<div class="admin-page">
    <div class="admin-breadcrumb">
        <a href="{{ route('admin.new-processes.index') }}" class="admin-breadcrumb__item">Quản lý quy trình mới</a>
        <svg class="admin-breadcrumb__separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="admin-breadcrumb__item admin-breadcrumb__item--current">Sửa quy trình mới</span>
    </div>
    
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Sửa quy trình mới</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin quy trình mới</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.new-processes.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="admin-document-form">
        <div class="admin-card">
            <form method="POST" action="{{ route('admin.new-processes.update', $newProcess) }}" class="admin-form">
                @csrf
                @method('PUT')
                
                <div class="admin-form__row">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Tiêu đề quy trình</label>
                        <input type="text" name="title" value="{{ old('title', $newProcess->title) }}" 
                               class="admin-form__input @error('title') admin-form__input--error @enderror"
                               placeholder="Nhập tiêu đề quy trình">
                        @error('title')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__row admin-form__row--split">
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Thời gian ban hành</label>
                        <input type="date" name="issue_date" value="{{ old('issue_date', $newProcess->issue_date->format('Y-m-d')) }}" 
                               class="admin-form__input @error('issue_date') admin-form__input--error @enderror">
                        @error('issue_date')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="admin-form__group">
                        <label class="admin-form__label admin-form__label--required">Link tài liệu</label>
                        <input type="url" name="document_link" value="{{ old('document_link', $newProcess->document_link) }}" 
                               class="admin-form__input @error('document_link') admin-form__input--error @enderror"
                               placeholder="https://example.com/document.pdf">
                        @error('document_link')
                        <div class="admin-form__error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <a href="{{ route('admin.new-processes.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật quy trình mới
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection