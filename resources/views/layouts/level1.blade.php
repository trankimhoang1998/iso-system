<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Ban ISO - Hệ thống ISO')</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="level1-layout">
    @include('partials.level1.header')

    <div class="level1-container">
        @include('partials.level1.sidebar')

        <!-- Level1 Main Content -->
        <main class="level1-main">
            <div class="level1-content">
                @if(session('success'))
                    <div class="level1-alert level1-alert--success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="level1-alert level1-alert--error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>