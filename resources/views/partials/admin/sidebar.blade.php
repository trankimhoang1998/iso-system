<!-- Admin Sidebar -->
<aside class="admin-sidebar">
    <nav class="admin-nav">
        <ul class="admin-nav__list">
            @if(auth()->user()->isAdmin())
            <li class="admin-nav__item">
                <a href="{{ route('admin.users.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.users*')) admin-nav__link--active @endif"
                   data-tooltip="Quản lý tài khoản">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
            <!-- Quản lý danh mục - Admin only -->
            <li class="admin-nav__section">
                <span class="admin-nav__section-title">Quản lý danh mục</span>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-directive-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-directive-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục Ban chỉ đạo ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4"></path>
                    </svg>
                    <span>Ban chỉ đạo ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.iso-system-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.iso-system-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục hệ thống ISO">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Tài liệu hệ thống ISO</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.internal-document-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.internal-document-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục tài liệu nội bộ">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10h12M6 14h12M6 18h7"></path>
                    </svg>
                    <span>Tài liệu nội bộ</span>
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="{{ route('admin.management-document-categories.index') }}" 
                   class="admin-nav__link @if(request()->routeIs('admin.management-document-categories*')) admin-nav__link--active @endif"
                   data-tooltip="Danh mục văn bản quản lý">
                    <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                    </svg>
                    <span>Văn bản quản lý</span>
                </a>
            </li>
            @endif
            
            <!-- Dynamic Categories Section based on current route -->
            @if(request()->routeIs('admin.iso-directive-documents*') || request()->is('iso-directive-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Ban chỉ đạo ISO</span>
                </li>
                @php
                    $isoDirectiveCategories = \App\Models\IsoDirectiveCategory::whereNull('parent_id')->orderBy('id')->get();
                @endphp
                @foreach($isoDirectiveCategories as $category)
                    <li class="admin-nav__item">
                        <a href="/iso-directive-documents?category_id={{ $category->id }}" 
                           class="admin-nav__link @if(request('category_id') == $category->id) admin-nav__link--active @endif">
                            <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4"></path>
                            </svg>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @php
                        $childCategories = \App\Models\IsoDirectiveCategory::where('parent_id', $category->id)->orderBy('id')->get();
                    @endphp
                    @foreach($childCategories as $childCategory)
                        <li class="admin-nav__item admin-nav__item--child">
                            <a href="/iso-directive-documents?category_id={{ $childCategory->id }}" 
                               class="admin-nav__link @if(request('category_id') == $childCategory->id) admin-nav__link--active @endif">
                                <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span>{{ $childCategory->name }}</span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            @endif

            @if(request()->routeIs('admin.iso-system-documents*') || request()->is('iso-system-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Tài liệu hệ thống ISO</span>
                </li>
                @php
                    $isoSystemCategories = \App\Models\IsoSystemCategory::whereNull('parent_id')->orderBy('id')->get();
                @endphp
                @foreach($isoSystemCategories as $category)
                    <li class="admin-nav__item">
                        <a href="/iso-system-documents?category_id={{ $category->id }}" 
                           class="admin-nav__link @if(request('category_id') == $category->id) admin-nav__link--active @endif">
                            <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @php
                        $childCategories = \App\Models\IsoSystemCategory::where('parent_id', $category->id)->orderBy('id')->get();
                    @endphp
                    @foreach($childCategories as $childCategory)
                        <li class="admin-nav__item admin-nav__item--child">
                            <a href="/iso-system-documents?category_id={{ $childCategory->id }}" 
                               class="admin-nav__link @if(request('category_id') == $childCategory->id) admin-nav__link--active @endif">
                                <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span>{{ $childCategory->name }}</span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            @endif

            @if(request()->routeIs('admin.internal-documents*') || request()->is('internal-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Tài liệu nội bộ</span>
                </li>
                @php
                    $internalCategories = \App\Models\InternalDocumentCategory::whereNull('parent_id')->orderBy('id')->get();
                @endphp
                @foreach($internalCategories as $category)
                    <li class="admin-nav__item">
                        <a href="/internal-documents?category_id={{ $category->id }}" 
                           class="admin-nav__link @if(request('category_id') == $category->id) admin-nav__link--active @endif">
                            <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10h12M6 14h12M6 18h7"></path>
                            </svg>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @php
                        $childCategories = \App\Models\InternalDocumentCategory::where('parent_id', $category->id)->orderBy('id')->get();
                    @endphp
                    @foreach($childCategories as $childCategory)
                        <li class="admin-nav__item admin-nav__item--child">
                            <a href="/internal-documents?category_id={{ $childCategory->id }}" 
                               class="admin-nav__link @if(request('category_id') == $childCategory->id) admin-nav__link--active @endif">
                                <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span>{{ $childCategory->name }}</span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            @endif

            @if(request()->routeIs('admin.management-documents*') || request()->is('management-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Văn bản quản lý</span>
                </li>
                @php
                    $managementCategories = \App\Models\ManagementDocumentCategory::whereNull('parent_id')->orderBy('id')->get();
                @endphp
                @foreach($managementCategories as $category)
                    <li class="admin-nav__item">
                        <a href="/management-documents?category_id={{ $category->id }}" 
                           class="admin-nav__link @if(request('category_id') == $category->id) admin-nav__link--active @endif">
                            <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                            </svg>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @php
                        $childCategories = \App\Models\ManagementDocumentCategory::where('parent_id', $category->id)->orderBy('id')->get();
                    @endphp
                    @foreach($childCategories as $childCategory)
                        <li class="admin-nav__item admin-nav__item--child">
                            <a href="/management-documents?category_id={{ $childCategory->id }}" 
                               class="admin-nav__link @if(request('category_id') == $childCategory->id) admin-nav__link--active @endif">
                                <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span>{{ $childCategory->name }}</span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            @endif
        </ul>
    </nav>
</aside>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // No submenu functionality needed - all items are now direct links
    console.log('Admin sidebar loaded');
});
</script>

