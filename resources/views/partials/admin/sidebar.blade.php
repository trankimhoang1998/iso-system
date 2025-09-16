<!-- Admin Sidebar -->
<aside class="admin-sidebar">
    <nav class="admin-nav">
        <ul class="admin-nav__list">
            
            <!-- Dynamic Categories Section based on current route -->
            @if(request()->routeIs('admin.iso-directive-documents*') || request()->is('iso-directive-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Ban chỉ đạo ISO</span>
                </li>
                @php
                    $isoDirectiveCategories = \App\Models\IsoDirectiveCategory::whereNull('parent_id')->orderBy('id')->get();
                    
                    function renderIsoDirectiveCategories($categories, $level = 0) {
                        foreach($categories as $category) {
                            $childCategories = \App\Models\IsoDirectiveCategory::where('parent_id', $category->id)->orderBy('id')->get();
                            $hasChildren = $childCategories->count() > 0;
                            $isActive = (request()->route('category') && request()->route('category')->id == $category->id);
                            $childClass = $level > 0 ? 'admin-nav__item--child' . ($level > 1 ? ' admin-nav__item--level-' . $level : '') : '';
                            $indentStyle = $level > 1 ? 'style="padding-left: ' . (20 + ($level - 1) * 15) . 'px;"' : '';
                            
                            echo '<li class="admin-nav__item ' . $childClass . ($hasChildren ? ' admin-nav__item--expandable' : '') . '" ' . $indentStyle . '>';
                            
                            if($hasChildren) {
                                // Parent category - expandable, no direct link
                                echo '<a href="javascript:void(0)" class="admin-nav__link admin-nav__link--expandable" data-toggle="submenu-iso-directive-' . $category->id . '">';
                                echo '<svg class="admin-nav__icon admin-nav__icon--expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            } else {
                                // Leaf category - clickable link
                                echo '<a href="/iso-directive-documents/category/' . $category->id . '" ';
                                echo 'class="admin-nav__link ' . ($isActive ? 'admin-nav__link--active' : '') . '">';
                                echo '<svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            }
                            
                            echo '<span>' . htmlspecialchars($category->name) . '</span>';
                            echo '</a>';
                            echo '</li>';
                            
                            // Render child categories if they exist
                            if($hasChildren) {
                                echo '<ul class="admin-nav__submenu" id="submenu-iso-directive-' . $category->id . '" style="display: none;">';
                                renderIsoDirectiveCategories($childCategories, $level + 1);
                                echo '</ul>';
                            }
                        }
                    }
                    
                    renderIsoDirectiveCategories($isoDirectiveCategories);
                @endphp
            @endif

            @if(request()->routeIs('admin.iso-system-documents*') || request()->is('iso-system-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Tài liệu hệ thống ISO</span>
                </li>
                @php
                    $isoSystemCategories = \App\Models\IsoSystemCategory::whereNull('parent_id')->orderBy('id')->get();
                    
                    function renderIsoSystemCategories($categories, $level = 0) {
                        foreach($categories as $category) {
                            $childCategories = \App\Models\IsoSystemCategory::where('parent_id', $category->id)->orderBy('id')->get();
                            $hasChildren = $childCategories->count() > 0;
                            $isActive = (request()->route('category') && request()->route('category')->id == $category->id);
                            $childClass = $level > 0 ? 'admin-nav__item--child' . ($level > 1 ? ' admin-nav__item--level-' . $level : '') : '';
                            $indentStyle = $level > 1 ? 'style="padding-left: ' . (20 + ($level - 1) * 15) . 'px;"' : '';
                            
                            echo '<li class="admin-nav__item ' . $childClass . ($hasChildren ? ' admin-nav__item--expandable' : '') . '" ' . $indentStyle . '>';
                            
                            if($hasChildren) {
                                // Parent category - expandable, no direct link
                                echo '<a href="javascript:void(0)" class="admin-nav__link admin-nav__link--expandable" data-toggle="submenu-iso-system-' . $category->id . '">';
                                echo '<svg class="admin-nav__icon admin-nav__icon--expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            } else {
                                // Leaf category - clickable link
                                echo '<a href="/iso-system-documents/category/' . $category->id . '" ';
                                echo 'class="admin-nav__link ' . ($isActive ? 'admin-nav__link--active' : '') . '">';
                                echo '<svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            }
                            
                            echo '<span>' . htmlspecialchars($category->name) . '</span>';
                            echo '</a>';
                            echo '</li>';
                            
                            // Render child categories if they exist
                            if($hasChildren) {
                                echo '<ul class="admin-nav__submenu" id="submenu-iso-system-' . $category->id . '" style="display: none;">';
                                renderIsoSystemCategories($childCategories, $level + 1);
                                echo '</ul>';
                            }
                        }
                    }
                    
                    renderIsoSystemCategories($isoSystemCategories);
                @endphp
            @endif

            @if(request()->routeIs('admin.internal-documents*') || request()->is('internal-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Tài liệu nội bộ</span>
                </li>
                @php
                    $internalCategories = \App\Models\InternalDocumentCategory::whereNull('parent_id')->orderBy('id')->get();
                    
                    function renderInternalCategories($categories, $level = 0) {
                        foreach($categories as $category) {
                            $childCategories = \App\Models\InternalDocumentCategory::where('parent_id', $category->id)->orderBy('id')->get();
                            $hasChildren = $childCategories->count() > 0;
                            $isActive = (request()->route('category') && request()->route('category')->id == $category->id);
                            $childClass = $level > 0 ? 'admin-nav__item--child' . ($level > 1 ? ' admin-nav__item--level-' . $level : '') : '';
                            $indentStyle = $level > 1 ? 'style="padding-left: ' . (20 + ($level - 1) * 15) . 'px;"' : '';
                            
                            echo '<li class="admin-nav__item ' . $childClass . ($hasChildren ? ' admin-nav__item--expandable' : '') . '" ' . $indentStyle . '>';
                            
                            if($hasChildren) {
                                // Parent category - expandable, no direct link
                                echo '<a href="javascript:void(0)" class="admin-nav__link admin-nav__link--expandable" data-toggle="submenu-internal-' . $category->id . '">';
                                echo '<svg class="admin-nav__icon admin-nav__icon--expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            } else {
                                // Leaf category - clickable link
                                echo '<a href="/internal-documents/category/' . $category->id . '" ';
                                echo 'class="admin-nav__link ' . ($isActive ? 'admin-nav__link--active' : '') . '">';
                                echo '<svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            }
                            
                            echo '<span>' . htmlspecialchars($category->name) . '</span>';
                            echo '</a>';
                            echo '</li>';
                            
                            // Render child categories if they exist
                            if($hasChildren) {
                                echo '<ul class="admin-nav__submenu" id="submenu-internal-' . $category->id . '" style="display: none;">';
                                renderInternalCategories($childCategories, $level + 1);
                                echo '</ul>';
                            }
                        }
                    }
                    
                    renderInternalCategories($internalCategories);
                @endphp
            @endif

            @if(request()->routeIs('audit*') || request()->is('audit*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Đánh giá nội bộ</span>
                </li>

                <li class="admin-nav__item">
                    <a href="{{ route('admin.audit.summary') }}" class="admin-nav__link {{ request()->routeIs('admin.audit.summary') ? 'admin-nav__link--active' : '' }}">
                        <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Tổng hợp</span>
                    </a>
                </li>

                <li class="admin-nav__item">
                    <a href="{{ route('admin.audit.program') }}" class="admin-nav__link {{ request()->routeIs('admin.audit.program') ? 'admin-nav__link--active' : '' }}">
                        <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Chương trình</span>
                    </a>
                </li>

                <li class="admin-nav__item">
                    <a href="{{ route('admin.audit.implementation') }}" class="admin-nav__link {{ request()->routeIs('admin.audit.implementation') ? 'admin-nav__link--active' : '' }}">
                        <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Thực hiện</span>
                    </a>
                </li>

                <li class="admin-nav__item">
                    <a href="{{ route('admin.audit.report') }}" class="admin-nav__link {{ request()->routeIs('admin.audit.report') ? 'admin-nav__link--active' : '' }}">
                        <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Báo cáo</span>
                    </a>
                </li>

                <li class="admin-nav__item">
                    <a href="{{ route('admin.audit.action') }}" class="admin-nav__link {{ request()->routeIs('admin.audit.action') ? 'admin-nav__link--active' : '' }}">
                        <svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Hành động</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
</aside>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle expandable menu items
    const expandableLinks = document.querySelectorAll('.admin-nav__link--expandable');
    
    expandableLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const toggleTarget = this.getAttribute('data-toggle');
            const submenu = document.getElementById(toggleTarget);
            const icon = this.querySelector('.admin-nav__icon--expand');
            
            if (submenu) {
                if (submenu.style.display === 'none' || submenu.style.display === '') {
                    // Expand
                    submenu.style.display = 'block';
                    if (icon) {
                        icon.style.transform = 'rotate(90deg)';
                    }
                } else {
                    // Collapse
                    submenu.style.display = 'none';
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            }
        });
    });
    
    // Auto-expand if current category is active
    const activeLinks = document.querySelectorAll('.admin-nav__link--active');
    activeLinks.forEach(function(activeLink) {
        let parent = activeLink.closest('.admin-nav__submenu');
        while (parent) {
            parent.style.display = 'block';
            // Find the corresponding expand icon
            const toggleId = parent.id;
            const expandLink = document.querySelector(`[data-toggle="${toggleId}"]`);
            if (expandLink) {
                const icon = expandLink.querySelector('.admin-nav__icon--expand');
                if (icon) {
                    icon.style.transform = 'rotate(90deg)';
                }
            }
            parent = parent.parentElement.closest('.admin-nav__submenu');
        }
        
        // Scroll active menu item into view within sidebar container
        setTimeout(function() {
            const sidebar = document.querySelector('.admin-sidebar');
            if (sidebar) {
                const activeRect = activeLink.getBoundingClientRect();
                const sidebarRect = sidebar.getBoundingClientRect();
                const scrollTop = sidebar.scrollTop;
                
                // Calculate position to center the active item in sidebar
                const targetScrollTop = scrollTop + (activeRect.top - sidebarRect.top) - (sidebarRect.height / 2) + (activeRect.height / 2);
                
                sidebar.scrollTo({
                    top: targetScrollTop,
                    behavior: 'smooth'
                });
            }
        }, 100);
    });
});
</script>

