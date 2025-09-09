@extends('layouts.admin')

@section('title', 'Chỉnh sửa tài khoản - Admin')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Chỉnh sửa tài khoản</h1>
            <p class="admin-page__subtitle">Cập nhật thông tin tài khoản: {{ $user->name }}</p>
        </div>
        <div class="admin-page__actions">
            <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="admin-form__input @error('name') admin-form__input--error @enderror">
                    @error('name')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Tên đăng nhập</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="admin-form__input @error('username') admin-form__input--error @enderror">
                    @error('username')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="admin-form__input @error('email') admin-form__input--error @enderror">
                    @error('email')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label">Mật khẩu mới (để trống nếu không thay đổi)</label>
                    <input type="password" name="password" 
                           class="admin-form__input @error('password') admin-form__input--error @enderror">
                    @error('password')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Phân quyền</label>
                    <select name="role" id="role"
                            class="admin-form__select @error('role') admin-form__select--error @enderror" 
                            onchange="toggleDepartmentField()">
                        <option value="">-- Chọn phân quyền --</option>
                        <option value="0" {{ old('role', $user->role) == '0' ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ old('role', $user->role) == '1' ? 'selected' : '' }}>Ban ISO</option>
                        <option value="2" {{ old('role', $user->role) == '2' ? 'selected' : '' }}>Cơ quan - Phân xưởng</option>
                        <option value="3" {{ old('role', $user->role) == '3' ? 'selected' : '' }}>Người sử dụng</option>
                    </select>
                    @error('role')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row" id="department_group" style="display: none;">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Phân xưởng</label>
                    <select name="department_id" id="department_id" 
                            class="admin-form__select @error('department_id') admin-form__select--error @enderror">
                        <option value="">-- Chọn phân xưởng --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <div class="admin-form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form__row">
                <div class="admin-form__group">
                    <label class="admin-form__label">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        Tài khoản hoạt động
                    </label>
                </div>
            </div>

            <div class="admin-form__actions">
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--secondary">Hủy</a>
                <button type="submit" class="admin-btn admin-btn--warning">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle department field based on role
function toggleDepartmentField() {
    const roleSelect = document.getElementById('role');
    const departmentGroup = document.getElementById('department_group');
    const departmentSelect = document.getElementById('department_id');
    
    if (roleSelect && departmentGroup && departmentSelect) {
        const role = roleSelect.value;
        
        // Show department field for roles 2 (Cơ quan - Phân xưởng) and 3 (Người sử dụng)
        if (role == '2' || role == '3') {
            departmentGroup.style.display = 'block';
        } else {
            departmentGroup.style.display = 'none';
            departmentSelect.value = ''; // Clear selection when hidden
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleDepartmentField();
});
</script>
@endsection