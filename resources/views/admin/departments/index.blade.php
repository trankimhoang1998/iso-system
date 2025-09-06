@extends('layouts.admin')

@section('title', 'Quản lý phân xưởng')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý phân xưởng</h1>
            <p class="admin-page__subtitle">Quản lý danh sách các phòng ban và phân xưởng</p>
        </div>
        <div class="admin-page__actions">
            <button type="button" 
                    class="admin-btn admin-btn--primary" 
                    onclick="openCreateModal()">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm phân xưởng
            </button>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead class="admin-table__head">
                    <tr class="admin-table__row">
                        <th class="admin-table__header">Tên phân xưởng</th>
                        <th class="admin-table__header admin-table__header--actions">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="admin-table__body">
                    @forelse($departments as $index => $department)
                        <tr class="admin-table__row">
                            <td class="admin-table__cell">
                                <div class="admin-table__main-content">
                                    <span class="admin-table__title">{{ $department->name }}</span>
                                </div>
                            </td>
                            <td class="admin-table__cell admin-table__cell--actions">
                                <div class="admin-table__actions">
                                    <button type="button" 
                                            class="admin-btn admin-btn--sm admin-btn--warning"
                                            onclick="openEditModal({{ $department->id }}, '{{ $department->name }}')"
                                            title="Chỉnh sửa">
                                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.departments.destroy', $department) }}" 
                                          method="POST" 
                                          class="admin-delete-form" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="admin-btn admin-btn--sm admin-btn--danger" 
                                                title="Xóa" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa phân xưởng này?')">
                                            <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="admin-table__row">
                            <td colspan="3" class="admin-table__cell admin-table__cell--empty">
                                <div class="admin-empty-state">
                                    <div class="admin-empty-state__icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="admin-empty-state__title">Chưa có phân xưởng nào</div>
                                    <div class="admin-empty-state__description">Bấm "Thêm phân xưởng" để tạo phân xưởng mới</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="admin-modal">
    <div class="admin-modal__content">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Thêm phân xưởng mới</h3>
            <button type="button" class="admin-modal__close" onclick="closeCreateModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form id="createForm" class="admin-form">
                @csrf
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Tên phân xưởng</label>
                    <input type="text" 
                           name="name" 
                           class="admin-form__input" 
                           placeholder="Nhập tên phân xưởng...">
                    <div class="admin-form__error" id="createNameError"></div>
                </div>
                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="closeCreateModal()">
                        Hủy
                    </button>
                    <button type="submit" class="admin-btn admin-btn--primary">
                        Tạo phân xưởng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="admin-modal">
    <div class="admin-modal__content">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Chỉnh sửa phân xưởng</h3>
            <button type="button" class="admin-modal__close" onclick="closeEditModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="admin-modal__body">
            <form id="editForm" class="admin-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">
                <div class="admin-form__group">
                    <label class="admin-form__label admin-form__label--required">Tên phân xưởng</label>
                    <input type="text" 
                           id="editName"
                           name="name" 
                           class="admin-form__input" 
                           placeholder="Nhập tên phân xưởng...">
                    <div class="admin-form__error" id="editNameError"></div>
                </div>
                <div class="admin-form__actions">
                    <button type="button" class="admin-btn admin-btn--secondary" onclick="closeEditModal()">
                        Hủy
                    </button>
                    <button type="submit" class="admin-btn admin-btn--warning">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Create Modal Functions
function openCreateModal() {
    document.getElementById('createModal').classList.add('admin-modal--active');
    document.getElementById('createForm').reset();
    clearErrors();
}

function closeCreateModal() {
    document.getElementById('createModal').classList.remove('admin-modal--active');
}

// Edit Modal Functions
function openEditModal(id, name) {
    document.getElementById('editModal').classList.add('admin-modal--active');
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    clearErrors();
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('admin-modal--active');
}

// Clear errors
function clearErrors() {
    document.querySelectorAll('.admin-form__error').forEach(error => error.textContent = '');
    document.querySelectorAll('.admin-form__input--error').forEach(input => 
        input.classList.remove('admin-form__input--error')
    );
}

// Handle Create Form
document.getElementById('createForm').addEventListener('submit', function(e) {
    e.preventDefault();
    clearErrors();
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.departments.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 422) {
            return response.json().then(data => Promise.reject(data));
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            closeCreateModal();
            location.reload();
        }
    })
    .catch(error => {
        if (error.errors) {
            // Handle validation errors
            for (let field in error.errors) {
                const errorElement = document.getElementById('create' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
                if (errorElement) {
                    errorElement.textContent = error.errors[field][0];
                    // Add error class to input
                    const inputElement = document.querySelector('#createForm input[name="' + field + '"]');
                    if (inputElement) {
                        inputElement.classList.add('admin-form__input--error');
                    }
                }
            }
        } else {
            toastr.error('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
});

// Handle Edit Form
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    clearErrors();
    
    const id = document.getElementById('editId').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    
    fetch('{{ route("admin.departments.update", "__ID__") }}'.replace('__ID__', id), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else if (response.status === 422) {
            return response.json().then(data => Promise.reject(data));
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            closeEditModal();
            location.reload();
        }
    })
    .catch(error => {
        if (error.errors) {
            // Handle validation errors
            for (let field in error.errors) {
                const errorElement = document.getElementById('edit' + field.charAt(0).toUpperCase() + field.slice(1) + 'Error');
                if (errorElement) {
                    errorElement.textContent = error.errors[field][0];
                    // Add error class to input
                    const inputElement = document.querySelector('#editForm input[name="' + field + '"]');
                    if (inputElement) {
                        inputElement.classList.add('admin-form__input--error');
                    }
                }
            }
        } else {
            toastr.error('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    });
});


// Close modal when clicking outside
window.addEventListener('click', function(e) {
    if (e.target.classList.contains('admin-modal')) {
        e.target.classList.remove('admin-modal--active');
    }
});
</script>
@endsection