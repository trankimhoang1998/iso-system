@extends('layouts.auth')

@section('title', 'Đăng nhập - Hệ thống ISO')
@section('card-title', 'ĐĂNG NHẬP HỆ THỐNG')
@section('role-badge', 'ISO SYSTEM')

@section('content')
<form method="POST" action="{{ route('auth.login') }}" class="auth-form">
    @csrf
    
    <div class="auth-form__group">
        <label for="email" class="auth-form__label">Email</label>
        <input id="email" 
               type="email" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autofocus 
               autocomplete="email"
               class="auth-form__input @error('email') auth-form__input--error @enderror">
        @error('email')
            <div class="auth-form__error">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-form__group">
        <label for="password" class="auth-form__label">Mật khẩu</label>
        <input id="password" 
               type="password" 
               name="password" 
               required 
               autocomplete="current-password"
               class="auth-form__input @error('password') auth-form__input--error @enderror">
        @error('password')
            <div class="auth-form__error">{{ $message }}</div>
        @enderror
    </div>


    @if ($errors->any())
        <div class="auth-form__errors">
            @foreach ($errors->all() as $error)
                <div class="auth-form__error">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <button type="submit" class="auth-form__button">
        ĐĂNG NHẬP
    </button>
</form>
@endsection