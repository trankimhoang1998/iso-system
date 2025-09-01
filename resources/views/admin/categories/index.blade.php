@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý danh mục</h1>
            <p class="admin-page__subtitle">Quản lý các danh mục tài liệu theo cấp bậc</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm danh mục
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert--success">
            <svg class="admin-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-alert admin-alert--error">
            <svg class="admin-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="admin-categories-tree">
            @forelse($categories->where('parent_id', null) as $category)
                <div class="admin-category-item" data-id="{{ $category->id }}">
                    <div class="admin-category-item__content">
                        <div class="admin-category-item__main">
                            <div class="admin-category-item__icon">
                                @if($category->children->count() > 0)
                                    <svg class="admin-category-item__toggle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    </svg>
                                @endif
                            </div>
                            
                            <div class="admin-category-item__info">
                                <h3 class="admin-category-item__name">
                                    {{ $category->name }}
                                    <span class="admin-category-level">Cấp 1</span>
                                </h3>
                                @if($category->description)
                                    <p class="admin-category-item__description">{{ $category->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="admin-category-item__meta">
                            <span class="admin-category-item__count">
                                {{ $category->documents_count }} tài liệu
                            </span>
                            <span class="admin-status-badge {{ $category->is_active ? 'admin-status-badge--active' : 'admin-status-badge--inactive' }}">
                                {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </div>

                        <div class="admin-category-item__actions">
                            <a href="{{ route('admin.categories.show', $category) }}" 
                               class="admin-btn admin-btn--sm admin-btn--secondary" title="Xem chi tiết">
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="admin-btn admin-btn--sm admin-btn--warning" title="Chỉnh sửa">
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button type="button" class="admin-btn admin-btn--sm admin-btn--primary toggle-status" 
                                    data-id="{{ $category->id }}" title="{{ $category->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($category->is_active)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414l-5.586 5.586m7.071-7.071l2.829-2.829m0 0L12 4.343M12 4.343L9.172 7.172"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    @endif
                                </svg>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="admin-delete-form" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger" 
                                        title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($category->children->count() > 0)
                        <div class="admin-category-children">
                            @foreach($category->children as $child)
                                <div class="admin-category-item admin-category-item--child" data-id="{{ $child->id }}">
                                    <div class="admin-category-item__content">
                                        <div class="admin-category-item__main">
                                            <div class="admin-category-item__icon">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            
                                            <div class="admin-category-item__info">
                                                <h4 class="admin-category-item__name">
                                    {{ $child->name }}
                                    <span class="admin-category-level">Cấp {{ $child->depth + 1 }}</span>
                                </h4>
                                                @if($child->description)
                                                    <p class="admin-category-item__description">{{ $child->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="admin-category-item__meta">
                                            <span class="admin-category-item__count">
                                                {{ $child->documents_count }} tài liệu
                                            </span>
                                            <span class="admin-status-badge {{ $child->is_active ? 'admin-status-badge--active' : 'admin-status-badge--inactive' }}">
                                                {{ $child->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </div>

                                        <div class="admin-category-item__actions">
                                            <a href="{{ route('admin.categories.show', $child) }}" 
                                               class="admin-btn admin-btn--sm admin-btn--secondary" title="Xem chi tiết">
                                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $child) }}" 
                                               class="admin-btn admin-btn--sm admin-btn--warning" title="Chỉnh sửa">
                                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button type="button" class="admin-btn admin-btn--sm admin-btn--primary toggle-status" 
                                                    data-id="{{ $child->id }}" title="{{ $child->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($child->is_active)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414l-5.586 5.586m7.071-7.071l2.829-2.829m0 0L12 4.343M12 4.343L9.172 7.172"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    @endif
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="admin-delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger" 
                                                        title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                    <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="admin-empty-state">
                    <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                    <h3 class="admin-empty-state__title">Chưa có danh mục nào</h3>
                    <p class="admin-empty-state__description">Tạo danh mục đầu tiên để bắt đầu phân loại tài liệu</p>
                    <a href="{{ route('admin.categories.create') }}" class="admin-empty-state__btn">
                        Thêm danh mục đầu tiên
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle category children visibility
    document.querySelectorAll('.admin-category-item__toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const categoryItem = this.closest('.admin-category-item');
            const children = categoryItem.querySelector('.admin-category-children');
            
            if (children) {
                children.style.display = children.style.display === 'none' ? 'block' : 'none';
                this.classList.toggle('rotated');
            }
        });
    });

    // Toggle category status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.dataset.id;
            
            fetch(`/admin/categories/${categoryId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Update status badge
                    const statusBadge = this.closest('.admin-category-item__content').querySelector('.admin-status-badge');
                    statusBadge.textContent = data.is_active ? 'Hoạt động' : 'Không hoạt động';
                    statusBadge.className = `admin-status-badge ${data.is_active ? 'admin-status-badge--active' : 'admin-status-badge--inactive'}`;
                    
                    // Update button icon and title
                    const icon = this.querySelector('svg path');
                    if (data.is_active) {
                        icon.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414l-5.586 5.586m7.071-7.071l2.829-2.829m0 0L12 4.343M12 4.343L9.172 7.172');
                        this.setAttribute('title', 'Vô hiệu hóa');
                    } else {
                        icon.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z');
                        this.setAttribute('title', 'Kích hoạt');
                    }
                    
                    // Show notification
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật trạng thái danh mục');
            });
        });
    });
});
</script>

<style>
.admin-category-item__toggle.rotated {
    transform: rotate(-90deg);
}

.admin-category-children {
    margin-left: 30px;
    padding-left: 20px;
    border-left: 2px solid #e5e5e5;
    margin-top: 10px;
}

.admin-category-item--child {
    margin-bottom: 10px;
}
</style>
@endsection