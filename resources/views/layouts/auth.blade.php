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
        <div class="auth-header">
            <h1 class="auth-header__title">HỆ THỐNG ISO ĐIỆN TỬ</h1>
            <h2 class="auth-header__subtitle">HUYỆN CHƯƠNG MỸ</h2>
        </div>
        
        <div class="auth-card">
            <div class="auth-card__header">
                <h3 class="auth-card__title">@yield('card-title')</h3>
                <div class="auth-card__role-badge">@yield('role-badge')</div>
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
</body>
</html>