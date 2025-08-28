<!-- Level3 Sidebar -->
<aside class="level3-sidebar">
    <nav class="level3-nav">
        <ul class="level3-nav__list">
            <li class="level3-nav__item">
                <a href="{{ route('level3.dashboard') }}" 
                   class="level3-nav__link @if(request()->routeIs('level3.dashboard')) level3-nav__link--active @endif">
                    <svg class="level3-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v10H8V5z"></path>
                    </svg>
                    Tổng quan
                </a>
            </li>
            <li class="level3-nav__item">
                <a href="{{ route('level3.documents') }}" 
                   class="level3-nav__link @if(request()->routeIs('level3.documents*')) level3-nav__link--active @endif">
                    <svg class="level3-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Tài liệu có thể truy cập
                </a>
            </li>
            <li class="level3-nav__item">
                <a href="{{ route('level3.proposals') }}" 
                   class="level3-nav__link @if(request()->routeIs('level3.proposals*')) level3-nav__link--active @endif">
                    <svg class="level3-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Đề xuất của tôi
                </a>
            </li>
            <li class="level3-nav__item">
                <a href="#" class="level3-nav__link">
                    <svg class="level3-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Thông tin cá nhân
                </a>
            </li>
        </ul>
    </nav>
</aside>