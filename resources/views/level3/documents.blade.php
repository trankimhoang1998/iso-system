@extends('layouts.level3')

@section('title', 'Tài liệu có thể truy cập - Người sử dụng')

@section('content')
<div class="level3-page">
    <div class="level3-page__header">
        <h1 class="level3-page__title">Tài liệu có thể truy cập</h1>
        <p class="level3-page__subtitle">Các tài liệu mà bạn được phép xem và tải xuống</p>
    </div>

    <div class="level3-documents">
        <div class="level3-documents__empty">
            <div class="level3-empty-state">
                <svg class="level3-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="level3-empty-state__title">Chưa có tài liệu nào</h3>
                <p class="level3-empty-state__description">Hiện tại chưa có tài liệu nào được chia sẻ cho bạn</p>
            </div>
        </div>
    </div>
</div>
@endsection