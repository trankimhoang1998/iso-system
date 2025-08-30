<!-- Level1 Sidebar -->
<aside class="level1-sidebar">
    <nav class="level1-nav">
        <ul class="level1-nav__list">
            <li class="level1-nav__item">
                <a href="{{ route('level1.dashboard') }}" 
                   class="level1-nav__link @if(request()->routeIs('level1.dashboard')) level1-nav__link--active @endif">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v10H8V5z"></path>
                    </svg>
                    Tổng quan
                </a>
            </li>
            <li class="level1-nav__item">
                <a href="{{ route('level1.documents') }}" 
                   class="level1-nav__link @if(request()->routeIs('level1.documents') || request()->routeIs('level1.documents.store')) level1-nav__link--active @endif">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Danh sách tài liệu
                </a>
            </li>
            <li class="level1-nav__item">
                <a href="{{ route('level1.documents.permissions') }}" 
                   class="level1-nav__link @if(request()->routeIs('level1.documents.permissions*')) level1-nav__link--active @endif">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Quản lý quyền
                </a>
            </li>
            <li class="level1-nav__item">
                <a href="{{ route('level1.proposals') }}" 
                   class="level1-nav__link @if(request()->routeIs('level1.proposals*')) level1-nav__link--active @endif">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Đề xuất sửa đổi
                </a>
            </li>
            <li class="level1-nav__item">
                <a href="#" class="level1-nav__link">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v8a2 2 0 002 2h4a2 2 0 002-2v-8M8 11h8"></path>
                    </svg>
                    Báo cáo thống kê
                </a>
            </li>
        </ul>
    </nav>
</aside>