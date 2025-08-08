@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register-container">
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <h2 class="register-title">会員登録</h2>

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- メールアドレス --}}
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 確認用パスワード --}}
        <div class="form-group form-group--spaced">
            <label for="password_confirmation">確認用パスワード</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        {{-- 登録ボタン --}}
        <div class="form-group">
            <button type="submit" class="register-button">登録</button>
        </div>

        {{-- ログインリンク --}}
        <div class="text-center">
            <a href="{{ route('login') }}" class="login-link">ログインページへ</a>
        </div>
    </form>
</div>
@endsection
