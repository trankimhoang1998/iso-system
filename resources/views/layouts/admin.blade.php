<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', auth()->user()->getRoleName() . ' - Hệ thống ISO')</title>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
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
        @unless(request()->is('trang-chu') || 
                request()->routeIs('admin.users*') || 
                request()->routeIs('admin.departments*') || 
                request()->routeIs('admin.iso-directive-categories*') || 
                request()->routeIs('admin.iso-system-categories*') || 
                request()->routeIs('admin.internal-document-categories*') || 
                request()->routeIs('admin.management-documents*'))
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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