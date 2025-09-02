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
                <li class="nav__item nav__item--dropdown">
                    <a href="javascript:void(0)" class="nav__link {{ request()->is('ban-chi-dao*') ? 'nav__link--active' : '' }}" data-dropdown="ban-chi-dao">
                        BAN CHỈ ĐẠO ISO
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-ban-chi-dao">
                        @php
                            $isoDirectiveCategories = \App\Models\IsoDirectiveCategory::getFlatList();
                        @endphp
                        @foreach($isoDirectiveCategories as $category)
                            <li class="nav__dropdown-item">
                                <a href="/admin/iso-directive-documents?category_id={{ $category['id'] }}" class="nav__dropdown-link">
                                    {{ $category['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav__item nav__item--dropdown">
                    <a href="javascript:void(0)" class="nav__link {{ request()->is('tai-lieu-he-thong-iso*') ? 'nav__link--active' : '' }}" data-dropdown="tai-lieu-he-thong-iso">
                        TÀI LIỆU HỆ THỐNG ISO
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-tai-lieu-he-thong-iso">
                        <li class="nav__dropdown-item">
                            <a href="/admin/iso-system-documents" class="nav__dropdown-link">
                                TẤT CẢ TÀI LIỆU
                            </a>
                        </li>
                        @php
                            $isoCategories = \App\Models\IsoSystemCategory::getFlatList();
                        @endphp
                        @foreach($isoCategories as $category)
                            <li class="nav__dropdown-item">
                                <a href="/admin/iso-system-documents?category_id={{ $category['id'] }}" class="nav__dropdown-link">
                                    {{ $category['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav__item nav__item--dropdown">
                    <a href="javascript:void(0)" class="nav__link {{ request()->is('tai-lieu-noi-bo*') ? 'nav__link--active' : '' }}" data-dropdown="tai-lieu-noi-bo">
                        TÀI LIỆU NỘI BỘ
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-tai-lieu-noi-bo">
                        <li class="nav__dropdown-item">
                            <a href="/admin/internal-documents" class="nav__dropdown-link">
                                TẤT CẢ TÀI LIỆU
                            </a>
                        </li>
                        @php
                            $internalCategories = \App\Models\InternalDocumentCategory::getFlatList();
                        @endphp
                        @foreach($internalCategories as $category)
                            <li class="nav__dropdown-item">
                                <a href="/admin/internal-documents?category_id={{ $category['id'] }}" class="nav__dropdown-link">
                                    {{ $category['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav__item nav__item--dropdown">
                    <a href="javascript:void(0)" class="nav__link {{ request()->is('van-ban-quan-ly*') ? 'nav__link--active' : '' }}" data-dropdown="van-ban-quan-ly">
                        VĂN BẢN QUẢN LÝ
                        <span class="nav__arrow">▼</span>
                    </a>
                    <ul class="nav__dropdown" id="dropdown-van-ban-quan-ly">
                        <li class="nav__dropdown-item">
                            <a href="/admin/management-documents" class="nav__dropdown-link">
                                TẤT CẢ VĂN BẢN
                            </a>
                        </li>
                        @php
                            $managementCategories = \App\Models\ManagementDocumentCategory::getFlatList();
                        @endphp
                        @foreach($managementCategories as $category)
                            <li class="nav__dropdown-item">
                                <a href="/admin/management-documents?category_id={{ $category['id'] }}" class="nav__dropdown-link">
                                    {{ $category['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>