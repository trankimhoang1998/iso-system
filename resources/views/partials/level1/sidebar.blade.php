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
                   class="level1-nav__link @if(request()->routeIs('level1.documents*')) level1-nav__link--active @endif">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Quản lý tài liệu
                </a>
            </li>
            <li class="level1-nav__item">
                <a href="#" class="level1-nav__link">
                    <svg class="level1-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Phân quyền truy cập
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