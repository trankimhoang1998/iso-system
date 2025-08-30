@extends('layouts.level1')

@section('title', 'Quản lý quyền tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <div>
            <h1 class="level1-page__title">Quản lý quyền tài liệu</h1>
            <p class="level1-page__subtitle">Cấp quyền truy cập tài liệu cho các đơn vị cấp 2</p>
        </div>
        <div class="level1-page__actions">
            <a href="{{ route('level1.documents') }}" class="level1-btn level1-btn--secondary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level1-filter">
        <form method="GET" action="{{ route('level1.documents.permissions') }}" class="level1-filter__form">
            <div class="level1-filter__row">
                <div class="level1-filter__group">
                    <label class="level1-filter__label">Tìm kiếm tài liệu</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="level1-filter__input">
                </div>
                <div class="level1-filter__actions">
                    <button type="submit" class="level1-btn level1-btn--primary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level1.documents.permissions') }}" class="level1-btn level1-btn--secondary">
                        <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($documents->count() > 0)
    <div class="level1-permissions">
        @foreach($documents as $document)
        <div class="level1-permission-card">
            <div class="level1-permission-card__header">
                <div class="level1-permission-card__title">
                    <h3>{{ $document->title }}</h3>
                    <div class="level1-permission-card__meta">
                        <span class="level1-badge level1-badge--{{ $document->document_type }}">
                            {{ $document->getDocumentTypeName() }}
                        </span>
                        <span class="level1-text--muted">{{ $document->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                <button type="button" class="level1-btn level1-btn--primary level1-btn--sm" 
                        onclick="showGrantModal({{ $document->id }}, '{{ $document->title }}')">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Cấp quyền
                </button>
            </div>

            @if($document->description)
            <div class="level1-permission-card__description">
                {{ $document->description }}
            </div>
            @endif

            <div class="level1-permission-card__permissions">
                @if($document->permissions->count() > 0)
                <h4 class="level1-permission-card__subtitle">Đơn vị có quyền truy cập:</h4>
                <div class="level1-permission-list">
                    @foreach($document->permissions as $permission)
                    <div class="level1-permission-item">
                        <div class="level1-permission-item__info">
                            <div class="level1-permission-item__name">
                                {{ $permission->user->name }}
                            </div>
                            <div class="level1-permission-item__email">
                                {{ $permission->user->email }}
                            </div>
                            <div class="level1-permission-item__access">
                                @if($permission->can_view)
                                <span class="level1-badge level1-badge--success level1-badge--sm">Xem</span>
                                @endif
                                @if($permission->can_download)
                                <span class="level1-badge level1-badge--info level1-badge--sm">Tải xuống</span>
                                @endif
                            </div>
                        </div>
                        <div class="level1-permission-item__actions">
                            <button type="button" class="level1-btn level1-btn--danger level1-btn--sm" 
                                    onclick="showRevokeModal({{ $document->id }}, {{ $permission->user->id }}, '{{ $permission->user->name }}', '{{ $document->title }}')">
                                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Thu hồi
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="level1-permission-empty">
                    <svg class="level1-permission-empty__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <p>Chưa có đơn vị nào được cấp quyền</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="level1-pagination-wrapper">
        {{ $documents->links('components.level1-pagination') }}
    </div>
    @else
    <div class="level1-documents__empty">
        <div class="level1-empty-state">
            <svg class="level1-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="level1-empty-state__title">Chưa có tài liệu nào để quản lý quyền</h3>
            <p class="level1-empty-state__description">Tạo tài liệu mới để bắt đầu quản lý quyền truy cập</p>
            <a href="{{ route('level1.documents') }}" class="level1-empty-state__btn">
                Quay lại danh sách tài liệu
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Grant Permission Modal -->
<div id="grantModal" class="level1-modal" style="display: none;">
    <div class="level1-modal__backdrop" onclick="hideGrantModal()"></div>
    <div class="level1-modal__content">
        <div class="level1-modal__header">
            <h2 class="level1-modal__title">Cấp quyền truy cập tài liệu</h2>
            <button type="button" class="level1-modal__close" onclick="hideGrantModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="grantForm" method="POST" class="level1-form">
            @csrf
            <div class="level1-modal__body">
                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <div class="level1-alert level1-alert--info">
                            <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <strong>Tài liệu:</strong> <span id="grantDocumentTitle"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label level1-form__label--required">Chọn đơn vị</label>
                        <select name="user_id" required class="level1-form__select">
                            <option value="">Chọn đơn vị cấp 2</option>
                            @foreach($level2Users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="level1-form__row">
                    <div class="level1-form__group level1-form__group--full">
                        <label class="level1-form__label">Quyền truy cập</label>
                        <div class="level1-checkbox-group">
                            <div class="level1-checkbox">
                                <input type="checkbox" name="can_view" value="1" id="canView" class="level1-checkbox__input" checked>
                                <label for="canView" class="level1-checkbox__label">Được phép xem tài liệu</label>
                            </div>
                            <div class="level1-checkbox">
                                <input type="checkbox" name="can_download" value="1" id="canDownload" class="level1-checkbox__input" checked>
                                <label for="canDownload" class="level1-checkbox__label">Được phép tải xuống tài liệu</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="level1-modal__footer">
                <button type="button" class="level1-btn level1-btn--secondary" onclick="hideGrantModal()">Hủy</button>
                <button type="submit" class="level1-btn level1-btn--primary">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Cấp quyền
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Revoke Permission Modal -->
<div id="revokeModal" class="level1-modal" style="display: none;">
    <div class="level1-modal__backdrop" onclick="hideRevokeModal()"></div>
    <div class="level1-modal__content">
        <div class="level1-modal__header">
            <h2 class="level1-modal__title">Thu hồi quyền truy cập</h2>
            <button type="button" class="level1-modal__close" onclick="hideRevokeModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="level1-modal__body">
            <div class="level1-alert level1-alert--warning">
                <svg class="level1-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div>
                    <p><strong>Bạn có chắc chắn muốn thu hồi quyền truy cập?</strong></p>
                    <p>Đơn vị: <strong id="revokeUserName"></strong></p>
                    <p>Tài liệu: <strong id="revokeDocumentTitle"></strong></p>
                    <p class="level1-text--muted">Hành động này không thể hoàn tác.</p>
                </div>
            </div>
        </div>
        <div class="level1-modal__footer">
            <button type="button" class="level1-btn level1-btn--secondary" onclick="hideRevokeModal()">Hủy</button>
            <form id="revokeForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="level1-btn level1-btn--danger">
                    <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Thu hồi quyền
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function showGrantModal(documentId, documentTitle) {
    document.getElementById('grantDocumentTitle').textContent = documentTitle;
    document.getElementById('grantForm').action = `/level1/documents/${documentId}/grant-permission`;
    document.getElementById('grantModal').style.display = 'flex';
}

function hideGrantModal() {
    document.getElementById('grantModal').style.display = 'none';
    document.getElementById('grantForm').reset();
}

function showRevokeModal(documentId, userId, userName, documentTitle) {
    document.getElementById('revokeUserName').textContent = userName;
    document.getElementById('revokeDocumentTitle').textContent = documentTitle;
    document.getElementById('revokeForm').action = `/level1/documents/${documentId}/revoke-permission/${userId}`;
    document.getElementById('revokeModal').style.display = 'flex';
}

function hideRevokeModal() {
    document.getElementById('revokeModal').style.display = 'none';
}

// Auto-focus document search on specific document
@if(request('document_id'))
document.addEventListener('DOMContentLoaded', function() {
    const documentCard = document.querySelector('[data-document-id="{{ request('document_id') }}"]');
    if (documentCard) {
        documentCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        documentCard.classList.add('level1-permission-card--highlighted');
    }
});
@endif
</script>

<style>
.level1-permission-card--highlighted {
    box-shadow: 0 0 0 2px #007bff !important;
    background-color: rgba(0, 123, 255, 0.05) !important;
}
</style>
@endsection