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
            <li class="admin-nav__item admin-nav__item--has-submenu">
                <a href="#" class="admin-nav__link admin-nav__toggle" data-tooltip="Quản lý danh mục">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3m0 0V5a2 2 0 012-2h4a2 2 0 012 2v3M8 5a2 2 0 00-2 2v1H4a2 2 0 00-2 2v4a2 2 0 002 2h2v1a2 2 0 002 2h4a2 2 0 002-2v-1h2a2 2 0 002-2V9a2 2 0 00-2-2h-2V5a2 2 0 00-2-2H8z"></path>
                    </svg>
                    <span>Quản lý danh mục</span>
                    <svg class="admin-nav__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <ul class="admin-nav__submenu">
                    @foreach(\App\Models\DocumentType::all() as $documentType)
                    <li class="admin-nav__subitem">
                        <a href="{{ route('admin.categories.index', ['document_type_id' => $documentType->id]) }}" 
                           class="admin-nav__sublink @if(request()->routeIs('admin.categories*') && request('document_type_id') == $documentType->id) admin-nav__sublink--active @endif">
                            {{ $documentType->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endif
            @foreach(\App\Models\DocumentType::all() as $documentType)
            <li class="admin-nav__item">
                <a href="{{ route('admin.documents.index', ['document_type_id' => $documentType->id]) }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.documents.index') && request('document_type_id') == $documentType->id) admin-nav__link--active @endif"
                   data-tooltip="{{ $documentType->name }}">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($documentType->name == 'BAN CHỈ ĐẠO ISO')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        @elseif($documentType->name == 'TÀI LIỆU HỆ THỐNG ISO')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        @elseif($documentType->name == 'TÀI LIỆU NỘI BỘ')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        @endif
                    </svg>
                    <span>{{ $documentType->name }}</span>
                </a>
            </li>
            @endforeach
            <li class="admin-nav__item">
                <a href="#" class="admin-nav__link" data-tooltip="Cài đặt hệ thống">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Cài đặt hệ thống</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<style>
/* Submenu styles - Using !important to override existing styles */
.admin-nav__item--has-submenu {
    position: relative !important;
}

.admin-nav__submenu {
    display: none !important;
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    background: rgba(255, 255, 255, 0.15) !important; /* Slightly more visible background */
    border-radius: 4px !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.admin-nav__item--has-submenu.active .admin-nav__submenu {
    display: block !important;
    max-height: 300px;
    opacity: 1;
}

.admin-nav__subitem {
    margin: 0 !important;
    list-style: none !important;
}

.admin-nav__sublink {
    display: flex !important;
    align-items: center !important;
    padding: 8px 15px 8px 40px !important; /* Reduced padding */
    color: #374151 !important;
    text-decoration: none !important;
    font-size: 14px !important;
    border-radius: 4px !important;
    margin: 1px 8px !important;
    border: none !important;
    background: rgba(255, 255, 255, 0.9) !important;
}

.admin-nav__sublink:hover {
    background: rgba(255, 255, 255, 0.95) !important; /* Slightly brighter on hover */
    color: #374151 !important;
    text-decoration: none !important;
}

.admin-nav__sublink--active {
    background: rgba(255, 255, 255, 1) !important; /* Full white for active */
    color: #1e40af !important; /* Blue text for active */
    font-weight: 500 !important;
}

.admin-nav__arrow {
    width: 16px !important;
    height: 16px !important;
    margin-left: auto !important;
    transition: transform 0.2s ease !important;
    flex-shrink: 0 !important;
}

.admin-nav__item--has-submenu.active .admin-nav__arrow {
    transform: rotate(180deg) !important;
}

.admin-nav__toggle {
    cursor: pointer !important;
    width: 100% !important;
    display: flex !important;
    align-items: center !important;
}

/* Clean styles without debug borders */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle submenu toggle
    const toggles = document.querySelectorAll('.admin-nav__toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const item = this.closest('.admin-nav__item--has-submenu');
            if (!item) return;
            
            const isActive = item.classList.contains('active');
            
            // Close all other submenus
            document.querySelectorAll('.admin-nav__item--has-submenu').forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current submenu
            item.classList.toggle('active', !isActive);
        });
    });

    // Auto-open submenu if current page is in submenu
    const activeSublink = document.querySelector('.admin-nav__sublink--active');
    if (activeSublink) {
        const submenuParent = activeSublink.closest('.admin-nav__item--has-submenu');
        if (submenuParent) {
            submenuParent.classList.add('active');
        }
    }
});
</script>