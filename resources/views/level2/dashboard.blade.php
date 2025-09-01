@extends('layouts.level2')

@section('title', 'Tổng quan - Cơ quan - Phân xưởng')

@section('content')
<div class="level2-page">
    <div class="level2-page__header">
        <h1 class="level2-page__title">Bảng điều khiển {{ auth()->user()->department }}</h1>
        <p class="level2-page__subtitle">Quản lý tài liệu và đề xuất sửa đổi</p>
    </div>

    <div class="level2-stats">
        <div class="level2-stats__grid">
            <div class="level2-stat-card">
                <div class="level2-stat-card__icon level2-stat-card__icon--primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="level2-stat-card__content">
                    <div class="level2-stat-card__number">0</div>
                    <div class="level2-stat-card__label">Tài liệu có thể truy cập</div>
                </div>
            </div>

            <div class="level2-stat-card">
                <div class="level2-stat-card__icon level2-stat-card__icon--success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="level2-stat-card__content">
                    <div class="level2-stat-card__number">{{ $stats['level3_users'] }}</div>
                    <div class="level2-stat-card__label">Nhân viên trong đơn vị</div>
                </div>
            </div>

            <div class="level2-stat-card">
                <div class="level2-stat-card__icon level2-stat-card__icon--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div class="level2-stat-card__content">
                    <div class="level2-stat-card__number">{{ $stats['pending_proposals'] }}</div>
                    <div class="level2-stat-card__label">Đề xuất đã gửi</div>
                </div>
            </div>

            <div class="level2-stat-card">
                <div class="level2-stat-card__icon level2-stat-card__icon--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="level2-stat-card__content">
                    <div class="level2-stat-card__number">0</div>
                    <div class="level2-stat-card__label">Thông báo mới</div>
                </div>
            </div>
        </div>
    </div>

    <div class="level2-dashboard-actions">
        <div class="level2-dashboard-actions__grid">
            <div class="level2-action-card">
                <h3 class="level2-action-card__title">Tài liệu được chia sẻ</h3>
                <p class="level2-action-card__description">Xem và tải xuống các tài liệu được Ban ISO chia sẻ</p>
                <a href="{{ route('level2.documents') }}" class="level2-action-card__link">
                    Xem tài liệu
                    <svg class="level2-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level2-action-card">
                <h3 class="level2-action-card__title">Đề xuất sửa đổi</h3>
                <p class="level2-action-card__description">Đăng ký đề xuất sửa đổi lên Ban ISO theo mẫu</p>
                <a href="{{ route('level2.proposals') }}" class="level2-action-card__link">
                    Tạo đề xuất
                    <svg class="level2-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level2-action-card">
                <h3 class="level2-action-card__title">Quản lý nhân viên</h3>
                <p class="level2-action-card__description">Quản lý nhân viên cấp 3 trong đơn vị</p>
                <a href="#" class="level2-action-card__link">
                    Quản lý nhân viên
                    <svg class="level2-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection