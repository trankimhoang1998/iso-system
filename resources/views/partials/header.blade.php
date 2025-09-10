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
                    <a href="{{ route('home') }}" class="nav__link {{ request()->routeIs('home') ? 'nav__link--active' : '' }}">
                        TRANG CHỦ
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/iso-directive-documents" class="nav__link {{ request()->is('iso-directive-documents*') ? 'nav__link--active' : '' }}">
                        BAN CHỈ ĐẠO ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/iso-system-documents" class="nav__link {{ request()->is('iso-system-documents*') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU HỆ THỐNG ISO
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/internal-documents" class="nav__link {{ request()->is('internal-documents*') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU NỘI BỘ
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/management-documents" class="nav__link {{ request()->is('management-documents*') ? 'nav__link--active' : '' }}">
                        VĂN BẢN QUẢN LÝ
                    </a>
                </li>
            </ul>
        </nav>
        @auth
        <div class="header__user">
            <div class="nav__item nav__item--dropdown nav__item--user">
                <a href="javascript:void(0)" class="nav__link" data-dropdown="user-menu">
                    <span class="nav__user-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </span>
                    <span class="nav__user-info nav__user-info--center">
                        <span class="nav__user-name">{{ auth()->user()->name ?? 'User' }}</span>
                        <small>{{ auth()->user()->getRoleName() }}</small>
                    </span>
                    <span class="nav__arrow">▼</span>
                </a>
                <ul class="nav__dropdown" id="dropdown-user-menu">
                    @if(auth()->user()->isAdmin())
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.users.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ TÀI KHOẢN
                        </a>
                    </li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.departments.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ CƠ QUAN, PHÂN XƯỞNG
                        </a>
                    </li>
                    <li class="nav__dropdown-divider"></li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.iso-directive-categories.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ DANH MỤC - BAN CHỈ ĐẠO ISO
                        </a>
                    </li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.iso-system-categories.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ DANH MỤC - TÀI LIỆU HỆ THỐNG ISO
                        </a>
                    </li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.internal-document-categories.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ DANH MỤC - TÀI LIỆU NỘI BỘ
                        </a>
                    </li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.download-guide.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ LINK HƯỚNG DẪN
                        </a>
                    </li>
                    <li class="nav__dropdown-divider"></li>
                    @endif
                    @if(in_array(auth()->user()->role, [0, 1]))
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.notifications.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ THÔNG BÁO
                        </a>
                    </li>
                    <li class="nav__dropdown-item">
                        <a href="{{ route('admin.new-processes.index') }}" class="nav__dropdown-link">
                            QUẢN LÝ QUY TRÌNH MỚI
                        </a>
                    </li>
                    <li class="nav__dropdown-divider"></li>
                    @endif
                    <li class="nav__dropdown-item">
                        <form method="POST" action="{{ route('auth.logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="nav__dropdown-link logout-btn" style="display: flex; align-items: center; justify-content: center;">
                                <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16" style="margin-right: 8px;">
                                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                </svg>
                                ĐĂNG XUẤT
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @endauth
    </div>
</header>