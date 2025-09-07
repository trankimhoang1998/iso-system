@extends('layouts.auth')

@section('title', 'Đăng nhập - Hệ thống ISO')
@section('card-title', 'ĐĂNG NHẬP')

@section('content')
<form method="POST" action="{{ route('auth.login') }}" class="auth-form">
    @csrf
    
    <div class="auth-form__group">
        <label for="email" class="auth-form__label">Email</label>
        <input id="email" 
               type="email"
               name="email" 
               value="{{ old('email') }}" 
               placeholder="Nhập địa chỉ email của bạn"
               autofocus 
               autocomplete="email"
               class="auth-form__input @error('email') auth-form__input--error @enderror">
        @error('email')
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