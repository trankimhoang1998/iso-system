<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Cơ quan/Phân xưởng - Hệ thống ISO')</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="level2-layout">
    @include('partials.level2.header')

    <div class="level2-container">
        @include('partials.level2.sidebar')

        <!-- Level2 Main Content -->
        <main class="level2-main">
            <div class="level2-content">
                @if(session('success'))
                    <div class="level2-alert level2-alert--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="level2-alert level2-alert--error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>