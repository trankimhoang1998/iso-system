@extends('layouts.level3')

@section('title', 'Đề xuất của tôi - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <div>
            <h1 class="level3-page__title">Đề xuất của tôi</h1>
            <p class="level3-page__subtitle">Các đề xuất sửa đổi tài liệu được gửi đến cấp 2</p>
        </div>
        <div class="level3-page__actions">
            <button type="button" class="level3-btn level3-btn--primary" onclick="showCreateModal()">
                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tạo đề xuất mới
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="level3-filter">
        <form method="GET" action="{{ route('level3.proposals') }}" class="level3-filter__form">
            <div class="level3-filter__row">
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Tiêu đề hoặc mô tả..." class="level3-filter__input">
                </div>
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Trạng thái</label>
                    <select name="status" class="level3-filter__select">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Đang xem xét</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                </div>
                <div class="level3-filter__group">
                    <label class="level3-filter__label">Loại đề xuất</label>
                    <select name="proposal_type" class="level3-filter__select">
                        <option value="">Tất cả</option>
                        <option value="content_correction" {{ request('proposal_type') == 'content_correction' ? 'selected' : '' }}>Sửa nội dung</option>
                        <option value="format_improvement" {{ request('proposal_type') == 'format_improvement' ? 'selected' : '' }}>Cải thiện định dạng</option>
                        <option value="additional_info" {{ request('proposal_type') == 'additional_info' ? 'selected' : '' }}>Bổ sung thông tin</option>
                        <option value="process_optimization" {{ request('proposal_type') == 'process_optimization' ? 'selected' : '' }}>Tối ưu quy trình</option>
                        <option value="other" {{ request('proposal_type') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="level3-filter__actions">
                    <button type="submit" class="level3-btn level3-btn--primary">
                        <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lọc
                    </button>
                    <a href="{{ route('level3.proposals') }}" class="level3-btn level3-btn--secondary">
                        <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if(isset($proposals) && $proposals->count() > 0)
    <div class="level3-table-container">
        <table class="level3-table">
            <thead class="level3-table__head">
                <tr>
                    <th class="level3-table__header">Đề xuất</th>
                    <th class="level3-table__header">Tài liệu</th>
                    <th class="level3-table__header">Loại</th>
                    <th class="level3-table__header">Ưu tiên</th>
                    <th class="level3-table__header">Gửi đến</th>
                    <th class="level3-table__header">Trạng thái</th>
                    <th class="level3-table__header">Ngày tạo</th>
                    <th class="level3-table__header">Thao tác</th>
                </tr>
            </thead>
            <tbody class="level3-table__body">
                @foreach($proposals as $proposal)
                <tr class="level3-table__row">
                    <td class="level3-table__cell">
                        <div class="level3-proposal-info">
                            <div class="level3-proposal-info__title">{{ $proposal->title }}</div>
                            <div class="level3-proposal-info__description">{{ Str::limit($proposal->description, 60) }}</div>
                        </div>
                    </td>
                    <td class="level3-table__cell">
                        <div class="level3-document-ref">
                            <div class="level3-document-ref__title">{{ $proposal->document->title }}</div>
                            <div class="level3-document-ref__version">v{{ $proposal->document->version }}</div>
                        </div>
                    </td>
                    <td class="level3-table__cell">
                        <span class="level3-badge level3-badge--{{ $proposal->proposal_type }}">
                            {{ $proposal->getProposalTypeName() }}
                        </span>
                    </td>
                    <td class="level3-table__cell">
                        <span class="level3-badge level3-badge--priority-{{ $proposal->priority }}">
                            {{ $proposal->getPriorityName() }}
                        </span>
                    </td>
                    <td class="level3-table__cell">
                        @if($proposal->level2_user_id)
                            @php
                                $level2User = \App\Models\User::find($proposal->level2_user_id);
                            @endphp
                            {{ $level2User ? $level2User->name : 'Cấp 2' }}
                        @else
                            Cấp 2
                        @endif
                    </td>
                    <td class="level3-table__cell">
                        <span class="level3-badge level3-badge--status-{{ $proposal->status }}">
                            {{ $proposal->getStatusName() }}
                        </span>
                    </td>
                    <td class="level3-table__cell">{{ $proposal->created_at->format('d/m/Y H:i') }}</td>
                    <td class="level3-table__cell">
                        <div class="level3-table__actions">
                            <a href="{{ route('level3.proposals.show', $proposal) }}" 
                               class="level3-btn level3-btn--sm level3-btn--info" 
                               title="Xem chi tiết">
                                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            
                            @if($proposal->status === 'pending')
                            <a href="{{ route('level3.proposals.edit', $proposal) }}" 
                               class="level3-btn level3-btn--sm level3-btn--warning" 
                               title="Chỉnh sửa">
                                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            
                            <form action="{{ route('level3.proposals.destroy', $proposal) }}" method="POST" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa đề xuất này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="level3-btn level3-btn--sm level3-btn--danger" 
                                        title="Xóa">
                                    <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="level3-pagination-wrapper">
        {{ $proposals->links('components.level3-pagination') }}
    </div>
    @else
    <div class="level3-proposals__empty">
        <div class="level3-empty-state">
            <svg class="level3-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
            <h3 class="level3-empty-state__title">Chưa có đề xuất nào</h3>
            <p class="level3-empty-state__description">Bắt đầu bằng cách tạo đề xuất đầu tiên của bạn để gửi đến cấp 2</p>
            <button class="level3-empty-state__btn" onclick="showCreateModal()">
                Tạo đề xuất mới
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Create Proposal Modal -->
<div id="createModal" class="level3-modal" style="display: none;">
    <div class="level3-modal__backdrop" onclick="hideCreateModal()"></div>
    <div class="level3-modal__content level3-modal__content--large">
        <div class="level3-modal__header">
            <h2 class="level3-modal__title">Tạo đề xuất mới</h2>
            <button type="button" class="level3-modal__close" onclick="hideCreateModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="createForm" method="POST" action="{{ route('level3.proposals.store') }}" class="level3-form">
            @csrf
            <div class="level3-modal__body">
                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Tài liệu</label>
                        <select name="document_id" required class="level3-form__select">
                            <option value="">Chọn tài liệu để đề xuất</option>
                            @foreach($availableDocuments as $document)
                            <option value="{{ $document->id }}">{{ $document->title }} (v{{ $document->version }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Gửi đến (Cấp 2)</label>
                        <select name="level2_user_id" required class="level3-form__select">
                            <option value="">Chọn người nhận</option>
                            @foreach($level2Users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->department ?? 'Cơ quan - Phân xưởng' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Tiêu đề đề xuất</label>
                        <input type="text" name="title" required class="level3-form__input" 
                               placeholder="Nhập tiêu đề cho đề xuất của bạn">
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group">
                        <label class="level3-form__label level3-form__label--required">Loại đề xuất</label>
                        <select name="proposal_type" required class="level3-form__select">
                            <option value="">Chọn loại đề xuất</option>
                            <option value="content_correction">Sửa nội dung</option>
                            <option value="format_improvement">Cải thiện định dạng</option>
                            <option value="additional_info">Bổ sung thông tin</option>
                            <option value="process_optimization">Tối ưu quy trình</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="level3-form__group">
                        <label class="level3-form__label level3-form__label--required">Mức độ ưu tiên</label>
                        <select name="priority" required class="level3-form__select">
                            <option value="">Chọn mức độ</option>
                            <option value="low">Thấp</option>
                            <option value="medium">Trung bình</option>
                            <option value="high">Cao</option>
                            <option value="urgent">Khẩn cấp</option>
                        </select>
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Mô tả chi tiết</label>
                        <textarea name="description" rows="4" required class="level3-form__textarea" 
                                  placeholder="Mô tả chi tiết về đề xuất sửa đổi của bạn..."></textarea>
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label">Nội dung đề xuất (nếu có)</label>
                        <textarea name="proposed_content" rows="3" class="level3-form__textarea" 
                                  placeholder="Nội dung cụ thể bạn đề xuất thay đổi..."></textarea>
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label">Lý do sửa đổi</label>
                        <textarea name="reason" rows="2" class="level3-form__textarea" 
                                  placeholder="Lý do tại sao cần sửa đổi..."></textarea>
                    </div>
                </div>
            </div>
            <div class="level3-modal__footer">
                <button type="button" class="level3-btn level3-btn--secondary" onclick="hideCreateModal()">Hủy</button>
                <button type="submit" class="level3-btn level3-btn--primary">
                    <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Gửi đề xuất
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showCreateModal() {
    document.getElementById('createModal').style.display = 'flex';
}

function hideCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.getElementById('createForm').reset();
}
</script>
@endsection