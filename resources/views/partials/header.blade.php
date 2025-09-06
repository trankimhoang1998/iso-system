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
                    <a href="/iso-directive-documents" class="nav__link {{ request()->is('ban-chi-dao*') ? 'nav__link--active' : '' }}">
                        BAN CHỈ ĐẠO ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/iso-system-documents" class="nav__link {{ request()->is('tai-lieu-he-thong-iso*') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU HỆ THỐNG ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/internal-documents" class="nav__link {{ request()->is('tai-lieu-noi-bo*') ? 'nav__link--active' : '' }}">
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
                        <span class="nav__user-icon">👤</span>
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