@extends('layouts.level3')

@section('title', 'Đề xuất của tôi - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <h1 class="level3-page__title">Đề xuất của tôi</h1>
        <div class="level3-page__actions">
            <button type="button" class="level3-btn level3-btn--primary">
                <svg class="level3-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tạo đề xuất mới
            </button>
        </div>
    </div>

    <div class="level3-proposals">
        <div class="level3-proposals__empty">
            <div class="level3-empty-state">
                <svg class="level3-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                <h3 class="level3-empty-state__title">Chưa có đề xuất nào</h3>
                <p class="level3-empty-state__description">Bắt đầu bằng cách tạo đề xuất đầu tiên của bạn</p>
                <button class="level3-empty-state__btn">
                    Tạo đề xuất mới
                </button>
            </div>
        </div>
    </div>
</div>
@endsection