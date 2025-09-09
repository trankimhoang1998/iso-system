@extends('layouts.admin')

@section('title', 'Tài liệu hệ thống ISO')

@section('content')
<div class="admin-page">
    <div class="admin-page__header">
        <div>
            <p class="admin-page__subtitle">Quản lý các tài liệu của Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015, bao gồm: Sổ tay chất lượng, các Quy trình hệ thống và các Quy trình tác nghiệp.</p>
        </div>
        @if(in_array(auth()->user()->role, [0, 1]))
        <div class="admin-page__actions">
            <a href="{{ isset($category) ? route('admin.iso-system-documents.category.create', $category) : route('admin.iso-system-documents.create') }}" class="admin-btn admin-btn--primary">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Thêm văn bản
            </a>
        </div>
        @endif
    </div>

    <!-- Filter Form -->
    <div class="admin-filter">
        <form method="GET" action="{{ isset($category) ? route('admin.iso-system-documents.category', $category) : route('admin.iso-system-documents.index') }}" class="admin-filter__form">
            <div class="admin-filter__row">
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Ký hiệu hoặc tên tài liệu..." class="admin-filter__input">
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Thời gian ban hành</label>
                    <div class="admin-filter__date-range">
                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                               class="admin-form__input" placeholder="Từ ngày">
                        <span class="admin-filter__date-separator">đến</span>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                               class="admin-form__input" placeholder="Đến ngày">
                    </div>
                </div>
                <div class="admin-filter__group">
                    <label class="admin-filter__label">Đơn vị áp dụng</label>
                    <select name="department_id" id="filter_department" class="admin-form__select select2">
                        <option value="">Tất cả</option>
                        @foreach($departments ?? [] as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="admin-filter__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ isset($category) ? route('admin.iso-system-documents.category', $category) : route('admin.iso-system-documents.index') }}" class="admin-btn admin-btn--secondary">
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
                    <th class="admin-table__header admin-table__header--symbol">Ký hiệu</th>
                    <th class="admin-table__header admin-table__header--title">Tên tài liệu</th>
                    <th class="admin-table__header admin-table__header--date">Thời gian </br> ban hành</th>
                    <th class="admin-table__header admin-table__header--date">Cập nhật </br>  mới nhất</th>
                    <th class="admin-table__header admin-table__header--department">Đơn vị áp dụng</th>
                    <th class="admin-table__header admin-table__header--actions">Hành động</th>
                </tr>
            </thead>
            <tbody class="admin-table__body">
                @forelse($documents as $document)
                <tr class="admin-table__row">
                    <td class="admin-table__cell admin-table__cell--symbol">{{ $document->symbol ?: '_' }}</td>
                    <td class="admin-table__cell admin-table__cell--title">{{ $document->title }}</td>
                    <td class="admin-table__cell admin-table__cell--date">{{ $document->issued_date ? \Carbon\Carbon::parse($document->issued_date)->format('d/m/Y') : '_' }}</td>
                    <td class="admin-table__cell admin-table__cell--date">{{ $document->latest_update ? \Carbon\Carbon::parse($document->latest_update)->format('d/m/Y') : '_' }}</td>
                    <td class="admin-table__cell admin-table__cell--department">
                        @if($document->departments && $document->departments->count() > 0)
                            <div class="department-tags">
                                @foreach($document->departments as $department)
                                    <span class="department-tag">{{ $department->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="department-empty">N/A</span>
                        @endif
                    </td>
                    <td class="admin-table__cell admin-table__cell--actions">
                        <div class="admin-table__actions">
                            <div class="admin-table__actions-row">
                                @if($document->pdf_file_path)
                                <a href="{{ route('admin.iso-system-documents.view', [$document, 'pdf']) }}" 
                                   class="admin-table__action-btn admin-table__action-btn--view" 
                                   title="Xem PDF" target="_blank">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @endif
                                @if($document->pdf_file_path)
                                <a href="{{ route('admin.iso-system-documents.download', [$document, 'pdf']) }}"
                                   class="admin-table__action-btn admin-table__action-btn--download" 
                                   title="Tải PDF">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="admin-file-type-label">PDF</span>
                                </a>
                                @endif
                                @if($document->word_file_path)
                                <a href="{{ route('admin.iso-system-documents.download', [$document, 'word']) }}"
                                   class="admin-table__action-btn admin-table__action-btn--download admin-table__action-btn--word" 
                                   title="Tải Word">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="admin-file-type-label">Word</span>
                                </a>
                                @endif
                            </div>
                            @if(in_array(auth()->user()->role, [0, 1]))
                            <div class="admin-table__actions-row">
                                <a href="{{ isset($category) ? route('admin.iso-system-documents.category.edit', [$category, $document]) : route('admin.iso-system-documents.edit', $document) }}" 
                                   class="admin-table__action-btn admin-table__action-btn--edit" 
                                   title="Chỉnh sửa">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button class="admin-table__action-btn admin-table__action-btn--delete" 
                                        title="Xóa"
                                        onclick="openDeleteModal({{ $document->id }}, '{{ $document->title }}')">
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
                <tr>
                    <td colspan="6" class="admin-table__empty">
                        <div class="admin-empty-state">
                            <svg class="admin-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="admin-empty-state__title">
                                @if(request()->routeIs('admin.iso-system-documents.index'))
                                    Đồng chí hãy chọn danh mục bên trái để xem các hồ sơ, văn bản liên quan
                                @else
                                    Chưa có văn bản nào
                                @endif
                            </h3>
                            <p class="admin-empty-state__description">
                                @if(in_array(auth()->user()->role, [0, 1]))
                                    Tạo văn bản hệ thống ISO đầu tiên
                                @else
                                    Hiện tại chưa có văn bản hệ thống ISO nào
                                @endif
                            </p>
                            @if(in_array(auth()->user()->role, [0, 1]))
                            <a href="{{ isset($category) ? route('admin.iso-system-documents.category.create', $category) : route('admin.iso-system-documents.create') }}" class="admin-empty-state__btn">
                                Thêm văn bản đầu tiên
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($documents->hasPages())
        {{ $documents->links('components.pagination') }}
    @endif
</div>

<!-- Delete Document Modal -->
<div id="deleteModal" class="admin-modal">
    <div class="admin-modal__content">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">Xác nhận xóa văn bản</h3>
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
                    <p class="admin-modal__message-title">Bạn có chắc chắn muốn xóa văn bản?</p>
                    <p class="admin-modal__message-text">Văn bản <strong id="deleteDocumentName"></strong> sẽ bị xóa vĩnh viễn. Hành động này không thể hoàn tác.</p>
                </div>
            </div>
            
            <div class="admin-form__actions">
                <button type="button" class="admin-btn admin-btn--secondary" onclick="closeDeleteModal()">Hủy</button>
                <form method="POST" id="deleteForm" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger">Xóa văn bản</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(documentId, documentTitle) {
    document.getElementById('deleteDocumentName').textContent = documentTitle;
    const currentCategoryId = '{{ isset($category) ? $category->id : request("category_id") }}';
    let deleteUrl = `/iso-system-documents/${documentId}`;
    if (currentCategoryId) {
        deleteUrl += `?redirect_category=${currentCategoryId}`;
    }
    document.getElementById('deleteForm').action = deleteUrl;
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

// Initialize Select2 for filter dropdowns
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && $.fn.select2) {
        // Department dropdown
        $('#filter_department').select2({
            placeholder: 'Tất cả',
            allowClear: true,
            width: '100%',
            dropdownCssClass: 'select2-dropdown-small',
            containerCssClass: 'select2-container-small'
        });
    }
});
</script>
@endsection