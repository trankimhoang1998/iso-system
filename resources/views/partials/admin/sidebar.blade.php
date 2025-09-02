<!-- Admin Sidebar -->
<aside class="admin-sidebar">
    <nav class="admin-nav">
        <ul class="admin-nav__list">
            <li class="admin-nav__item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.dashboard')) admin-nav__link--active @endif"
                   data-tooltip="Tổng quan">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v10H8V5z"></path>
                    </svg>
                    <span>Tổng quan</span>
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="admin-nav__item">
                <a href="{{ route('admin.users') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.users*')) admin-nav__link--active @endif"
                   data-tooltip="Quản lý tài khoản">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Quản lý tài khoản</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.departments.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.departments*')) admin-nav__link--active @endif"
                   data-tooltip="Quản lý phân xưởng">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Quản lý phân xưởng</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->isAdmin())
            <!-- Quản lý danh mục - Admin only -->
            <li class="admin-nav__section">
                <span class="admin-nav__section-title">Quản lý danh mục</span>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-directive-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-directive-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục Ban chỉ đạo ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Danh mục Ban chỉ đạo ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-system-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-system-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục hệ thống ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Danh mục hệ thống ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.internal-document-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.internal-document-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục tài liệu nội bộ">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Danh mục tài liệu nội bộ</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.management-document-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.management-document-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục văn bản quản lý">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Danh mục văn bản quản lý</span>
                </a>
            </li>
            @endif
            
            <!-- Quản lý tài liệu - All authenticated users can access -->
            <li class="admin-nav__section">
                <span class="admin-nav__section-title">Quản lý tài liệu</span>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-directive-documents.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-directive-documents*')) admin-nav__link--active @endif"
                   data-tooltip="Tài liệu Ban chỉ đạo ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Tài liệu Ban chỉ đạo ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-system-documents.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-system-documents*')) admin-nav__link--active @endif"
                   data-tooltip="Tài liệu hệ thống ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Tài liệu hệ thống ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.internal-documents.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.internal-documents*')) admin-nav__link--active @endif"
                   data-tooltip="Tài liệu nội bộ">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span>Tài liệu nội bộ</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.management-documents.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.management-documents*')) admin-nav__link--active @endif"
                   data-tooltip="Văn bản quản lý">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Văn bản quản lý</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<style>
/* Section titles */
.admin-nav__section {
    padding: 16px 20px 8px 20px !important;
    border: none !important;
    list-style: none !important;
}

.admin-nav__section-title {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #666666 !important;
    display: block !important;
}

/* Add some spacing after section titles */
.admin-nav__section + .admin-nav__item {
    margin-top: 4px !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // No submenu functionality needed - all items are now direct links
    console.log('Admin sidebar loaded');
});
</script>

