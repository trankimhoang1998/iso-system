@extends('layouts.level3')

@section('title', 'Chỉnh sửa đề xuất: ' . $proposal->title . ' - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <div>
            <h1 class="level3-page__title">Chỉnh sửa đề xuất</h1>
            <p class="level3-page__subtitle">Cập nhật thông tin đề xuất sửa đổi tài liệu</p>
        </div>
        <div class="level3-page__actions">
            <a href="{{ route('level3.proposals') }}" class="level3-btn level3-btn--secondary">
                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
        </div>
    </div>
    @if($proposal->status !== 'pending')
    <div class="level3-alert level3-alert--warning">
        <svg class="level3-alert__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <div>
            <strong>Không thể chỉnh sửa!</strong> Đề xuất này đã được xử lý và không thể chỉnh sửa.
        </div>
    </div>
    @endif

    <div class="level3-card">
        <form method="POST" action="{{ route('level3.proposals.update', $proposal) }}" class="level3-form">
            @csrf
            @method('PUT')
            
            <div class="level3-form__section">
                <h3 class="level3-form__section-title">Thông tin cơ bản</h3>
                
                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Tài liệu</label>
                        <select name="document_id" required class="level3-form__select @error('document_id') level3-form__select--error @enderror">
                            <option value="">Chọn tài liệu để đề xuất</option>
                            @foreach($availableDocuments as $document)
                            <option value="{{ $document->id }}" {{ $document->id == $proposal->document_id ? 'selected' : '' }}>
                                {{ $document->title }} (v{{ $document->version }})
                            </option>
                            @endforeach
                        </select>
                        @error('document_id')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Gửi đến (Cấp 2)</label>
                        <select name="level2_user_id" required class="level3-form__select @error('level2_user_id') level3-form__select--error @enderror">
                            <option value="">Chọn người nhận</option>
                            @foreach($level2Users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $proposal->level2_user_id ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->department ?? 'Cơ quan - Phân xưởng' }}
                            </option>
                            @endforeach
                        </select>
                        @error('level2_user_id')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Tiêu đề đề xuất</label>
                        <input type="text" name="title" required 
                               class="level3-form__input @error('title') level3-form__input--error @enderror" 
                               value="{{ old('title', $proposal->title) }}"
                               placeholder="Nhập tiêu đề cho đề xuất của bạn">
                        @error('title')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--half">
                        <label class="level3-form__label level3-form__label--required">Loại đề xuất</label>
                        <select name="proposal_type" required class="level3-form__select @error('proposal_type') level3-form__select--error @enderror">
                            <option value="">Chọn loại đề xuất</option>
                            <option value="content_correction" {{ old('proposal_type', $proposal->proposal_type) == 'content_correction' ? 'selected' : '' }}>
                                Sửa nội dung
                            </option>
                            <option value="format_improvement" {{ old('proposal_type', $proposal->proposal_type) == 'format_improvement' ? 'selected' : '' }}>
                                Cải thiện định dạng
                            </option>
                            <option value="additional_info" {{ old('proposal_type', $proposal->proposal_type) == 'additional_info' ? 'selected' : '' }}>
                                Bổ sung thông tin
                            </option>
                            <option value="process_optimization" {{ old('proposal_type', $proposal->proposal_type) == 'process_optimization' ? 'selected' : '' }}>
                                Tối ưu quy trình
                            </option>
                            <option value="other" {{ old('proposal_type', $proposal->proposal_type) == 'other' ? 'selected' : '' }}>
                                Khác
                            </option>
                        </select>
                        @error('proposal_type')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="level3-form__group level3-form__group--half">
                        <label class="level3-form__label level3-form__label--required">Mức độ ưu tiên</label>
                        <select name="priority" required class="level3-form__select @error('priority') level3-form__select--error @enderror">
                            <option value="">Chọn mức độ</option>
                            <option value="low" {{ old('priority', $proposal->priority) == 'low' ? 'selected' : '' }}>
                                Thấp
                            </option>
                            <option value="medium" {{ old('priority', $proposal->priority) == 'medium' ? 'selected' : '' }}>
                                Trung bình
                            </option>
                            <option value="high" {{ old('priority', $proposal->priority) == 'high' ? 'selected' : '' }}>
                                Cao
                            </option>
                            <option value="urgent" {{ old('priority', $proposal->priority) == 'urgent' ? 'selected' : '' }}>
                                Khẩn cấp
                            </option>
                        </select>
                        @error('priority')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="level3-form__section">
                <h3 class="level3-form__section-title">Chi tiết đề xuất</h3>
                
                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label level3-form__label--required">Mô tả chi tiết</label>
                        <textarea name="description" rows="4" required 
                                  class="level3-form__textarea @error('description') level3-form__textarea--error @enderror" 
                                  placeholder="Mô tả chi tiết về đề xuất sửa đổi của bạn...">{{ old('description', $proposal->description) }}</textarea>
                        @error('description')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label">Nội dung đề xuất (nếu có)</label>
                        <textarea name="proposed_content" rows="3" 
                                  class="level3-form__textarea @error('proposed_content') level3-form__textarea--error @enderror" 
                                  placeholder="Nội dung cụ thể bạn đề xuất thay đổi...">{{ old('proposed_content', $proposal->proposed_content) }}</textarea>
                        @error('proposed_content')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="level3-form__row">
                    <div class="level3-form__group level3-form__group--full">
                        <label class="level3-form__label">Lý do sửa đổi</label>
                        <textarea name="reason" rows="2" 
                                  class="level3-form__textarea @error('reason') level3-form__textarea--error @enderror" 
                                  placeholder="Lý do tại sao cần sửa đổi...">{{ old('reason', $proposal->reason) }}</textarea>
                        @error('reason')
                        <span class="level3-form__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="level3-form__actions">
                <button type="submit" class="level3-btn level3-btn--primary">
                    <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Cập nhật đề xuất
                </button>
                <a href="{{ route('level3.proposals') }}" class="level3-btn level3-btn--secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>
@endsection