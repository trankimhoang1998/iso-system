@extends('layouts.admin')

@section('title', 'Tổng quan - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <h1 class="admin-page__title">Tổng quan hệ thống</h1>
        <p class="admin-page__subtitle">Thống kê và quản lý hệ thống ISO</p>
    </div>

    <div class="admin-stats">
        <div class="admin-stats__grid">
            <div class="admin-stat-card">
                <div class="admin-stat-card__icon admin-stat-card__icon--primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="admin-stat-card__content">
                    <div class="admin-stat-card__number">{{ $stats['total_users'] }}</div>
                    <div class="admin-stat-card__label">Tổng số tài khoản</div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-card__icon admin-stat-card__icon--success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="admin-stat-card__content">
                    <div class="admin-stat-card__number">{{ $stats['admin_users'] }}</div>
                    <div class="admin-stat-card__label">Admin</div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-card__icon admin-stat-card__icon--info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0V9a1 1 0 011-1h4a1 1 0 011 1v11.02"></path>
                    </svg>
                </div>
                <div class="admin-stat-card__content">
                    <div class="admin-stat-card__number">{{ $stats['level1_users'] }}</div>
                    <div class="admin-stat-card__label">Ban ISO</div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-card__icon admin-stat-card__icon--warning">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h4a1 1 0 011 1v5m-6 0V9a1 1 0 011-1h4a1 1 0 011 1v11.02"></path>
                    </svg>
                </div>
                <div class="admin-stat-card__content">
                    <div class="admin-stat-card__number">{{ $stats['level2_users'] }}</div>
                    <div class="admin-stat-card__label">Cơ quan/Phân xưởng</div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-card__icon admin-stat-card__icon--secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="admin-stat-card__content">
                    <div class="admin-stat-card__number">{{ $stats['level3_users'] }}</div>
                    <div class="admin-stat-card__label">Người sử dụng</div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-dashboard-actions">
        <div class="admin-dashboard-actions__grid">
            <div class="admin-action-card">
                <h3 class="admin-action-card__title">Quản lý tài khoản</h3>
                <p class="admin-action-card__description">Tạo, sửa, xóa và phân quyền tài khoản người dùng</p>
                <a href="{{ route('admin.users') }}" class="admin-action-card__link">
                    Quản lý tài khoản
                    <svg class="admin-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="admin-action-card">
                <h3 class="admin-action-card__title">Quản lý tài liệu</h3>
                <p class="admin-action-card__description">Quản lý tài liệu, văn bản trong hệ thống</p>
                <a href="#" class="admin-action-card__link">
                    Quản lý tài liệu
                    <svg class="admin-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="admin-action-card">
                <h3 class="admin-action-card__title">Cài đặt hệ thống</h3>
                <p class="admin-action-card__description">Cấu hình và tùy chỉnh hệ thống</p>
                <a href="#" class="admin-action-card__link">
                    Cài đặt hệ thống
                    <svg class="admin-action-card__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection