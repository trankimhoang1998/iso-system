<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Đăng nhập - Hệ thống ISO')</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="auth-body">
    <div class="auth-container">
        <!-- Header Section -->
        <div class="auth-header-section">
            <h1 class="auth-main-title">NHÀ MÁY A31 - QUÂN CHỦNG PHÒNG KHÔNG - KHÔNG QUÂN</h1>
            <h2 class="auth-sub-title">HỆ THỐNG QUẢN LÝ CHẤT LƯỢNG THEO TIÊU CHUẨN QUỐC GIA TCVN ISO 9001:2015</h2>
        </div>
        
        <!-- Content Section -->
        <div class="auth-content">
            <!-- Left Column - Information Text -->
            <div class="auth-left">
                <div class="auth-info">
                    <div class="auth-guide">
                        <div class="auth-guide__section">
                            <h3 class="auth-guide__title">Hướng dẫn sử dụng:</h3>
                            <p class="auth-guide__text">Tải xuống tài liệu hướng dẫn sử dụng</p>
                        </div>
                        
                        <div class="auth-guide__section">
                            <h3 class="auth-guide__title">Thông tin hỗ trợ:</h3>
                            <p class="auth-guide__text">Đ/c Ngọc (Thư ký Ban ISO): Nghiệp vụ về Hệ thống QLCL ISO 9001:2015</p>
                            <p class="auth-guide__text">Đ/c Cương (phụ trách CNTT): Sử dụng phần mềm, vận hành hệ thống.</p>
                        </div>
                        
                        <div class="auth-guide__section">
                            <h3 class="auth-guide__title">2025 - Bản quyền thuộc về Nhà máy A31/Quân chủng Phòng không-Không quân</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Login Form -->
            <div class="auth-right">
                <div class="auth-card">
                    <div class="auth-card__header">
                        <h3 class="auth-card__title">@yield('card-title')</h3>
                    </div>
                    
                    <div class="auth-card__body">
                        @if ($errors->any())
                            <div class="auth-alert auth-alert--error">
                                <ul class="auth-alert__list">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>