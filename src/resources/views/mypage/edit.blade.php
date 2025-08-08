@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/edit.css') }}">
@endsection

@section('content')
<div class="edit-user-container">
    <h1>プロフィール設定</h1>

    <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group image-upload-group">
            @if(Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像" class="profile-preview">
            @else
                <div class="profile-placeholder"></div>
            @endif
            
            <div class="form-group file-upload-inline">
                <label for="profile_image" class="custom-file-label">画像を選択する</label>
                <input type="file" name="profile_image" id="profile_image" class="custom-file-input-hidden">
            </div>
        </div>

        <div class="form-group">
            <label for="user_name">ユーザー名</label>
            <input type="text" name="user_name" id="user_name" value="{{ old('user_name') ? old('user_name') : (Auth::user()->profile->user_name ?? '') }}">
        </div>

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') ? old('postal_code') : (Auth::user()->profile->postal_code ?? '') }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address') ? old('address') : (Auth::user()->profile->address ?? '') }}">
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" name="building_name" id="building_name" value="{{ old('building_name') ? old('building_name') : (Auth::user()->profile->building_name ?? '') }}">
        </div>

        <button type="submit" class="btn-submit">更新する</button>
    </form>
</div>
@endsection
