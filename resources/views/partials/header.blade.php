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
                    <a href="/gioi-thieu" class="nav__link {{ request()->is('gioi-thieu') ? 'nav__link--active' : '' }}">
                        GIỚI THIỆU
                    </a>
                </li>
                <li class="nav__item nav__item--dropdown">
                    <a href="javascript:void(0)" class="nav__link {{ request()->is('ban-chi-dao*') ? 'nav__link--active' : '' }}" data-dropdown="ban-chi-dao">
                        BAN CHỈ ĐẠO ISO
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-ban-chi-dao">
                        <li class="nav__dropdown-item">
                            <a href="/ban-chi-dao/quyet-dinh-ban-hanh" class="nav__dropdown-link">
                                QUYẾT ĐỊNH BAN HÀNH HỆ THỐNG TÀI LIỆU
                            </a>
                        </li>
                        <li class="nav__dropdown-item">
                            <a href="/ban-chi-dao/ho-so-cong-bo" class="nav__dropdown-link">
                                HỒ SƠ CÔNG BỐ HTQLCL PHÙ HỢP TIÊU CHUẨN ISO
                            </a>
                        </li>
                        <li class="nav__dropdown-item">
                            <a href="/ban-chi-dao/quyet-dinh-thanh-lap" class="nav__dropdown-link">
                                QUYẾT ĐỊNH THÀNH LẬP BCĐ ISO
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav__item">
                    <a href="/he-thong-iso" class="nav__link {{ request()->is('he-thong-iso') ? 'nav__link--active' : '' }}">
                        HỆ THỐNG ISO 9001:2015
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/tai-lieu-noi-bo" class="nav__link {{ request()->is('tai-lieu-noi-bo') ? 'nav__link--active' : '' }}">
                        TÀI LIỆU NỘI BỘ
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/van-ban-quan-ly" class="nav__link {{ request()->is('van-ban-quan-ly') ? 'nav__link--active' : '' }}">
                        VĂN BẢN QUẢN LÝ
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>