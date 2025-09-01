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

    <div class="auth-form__group">
        <label for="role" class="auth-form__label">Quyền đăng nhập</label>
        <select id="role" 
                name="role" 
                required
                class="auth-form__select @error('role') auth-form__select--error @enderror">
            <option value="">-- Chọn quyền đăng nhập --</option>
            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Admin</option>
            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Ban ISO</option>
            <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Cơ quan - Phân xưởng</option>
            <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Người sử dụng</option>
        </select>
        @error('role')
            <div class="auth-form__error">{{ $message }}</div>
        @enderror
        <div class="auth-form__help">Chọn quyền tương ứng với tài khoản của bạn</div>
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