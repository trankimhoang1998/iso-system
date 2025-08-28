<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin - Hệ thống ISO')</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="admin-layout">
    @include('partials.admin.header')

    <div class="admin-container">
        @include('partials.admin.sidebar')

        <!-- Admin Main Content -->
        <main class="admin-main">
            <div class="admin-content">
                @if(session('success'))
                    <div class="admin-alert admin-alert--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-alert admin-alert--error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>