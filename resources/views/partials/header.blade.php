<header class="header">
    <div class="header__container">
        <button class="header__mobile-toggle" id="mobileToggle">
            <span class="hamburger"></span>
            <span class="hamburger"></span>
            <span class="hamburger"></span>
        </button>
        <nav class="header__nav" id="headerNav">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="{{ route('trang-chu') }}" class="nav__link {{ request()->routeIs('trang-chu') ? 'nav__link--active' : '' }}">
                        TRANG CHỦ
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/iso-directive-documents?category_id=1" class="nav__link {{ request()->is('iso-directive-documents*') ? 'nav__link--active' : '' }}">
                        BAN CHỈ ĐẠO ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/iso-system-documents?category_id=1" class="nav__link {{ request()->is('iso-system-documents*') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU HỆ THỐNG ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/internal-documents?category_id=1" class="nav__link {{ request()->is('internal-documents*') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU NỘI BỘ
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/management-documents" class="nav__link {{ request()->is('van-ban-quan-ly*') ? 'nav__link--active' : '' }}">
                        VĂN BẢN QUẢN LÝ
                    </a>
                </li>
                @auth
                <li class="nav__item nav__item--dropdown nav__item--user">
                    <a href="javascript:void(0)" class="nav__link" data-dropdown="user-menu">
                        <span class="nav__user-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </span>
                        <span class="nav__user-info">{{ auth()->user()->name ?? 'User' }}</span>
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-user-menu">
                        <li class="nav__dropdown-item">
                            <form method="POST" action="{{ route('auth.logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="nav__dropdown-link logout-btn">
                                    ĐĂNG XUẤT
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </nav>
    </div>
</header>