@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý danh mục</h1>
            <p class="admin-page__subtitle">Quản lý danh mục cho tất cả các loại tài liệu</p>
        </div>
        <div class="admin-page__actions">
            <button id="addCategoryBtn" class="admin-btn admin-btn--primary" style="display: none;">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm danh mục
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="admin-tabs">
        <div class="admin-tabs__nav">
            @foreach($documentTypes as $index => $type)
            <button class="admin-tabs__btn @if($index === 0) admin-tabs__btn--active @endif" 
                    data-tab="tab-{{ $type->id }}" 
                    data-type-id="{{ $type->id }}">
                {{ $type->name }}
                <span class="admin-tabs__count">{{ $type->categories_count ?? 0 }}</span>
            </button>
            @endforeach
        </div>

        <!-- Tab Content -->
        <div class="admin-tabs__content">
            @foreach($documentTypes as $index => $type)
            <div class="admin-tabs__pane @if($index === 0) admin-tabs__pane--active @endif" id="tab-{{ $type->id }}">
                <div class="admin-categories-simple" id="categories-{{ $type->id }}">
                    <div class="admin-loading">
                        <div class="admin-loading__spinner"></div>
                        <p>Đang tải danh mục...</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
/* Tab Styles */
.admin-tabs {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.admin-tabs__nav {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}

.admin-tabs__btn {
    flex: 1;
    padding: 16px 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
    transition: all 0.2s ease;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.admin-tabs__btn:hover {
    color: #374151;
    background: #f3f4f6;
}

.admin-tabs__btn--active {
    color: #3b82f6;
    background: white;
}

.admin-tabs__btn--active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: #3b82f6;
}

.admin-tabs__count {
    background: #e5e7eb;
    color: #6b7280;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.admin-tabs__btn--active .admin-tabs__count {
    background: #dbeafe;
    color: #3b82f6;
}

.admin-tabs__content {
    position: relative;
}

.admin-tabs__pane {
    display: none;
    min-height: 400px;
}

.admin-tabs__pane--active {
    display: block;
}

/* Loading Styles */
.admin-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
    color: #6b7280;
}

.admin-loading__spinner {
    width: 32px;
    height: 32px;
    border: 3px solid #e5e7eb;
    border-top: 3px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 16px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Categories Styles */
.admin-categories-simple {
    padding: 20px;
}

.admin-category-simple-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    margin-bottom: 12px;
    background-color: #fff;
}

.admin-category-simple-content {
    flex: 1;
}

.admin-category-simple-name {
    font-size: 16px;
    font-weight: 500;
    color: #1f2937;
}

.admin-category-simple-children {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.admin-category-simple-child {
    background: #f3f4f6;
    color: #6b7280;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.admin-category-simple-actions {
    display: flex;
    gap: 8px;
}

/* Empty State */
.admin-empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.admin-empty-state__icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 20px;
    color: #d1d5db;
}

.admin-empty-state__title {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.admin-empty-state__description {
    margin-bottom: 24px;
}

.admin-empty-state__btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s ease;
}

.admin-empty-state__btn:hover {
    background: #2563eb;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentTypeId = null;
    const addButton = document.getElementById('addCategoryBtn');
    
    // Tab switching
    document.querySelectorAll('.admin-tabs__btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            const typeId = this.dataset.typeId;
            
            // Update active tab
            document.querySelectorAll('.admin-tabs__btn').forEach(b => b.classList.remove('admin-tabs__btn--active'));
            this.classList.add('admin-tabs__btn--active');
            
            // Update active pane
            document.querySelectorAll('.admin-tabs__pane').forEach(p => p.classList.remove('admin-tabs__pane--active'));
            document.getElementById(tabId).classList.add('admin-tabs__pane--active');
            
            // Update current type and load categories
            currentTypeId = typeId;
            loadCategories(typeId);
            
            // Show/update add button
            updateAddButton(typeId);
        });
    });
    
    // Load initial tab
    const firstTab = document.querySelector('.admin-tabs__btn');
    if (firstTab) {
        currentTypeId = firstTab.dataset.typeId;
        loadCategories(currentTypeId);
        updateAddButton(currentTypeId);
    }
    
    function loadCategories(typeId) {
        const container = document.getElementById(`categories-${typeId}`);
        if (!container) return;
        
        // Show loading if content is empty or just has loading
        const hasContent = container.querySelector('.admin-category-simple-item');
        if (!hasContent) {
            container.innerHTML = `
                <div class="admin-loading">
                    <div class="admin-loading__spinner"></div>
                    <p>Đang tải danh mục...</p>
                </div>
            `;
            
            // Load categories via AJAX
            fetch(`/admin/categories?document_type_id=${typeId}&ajax=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        container.innerHTML = data.html;
                    } else {
                        container.innerHTML = `
                            <div class="admin-empty-state">
                                <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <h3 class="admin-empty-state__title">Chưa có danh mục nào</h3>
                                <p class="admin-empty-state__description">Tạo danh mục đầu tiên cho loại tài liệu này</p>
                                <a href="/admin/categories/create?document_type_id=${typeId}" class="admin-empty-state__btn">
                                    Thêm danh mục đầu tiên
                                </a>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                    container.innerHTML = `
                        <div class="admin-empty-state">
                            <h3 class="admin-empty-state__title">Lỗi tải dữ liệu</h3>
                            <p class="admin-empty-state__description">Không thể tải danh mục. Vui lòng thử lại.</p>
                        </div>
                    `;
                });
        }
    }
    
    function updateAddButton(typeId) {
        if (addButton) {
            addButton.style.display = 'inline-flex';
            addButton.onclick = function() {
                window.location.href = `/admin/categories/create?document_type_id=${typeId}`;
            };
        }
    }
});
</script>
@endsection