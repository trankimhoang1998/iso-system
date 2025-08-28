@extends('layouts.level1')

@section('title', 'Tổng quan - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <h1 class="level1-page__title">Bảng điều khiển Ban ISO</h1>
        <p class="level1-page__subtitle">Quản lý tài liệu và phân quyền truy cập</p>
    </div>

    <div class="level1-stats">
        <div class="level1-stats__grid">
            <div class="level1-stat-card">
                <div class="level1-stat-card__icon level1-stat-card__icon--primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="level1-stat-card__content">
                    <div class="level1-stat-card__number">0</div>
                    <div class="level1-stat-card__label">Tài liệu đã tải lên</div>
                </div>
            </div>

            <div class="level1-stat-card">
                <div class="level1-stat-card__icon level1-stat-card__icon--success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="level1-stat-card__content">
                    <div class="level1-stat-card__number">{{ $stats['level2_users'] }}</div>
                    <div class="level1-stat-card__label">Cơ quan/Phân xưởng</div>
                </div>
            </div>

            <div class="level1-stat-card">
                <div class="level1-stat-card__icon level1-stat-card__icon--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="level1-stat-card__content">
                    <div class="level1-stat-card__number">{{ $stats['level3_users'] }}</div>
                    <div class="level1-stat-card__label">Người sử dụng</div>
                </div>
            </div>

            <div class="level1-stat-card">
                <div class="level1-stat-card__icon level1-stat-card__icon--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="level1-stat-card__content">
                    <div class="level1-stat-card__number">0</div>
                    <div class="level1-stat-card__label">Đề xuất chờ duyệt</div>
                </div>
            </div>
        </div>
    </div>

    <div class="level1-dashboard-actions">
        <div class="level1-dashboard-actions__grid">
            <div class="level1-action-card">
                <h3 class="level1-action-card__title">Tải lên tài liệu</h3>
                <p class="level1-action-card__description">Tải lên và quản lý các tài liệu, văn bản ISO</p>
                <a href="{{ route('level1.documents') }}" class="level1-action-card__link">
                    Quản lý tài liệu
                    <svg class="level1-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level1-action-card">
                <h3 class="level1-action-card__title">Phân quyền truy cập</h3>
                <p class="level1-action-card__description">Chọn đơn vị được phép xem và tải tài liệu</p>
                <a href="#" class="level1-action-card__link">
                    Cài đặt quyền
                    <svg class="level1-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="level1-action-card">
                <h3 class="level1-action-card__title">Báo cáo thống kê</h3>
                <p class="level1-action-card__description">Xem báo cáo hoạt động và thống kê sử dụng</p>
                <a href="#" class="level1-action-card__link">
                    Xem báo cáo
                    <svg class="level1-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection