@extends('layouts.admin')

@section('title', 'Quản lý Link Tài Liệu Hướng Dẫn')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý Link Tài Liệu Hướng Dẫn</h1>
            <p class="admin-page__subtitle">
                Cập nhật link tài liệu hướng dẫn sử dụng hiển thị trên trang chủ
            </p>
        </div>
    </div>

    <div class="admin-table-container">
        @if($downloadGuide && $downloadGuide->download_link)
            <div class="admin-card">
                <div class="admin-card__header">
                    <h3 class="admin-card__title">
                        <svg class="admin-card__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Link Tài Liệu Hướng Dẫn Sử Dụng
                    </h3>
                </div>
                <div class="admin-card__body">
                    <div class="admin-form__group">
                        <label class="admin-form__label">Link hiện tại:</label>
                        <div class="admin-link-display">
                            <div class="admin-link-display__url">
                                <a href="{{ $downloadGuide->download_link }}" target="_blank" class="admin-link admin-link--external">
                                    {{ $downloadGuide->download_link }}
                                </a>
                            </div>
                            <div class="admin-link-display__actions">
                                <a href="{{ $downloadGuide->download_link }}" target="_blank" class="admin-btn admin-btn--sm admin-btn--outline">
                                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Xem thử
                                </a>
                                <a href="{{ route('admin.download-guide.edit') }}" class="admin-btn admin-btn--sm admin-btn--primary">
                                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Chỉnh sửa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="admin-empty-state">
                <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="admin-empty-state__title">Chưa có link tài liệu hướng dẫn</h3>
                <p class="admin-empty-state__description">
                    Chưa có link tài liệu hướng dẫn sử dụng nào được thiết lập. Hãy thêm link để người dùng có thể tải xuống tài liệu hướng dẫn.
                </p>
                <a href="{{ route('admin.download-guide.edit') }}" class="admin-empty-state__btn">
                    Thiết lập link ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection