@extends('layouts.auth')

@section('title', 'Đăng nhập - Hệ thống ISO')
@section('card-title', 'ĐĂNG NHẬP')

@section('content')
<form method="POST" action="{{ route('auth.login') }}" class="auth-form">
    @csrf
    
    <div class="auth-form__group">
        <label for="username" class="auth-form__label">Tên đăng nhập</label>
        <input id="username" 
               type="text"
               name="username" 
               value="{{ old('username') }}" 
               placeholder="Nhập tên đăng nhập của bạn"
               autofocus 
               autocomplete="username"
               class="auth-form__input @error('username') auth-form__input--error @enderror">
        @error('username')
            <span class="auth-form__error">{{ $message }}</span>
        @enderror
    </div>

    <div class="auth-form__group">
        <label for="password" class="auth-form__label">Mật khẩu</label>
        <input id="password" 
               type="password" 
               name="password" 
               placeholder="Nhập mật khẩu của bạn"
               autocomplete="current-password"
               class="auth-form__input @error('password') auth-form__input--error @enderror">
        @error('password')
            <span class="auth-form__error">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="submit" class="auth-form__button">
        ĐĂNG NHẬP
    </button>
</form>
@endsection