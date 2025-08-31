@extends('layouts.level3')

@section('title', 'Tổng quan - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <h1 class="level3-page__title">Bảng điều khiển cá nhân</h1>
        <p class="level3-page__subtitle">Xem tài liệu và gửi đề xuất sửa đổi</p>
    </div>

    <div class="level3-stats">
        <div class="level3-stats__grid">
            <div class="level3-stat-card">
                <div class="level3-stat-card__icon level3-stat-card__icon--primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="level3-stat-card__content">
                    <div class="level3-stat-card__number">{{ $stats['available_documents'] }}</div>
                    <div class="level3-stat-card__label">Tài liệu có thể truy cập</div>
                </div>
            </div>

            <div class="level3-stat-card">
                <div class="level3-stat-card__icon level3-stat-card__icon--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div class="level3-stat-card__content">
                    <div class="level3-stat-card__number">{{ $stats['pending_proposals'] }}</div>
                    <div class="level3-stat-card__label">Đề xuất chờ duyệt</div>
                </div>
            </div>

            <div class="level3-stat-card">
                <div class="level3-stat-card__icon level3-stat-card__icon--success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div class="level3-stat-card__content">
                    <div class="level3-stat-card__number">{{ $stats['total_proposals'] }}</div>
                    <div class="level3-stat-card__label">Tổng số đề xuất</div>
                </div>
            </div>

            <div class="level3-stat-card">
                <div class="level3-stat-card__icon level3-stat-card__icon--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="level3-stat-card__content">
                    <div class="level3-stat-card__number">0</div>
                    <div class="level3-stat-card__label">Thông báo mới</div>
                </div>
            </div>
        </div>
    </div>

    <div class="level3-dashboard-actions">
        <div class="level3-dashboard-actions__grid">
            <div class="level3-action-card">
                <h3 class="level3-action-card__title">Tài liệu có thể truy cập</h3>
                <p class="level3-action-card__description">Xem và tải xuống tài liệu được phép truy cập</p>
                <a href="{{ route('level3.documents') }}" class="level3-action-card__link">
                    Xem tài liệu
                    <svg class="level3-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level3-action-card">
                <h3 class="level3-action-card__title">Đề xuất sửa đổi</h3>
                <p class="level3-action-card__description">Gửi đề xuất sửa đổi lên cấp quản lý trực tiếp</p>
                <a href="{{ route('level3.proposals') }}" class="level3-action-card__link">
                    Quản lý đề xuất
                    <svg class="level3-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level3-action-card">
                <h3 class="level3-action-card__title">Thông tin cá nhân</h3>
                <p class="level3-action-card__description">Cập nhật thông tin và đổi mật khẩu</p>
                <a href="#" class="level3-action-card__link">
                    Cài đặt tài khoản
                    <svg class="level3-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection