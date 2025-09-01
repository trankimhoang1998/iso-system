<!-- Admin Header -->
<header class="admin-header">
    <div class="admin-header__left">
        <button class="admin-header__toggle" id="sidebarToggle" type="button">
            <svg class="admin-header__toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="admin-header__logo">
            <h1 class="admin-header__title">HỆ THỐNG ISO - {{ strtoupper(auth()->user()->getRoleName()) }}</h1>
        </div>
    </div>
    
    <div class="admin-header__right">
        <div class="admin-header__user">
            <span class="admin-header__user-name">{{ auth()->user()->name }}</span>
            <span class="admin-header__user-role">{{ auth()->user()->getRoleName() }}</span>
        </div>
        <div class="admin-header__actions">
            <form method="POST" action="{{ route('auth.logout') }}" class="admin-header__logout-form">
                @csrf
                <button type="submit" class="admin-header__logout-btn">
                    <svg class="admin-header__logout-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</header>