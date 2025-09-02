@extends('layouts.admin')

@section('title', 'Quản lý tài khoản - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <h1 class="admin-page__title">Quản lý tài khoản</h1>
        <div class="admin-page__actions">
            <a href="{{ route('admin.users.create') }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tạo tài khoản mới
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="admin-filter">
        <form method="GET" action="{{ route('admin.users.index') }}" class="admin-filter__form">
            <div class="admin-filter__row">
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tên hoặc email..." class="admin-filter__input">
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Phân quyền</label>
                    <select name="role" class="admin-filter__select">
                        <option value="">Tất cả</option>
                        <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Ban ISO</option>
                        <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Cơ quan - Phân xưởng</option>
                        <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>Người sử dụng</option>
                    </select>
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Phân xưởng</label>
                    <select name="department" class="admin-filter__select">
                        <option value="">Tất cả</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Trạng thái</label>
                    <select name="status" class="admin-filter__select">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Vô hiệu hóa</option>
                    </select>
                </div>
                <div class="admin-filter__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th class="admin-table__header">ID</th>
                    <th class="admin-table__header">Tên</th>
                    <th class="admin-table__header">Email</th>
                    <th class="admin-table__header">Phân quyền</th>
                    <th class="admin-table__header">Phân xưởng</th>
                    <th class="admin-table__header">Trạng thái</th>
                    <th class="admin-table__header">Ngày tạo</th>
                    <th class="admin-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="admin-table__body">
                @foreach($users as $user)
                <tr class="admin-table__row">
                    <td class="admin-table__cell">{{ $user->id }}</td>
                    <td class="admin-table__cell">
                        <div class="admin-user-info">
                            <div class="admin-user-info__name">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="admin-table__cell">{{ $user->email }}</td>
                    <td class="admin-table__cell">
                        <span class="admin-role-badge admin-role-badge--role-{{ $user->role }}">
                            {{ $user->getRoleName() }}
                        </span>
                    </td>
                    <td class="admin-table__cell">
                        @if($user->department)
                            {{ $user->department->name }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="admin-table__cell">
                        <span class="admin-status-badge @if($user->is_active) admin-status-badge--active @else admin-status-badge--inactive @endif">
                            @if($user->is_active) Hoạt động @else Vô hiệu hóa @endif
                        </span>
                    </td>
                    <td class="admin-table__cell">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="admin-table__cell">
                        <div class="admin-table__actions">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="admin-btn admin-btn--sm admin-btn--warning"
                               title="Chỉnh sửa">
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @if($user->id !== auth()->id())
                            <button type="button" 
                                    class="admin-btn admin-btn--sm admin-btn--danger" 
                                    title="Xóa"
                                    onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        {{ $users->links('components.pagination') }}
    @endif
</div>

<!-- Delete User Modal -->
<div id="deleteModal" class="admin-modal">
    <div class="admin-modal__content">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận xóa tài khoản</h3>
            <button type="button" class="admin-modal__close" onclick="closeDeleteModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <div class="admin-modal__message">
                <div class="admin-modal__icon admin-modal__icon--danger">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.598 0L4.266 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="admin-modal__message-content">
                    <p class="admin-modal__message-title">Bạn có chắc chắn muốn xóa tài khoản?</p>
                    <p class="admin-modal__message-text">Tài khoản <strong id="deleteUserName"></strong> sẽ bị xóa vĩnh viễn. Hành động này không thể hoàn tác.</p>
                </div>
            </div>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="closeDeleteModal()">Hủy</button>
                <form method="POST" id="deleteForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger">Xóa tài khoản</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = `/admin/users/${userId}`;
    document.getElementById('deleteModal').classList.add('admin-modal--active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('admin-modal--active');
}

// Close modal when clicking outside
window.addEventListener('click', function(e) {
    if (e.target.classList.contains('admin-modal')) {
        e.target.classList.remove('admin-modal--active');
    }
});
</script>
@endsection