@extends('layouts.admin')

@section('title', 'Quản lý tài khoản - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <h1 class="admin-page__title">Quản lý tài khoản</h1>
        <div class="admin-page__actions">
            <button type="button" class="admin-btn admin-btn--primary" onclick="showCreateUserModal()">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tạo tài khoản mới
            </button>
        </div>
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th class="admin-table__header">ID</th>
                    <th class="admin-table__header">Tên</th>
                    <th class="admin-table__header">Email</th>
                    <th class="admin-table__header">Phân quyền</th>
                    <th class="admin-table__header">Cơ quan/Phòng ban</th>
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
                    <td class="admin-table__cell">{{ $user->department ?? '-' }}</td>
                    <td class="admin-table__cell">
                        <span class="admin-status-badge @if($user->is_active) admin-status-badge--active @else admin-status-badge--inactive @endif">
                            @if($user->is_active) Hoạt động @else Vô hiệu hóa @endif
                        </span>
                    </td>
                    <td class="admin-table__cell">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="admin-table__cell">
                        <div class="admin-table__actions">
                            <button class="admin-table__action-btn admin-table__action-btn--edit" title="Chỉnh sửa">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            @if($user->id !== auth()->id())
                            <button class="admin-table__action-btn admin-table__action-btn--delete" title="Xóa">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div class="admin-pagination">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Create User Modal -->
<div id="createUserModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Tạo tài khoản mới</h3>
            <button type="button" class="admin-modal__close" onclick="hideCreateUserModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form method="POST" action="{{ route('admin.users.create') }}" class="admin-form">
                @csrf
                <div class="admin-form__group">
                    <label class="admin-form__label">Họ và tên</label>
                    <input type="text" name="name" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Email</label>
                    <input type="email" name="email" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Mật khẩu</label>
                    <input type="password" name="password" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Phân quyền</label>
                    <select name="role" required class="admin-form__select">
                        <option value="">-- Chọn phân quyền --</option>
                        <option value="0">Admin</option>
                        <option value="1">Ban ISO</option>
                        <option value="2">Cơ quan/Phân xưởng</option>
                        <option value="3">Người sử dụng</option>
                    </select>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Cơ quan/Phòng ban</label>
                    <input type="text" name="department" class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Tài khoản cấp trên</label>
                    <select name="parent_id" class="admin-form__select">
                        <option value="">-- Không có --</option>
                        @foreach($users->where('role', '<', 3) as $parentUser)
                        <option value="{{ $parentUser->id }}">{{ $parentUser->name }} ({{ $parentUser->getRoleName() }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="hideCreateUserModal()">Hủy</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Tạo tài khoản</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showCreateUserModal() {
    document.getElementById('createUserModal').style.display = 'flex';
}

function hideCreateUserModal() {
    document.getElementById('createUserModal').style.display = 'none';
}
</script>
@endsection