@extends('layouts.level2')

@section('title', 'Tài liệu được chia sẻ - Cơ quan/Phân xưởng')

@section('content')
<div class="level2-page">
    <div class="level2-page__header">
        <h1 class="level2-page__title">Tài liệu được chia sẻ</h1>
        <p class="level2-page__subtitle">Các tài liệu mà Ban ISO cho phép đơn vị truy cập</p>
    </div>

    <div class="level2-documents">
        <div class="level2-documents__empty">
            <div class="level2-empty-state">
                <svg class="level2-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="level2-empty-state__title">Chưa có tài liệu nào được chia sẻ</h3>
                <p class="level2-empty-state__description">Ban ISO chưa chia sẻ tài liệu nào cho đơn vị của bạn</p>
            </div>
        </div>
    </div>
</div>
@endsection