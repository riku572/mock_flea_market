@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-form">
    <h2 class="login-form_heading">ログイン</h2>
    <div class="login-form_inner">
        <form class="login-form_form" action="{{ route('login') }}" method="post">
            @csrf
            <div class="login-form_group">
                <label class="login-form_label" for="email">メールアドレス</label>
                <input class="login-form_input" type="email" name="email" id="email">
                <p class="login-form_error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form_group">
                <label class="login-form_label" for="password">パスワード</label>
                <input class="login-form_input" type="password" name="password" id="password">
                <p class="login-form_error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form_login_botton">
                <input class="login-form_login_botton_botton" type="submit" value="ログインする">
            </div>
        </form>
        <div class="register-link">
            <a class="register-link_botton" href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
