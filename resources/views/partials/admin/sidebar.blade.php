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
                                
                                if($level == 0) {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>';
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4"></path>';
                                } else {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                }
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
                                
                                if($level == 0) {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>';
                                } else {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                }
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
                                
                                if($level == 0) {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>';
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 10h12M6 14h12M6 18h7"></path>';
                                } else {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                }
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

            @if(request()->routeIs('admin.management-documents*') || request()->is('management-documents*'))
                <li class="admin-nav__section">
                    <span class="admin-nav__section-title">Văn bản quản lý</span>
                </li>
                @php
                    $managementCategories = \App\Models\ManagementDocumentCategory::whereNull('parent_id')->orderBy('id')->get();
                    
                    function renderManagementCategories($categories, $level = 0) {
                        foreach($categories as $category) {
                            $childCategories = \App\Models\ManagementDocumentCategory::where('parent_id', $category->id)->orderBy('id')->get();
                            $hasChildren = $childCategories->count() > 0;
                            $isActive = (request()->route('category') && request()->route('category')->id == $category->id);
                            $childClass = $level > 0 ? 'admin-nav__item--child' . ($level > 1 ? ' admin-nav__item--level-' . $level : '') : '';
                            $indentStyle = $level > 1 ? 'style="padding-left: ' . (20 + ($level - 1) * 15) . 'px;"' : '';
                            
                            echo '<li class="admin-nav__item ' . $childClass . ($hasChildren ? ' admin-nav__item--expandable' : '') . '" ' . $indentStyle . '>';
                            
                            if($hasChildren) {
                                // Parent category - expandable, no direct link
                                echo '<a href="javascript:void(0)" class="admin-nav__link admin-nav__link--expandable" data-toggle="submenu-management-' . $category->id . '">';
                                echo '<svg class="admin-nav__icon admin-nav__icon--expand" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                echo '</svg>';
                            } else {
                                // Leaf category - clickable link
                                echo '<a href="/management-documents/category/' . $category->id . '" ';
                                echo 'class="admin-nav__link ' . ($isActive ? 'admin-nav__link--active' : '') . '">';
                                echo '<svg class="admin-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                
                                if($level == 0) {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>';
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>';
                                } else {
                                    echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>';
                                }
                                echo '</svg>';
                            }
                            
                            echo '<span>' . htmlspecialchars($category->name) . '</span>';
                            echo '</a>';
                            echo '</li>';
                            
                            // Render child categories if they exist
                            if($hasChildren) {
                                echo '<ul class="admin-nav__submenu" id="submenu-management-' . $category->id . '" style="display: none;">';
                                renderManagementCategories($childCategories, $level + 1);
                                echo '</ul>';
                            }
                        }
                    }
                    
                    renderManagementCategories($managementCategories);
                @endphp
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
    });
    
    console.log('Admin sidebar with expandable menus loaded');
});
</script>

