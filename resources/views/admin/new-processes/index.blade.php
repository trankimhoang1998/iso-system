@extends('layouts.admin')

@section('title', 'Quản lý quy trình mới')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div class="admin-page__title-section">
            <h1 class="admin-page__title">Quản lý quy trình mới</h1>
            <p class="admin-page__subtitle">
                Quản lý quy trình mới và cập nhật hệ thống
            </p>
        </div>
        @if(in_array(auth()->user()->role, [0, 1]))
        <div class="admin-page__actions">
            <a href="{{ route('admin.new-processes.create') }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Thêm quy trình mới
            </a>
        </div>
        @endif
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    @if(auth()->user()->role == 0)
                    <th class="admin-table__header" style="width: 40px;">≡</th>
                    @endif
                    <th class="admin-table__header admin-table__header--date">Thời gian</th>
                    <th class="admin-table__header admin-table__header--summary">Tiêu đề quy trình</th>
                    <th class="admin-table__header admin-table__header--document">Link tài liệu</th>
                    <th class="admin-table__header admin-table__header--actions">Hành động</th>
                </tr>
            </thead>
            <tbody class="admin-table__body" id="new-processes-table">
                @forelse($newProcesses as $newProcess)
                <tr class="admin-table__row" data-id="{{ $newProcess->id }}">
                    @if(auth()->user()->role == 0)
                    <td class="admin-table__cell drag-handle" style="cursor: grab; text-align: center;">≡</td>
                    @endif
                    <td class="admin-table__cell admin-table__cell--date">{{ $newProcess->issue_date->format('d/m/Y') }}</td>
                    <td class="admin-table__cell admin-table__cell--summary">{{ $newProcess->title }}</td>
                    <td class="admin-table__cell admin-table__cell--document">
                        @if($newProcess->document_link)
                        <a href="{{ $newProcess->document_link }}" target="_blank" class="admin-link">
                            {{ $newProcess->document_link }}
                        </a>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="admin-table__cell admin-table__cell--actions">
                        <div class="admin-table__actions">
                            @if(in_array(auth()->user()->role, [0, 1]))
                            <div class="admin-table__actions-row">
                                <a href="{{ route('admin.new-processes.edit', $newProcess) }}" 
                                   class="admin-table__action-btn admin-table__action-btn--edit" 
                                   title="Chỉnh sửa">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button class="admin-table__action-btn admin-table__action-btn--delete" 
                                        title="Xóa"
                                        onclick="openDeleteModal({{ $newProcess->id }}, '{{ addslashes($newProcess->title) }}')">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row admin-table__row--empty">
                    <td colspan="{{ auth()->user()->role == 0 ? '5' : '4' }}" class="admin-table__empty">
                        <div class="admin-empty-state">
                            <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="admin-empty-state__title">Chưa có quy trình mới nào</h3>
                            <p class="admin-empty-state__description">
                                @if(in_array(auth()->user()->role, [0, 1]))
                                    Tạo quy trình mới đầu tiên
                                @else
                                    Hiện tại chưa có quy trình mới nào
                                @endif
                            </p>
                            @if(in_array(auth()->user()->role, [0, 1]))
                            <a href="{{ route('admin.new-processes.create') }}" class="admin-empty-state__btn">
                                Thêm quy trình mới đầu tiên
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete New Process Modal -->
<div id="deleteModal" class="admin-modal">
    <div class="admin-modal__content">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận xóa quy trình mới</h3>
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
                    <p class="admin-modal__message-title">Bạn có chắc chắn muốn xóa quy trình mới?</p>
                    <p class="admin-modal__message-text">Quy trình mới <strong id="deleteItemName"></strong> sẽ bị xóa vĩnh viễn. Hành động này không thể hoàn tác.</p>
                </div>
            </div>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="closeDeleteModal()">Hủy</button>
                <form method="POST" id="deleteForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger">Xóa quy trình mới</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
@if(auth()->user()->role == 0)
// Initialize Sortable for drag and drop
Sortable.create(document.getElementById('new-processes-table'), {
    handle: '.drag-handle',
    animation: 150,
    ghostClass: 'admin-table__row--dragging',
    onEnd: function(evt) {
        const rows = document.querySelectorAll('#new-processes-table .admin-table__row');
        const items = [];
        
        rows.forEach((row, index) => {
            if (row.dataset.id) {
                items.push({
                    id: parseInt(row.dataset.id),
                    order: index
                });
            }
        });
        
        // Send AJAX request to update order
        fetch('/new-processes/reorder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                items: items
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Order updated successfully');
            }
        })
        .catch(error => {
            console.error('Error updating order:', error);
        });
    }
});
@endif

function openDeleteModal(id, title) {
    document.getElementById('deleteItemName').textContent = title;
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = '/new-processes/' + id;
    
    const modal = document.getElementById('deleteModal');
    modal.classList.add('admin-modal--active');
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