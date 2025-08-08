@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/setup.css') }}">
@endsection

@section('content')
<div class="profile-setup-container">
    <h2 class="form-title">プロフィール設定</h2>

    <form action="{{ route('mypage.setup.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="image-upload-group">
            @if (auth()->user()->profile_image_path)
                <img src="{{ asset('storage/' . auth()->user()->profile_image_path) }}" alt="プロフィール画像" class="profile-preview" id="preview">
            @else
                <div class="profile-placeholder" id="preview"></div>
            @endif

            <div>
                <label for="image_path" class="custom-file-label">画像を選択する</label>
                <input type="file" name="image_path" id="image_path" class="custom-file-input-hidden" accept="image/*">
                @error('image_path')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

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

        <button type="submit" class="submit-button">更新する</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image_path').addEventListener('change', function (e) {
        const preview = document.getElementById('preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                }else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'profile-preview';
                    preview.replaceWith(img);
                    img.id = 'preview';
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
