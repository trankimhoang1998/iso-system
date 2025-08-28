<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Người sử dụng - Hệ thống ISO')</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="level3-layout">
    @include('partials.level3.header')

    <div class="level3-container">
        @include('partials.level3.sidebar')

        <!-- Level3 Main Content -->
        <main class="level3-main">
            <div class="level3-content">
                @if(session('success'))
                    <div class="level3-alert level3-alert--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="level3-alert level3-alert--error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>