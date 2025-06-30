@extends('layouts.app')

@section('content')
<div class="profile-setup-container">
    <h2 class="form-title">プロフィール設定</h2>

    <form action="{{ route('mypage.setup.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="image_path" class="form-label-profile-image"></label>
        <input type="file" name="image_path" id="image_path" class="form-input-profile-image">
        @error('image_path')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="user_name" class="form-label">ユーザー名</label>
        <input type="text" name="user_name" id="user_name" value="{{ old('user_name', auth()->user()->name) }}" class="form-input">
        @error('user_name')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="postal_code" class="form-label">郵便番号</label>
        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="form-input">
        @error('postal_code')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="address" class="form-label">住所</label>
        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-input">
        @error('address')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="building" class="form-label">建物名</label>
        <input type="text" name="building_name" id="building_name" value="{{ old('building_name') }}" class="form-input">
        @error('building_name')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <button type="submit" class="submit-button">設定を保存</button>
    </form>
</div>
@endsection
