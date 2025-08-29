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

    <!-- Filter Form -->
    <div class="admin-filter">
        <form method="GET" action="{{ route('admin.users') }}" class="admin-filter__form">
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
                        <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Cơ quan/Phân xưởng</option>
                        <option value="3" {{ request('role') == '3' ? 'selected' : '' }}>Người sử dụng</option>
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
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Cơ quan/Phòng ban</label>
                    <input type="text" name="department" value="{{ request('department') }}" 
                           placeholder="Tên phòng ban..." class="admin-filter__input">
                </div>
                <div class="admin-filter__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('admin.users') }}" class="admin-btn admin-btn--secondary">
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
                            <button class="admin-table__action-btn admin-table__action-btn--edit" 
                                    title="Chỉnh sửa"
                                    onclick="editUser({{ $user->id }})">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            @if($user->id !== auth()->id())
                            <button class="admin-table__action-btn admin-table__action-btn--delete" 
                                    title="Xóa"
                                    onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
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
        {{ $users->links('components.pagination') }}
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
                    <label class="admin-form__label admin-form__label--required">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="admin-form__input @error('name') admin-form__input--error @enderror">
                    @error('name')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="admin-form__input @error('email') admin-form__input--error @enderror">
                    @error('email')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Mật khẩu</label>
                    <input type="password" name="password" required 
                           class="admin-form__input @error('password') admin-form__input--error @enderror">
                    @error('password')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Phân quyền</label>
                    <select name="role" required 
                            class="admin-form__select @error('role') admin-form__select--error @enderror">
                        <option value="">-- Chọn phân quyền --</option>
                        <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Ban ISO</option>
                        <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Cơ quan/Phân xưởng</option>
                        <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Người sử dụng</option>
                    </select>
                    @error('role')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Cơ quan/Phòng ban</label>
                    <input type="text" name="department" value="{{ old('department') }}" 
                           class="admin-form__input @error('department') admin-form__input--error @enderror">
                    @error('department')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Tài khoản cấp trên</label>
                    <select name="parent_id" 
                            class="admin-form__select @error('parent_id') admin-form__select--error @enderror">
                        <option value="">-- Không có --</option>
                        @foreach($users->where('role', '<', 3) as $parentUser)
                        <option value="{{ $parentUser->id }}" {{ old('parent_id') == $parentUser->id ? 'selected' : '' }}>
                            {{ $parentUser->name }} ({{ $parentUser->getRoleName() }})
                        </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="hideCreateUserModal()">Hủy</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Tạo tài khoản</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Chỉnh sửa tài khoản</h3>
            <button type="button" class="admin-modal__close" onclick="hideEditUserModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form method="POST" id="editUserForm" class="admin-form">
                @csrf
                @method('PUT')
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Họ và tên</label>
                    <input type="text" name="name" id="edit_name" required 
                           class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Email</label>
                    <input type="email" name="email" id="edit_email" required 
                           class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Mật khẩu mới (để trống nếu không thay đổi)</label>
                    <input type="password" name="password" id="edit_password" 
                           class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Phân quyền</label>
                    <select name="role" id="edit_role" required class="admin-form__select">
                        <option value="">-- Chọn phân quyền --</option>
                        <option value="0">Admin</option>
                        <option value="1">Ban ISO</option>
                        <option value="2">Cơ quan/Phân xưởng</option>
                        <option value="3">Người sử dụng</option>
                    </select>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Cơ quan/Phòng ban</label>
                    <input type="text" name="department" id="edit_department" 
                           class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">Tài khoản cấp trên</label>
                    <select name="parent_id" id="edit_parent_id" class="admin-form__select">
                        <option value="">-- Không có --</option>
                        @foreach($users->where('role', '<', 3) as $parentUser)
                        <option value="{{ $parentUser->id }}">{{ $parentUser->name }} ({{ $parentUser->getRoleName() }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form__group">
                    <label class="admin-form__label">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        Tài khoản hoạt động
                    </label>
                </div>

                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="hideEditUserModal()">Hủy</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal" class="admin-modal" style="display: none;">
    <div class="admin-modal__overlay"></div>
    <div class="admin-modal__container">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận xóa tài khoản</h3>
            <button type="button" class="admin-modal__close" onclick="hideDeleteUserModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <p>Bạn có chắc chắn muốn xóa tài khoản <strong id="deleteUserName"></strong>?</p>
            <p>Hành động này không thể hoàn tác.</p>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="hideDeleteUserModal()">Hủy</button>
                <form method="POST" id="deleteUserForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--secondary" style="background: #dc3545;">Xóa</button>
                </form>
            </div>
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

// Edit User Functions
function showEditUserModal() {
    document.getElementById('editUserModal').style.display = 'flex';
}

function hideEditUserModal() {
    document.getElementById('editUserModal').style.display = 'none';
}

function editUser(userId) {
    // Fetch user data via AJAX
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                
                // Populate form fields
                document.getElementById('edit_name').value = user.name;
                document.getElementById('edit_email').value = user.email;
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_role').value = user.role;
                document.getElementById('edit_department').value = user.department || '';
                document.getElementById('edit_parent_id').value = user.parent_id || '';
                document.getElementById('edit_is_active').checked = user.is_active;
                
                // Set form action
                document.getElementById('editUserForm').action = `/admin/users/${userId}`;
                
                // Show modal
                showEditUserModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Có lỗi xảy ra khi tải thông tin tài khoản');
        });
}

// Delete User Functions
function showDeleteUserModal() {
    document.getElementById('deleteUserModal').style.display = 'flex';
}

function hideDeleteUserModal() {
    document.getElementById('deleteUserModal').style.display = 'none';
}

function deleteUser(userId, userName) {
    // Set user name in modal
    document.getElementById('deleteUserName').textContent = userName;
    
    // Set form action
    document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
    
    // Show modal
    showDeleteUserModal();
}

// Show modal if there are validation errors
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    showCreateUserModal();
});
@endif
</script>
@endsection