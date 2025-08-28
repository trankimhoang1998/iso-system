@extends('layouts.level1')

@section('title', 'Quản lý tài liệu - Ban ISO')

@section('content')
<div class="level1-page">
    <div class="level1-page__header">
        <h1 class="level1-page__title">Quản lý tài liệu</h1>
        <div class="level1-page__actions">
            <button type="button" class="level1-btn level1-btn--primary">
                <svg class="level1-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Tải lên tài liệu
            </button>
        </div>
    </div>

    <div class="level1-documents">
        <div class="level1-documents__empty">
            <div class="level1-empty-state">
                <svg class="level1-empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="level1-empty-state__title">Chưa có tài liệu nào</h3>
                <p class="level1-empty-state__description">Bắt đầu bằng cách tải lên tài liệu đầu tiên của bạn</p>
                <button class="level1-empty-state__btn">
                    Tải lên tài liệu
                </button>
            </div>
        </div>
    </div>
</div>
@endsection