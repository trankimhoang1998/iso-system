<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', auth()->user()->getRoleName() . ' - Hệ thống ISO')</title>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    
    <!-- Select2 CSS -->
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="admin-layout">
    @include('partials.banner')
    @include('partials.header')

    <!-- Admin Mobile Toggle -->
    <button class="admin-mobile-toggle" id="adminMobileToggle">
        <span class="hamburger"></span>
        <span class="hamburger"></span>
        <span class="hamburger"></span>
    </button>

    <div class="admin-container">
        @unless(request()->is('home') || 
                request()->routeIs('admin.users*') || 
                request()->routeIs('admin.departments*') || 
                request()->routeIs('admin.iso-directive-categories*') || 
                request()->routeIs('admin.iso-system-categories*') || 
                request()->routeIs('admin.internal-document-categories*') || 
                request()->routeIs('admin.management-documents*') || 
                request()->routeIs('admin.notifications*')|| 
                request()->routeIs('admin.new-processes*')|| 
                request()->routeIs('admin.download-guide*'))
            @include('partials.admin.sidebar')
        @endunless

        <!-- Admin Main Content -->
        <main class="admin-main">
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    @include('partials.footer')

    <!-- jQuery and Toastr JS -->
    <script src="{{ asset('vendor/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    
    <script>
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Display session messages
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>
</body>
</html>