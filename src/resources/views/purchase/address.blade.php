@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/address.css') }}">
@endsection

@section('content')
<div class="address-section">
    <h2 class="address-title">住所の変更</h2>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ route('purchase.address.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}">
            @error('postal_code')
                <p class="error">{{ $message }}</p>]
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $profile->address ?? '') }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" id="building_name" name="building_name" value="{{ old('building_name', $profile->building_name ?? '')}}">
            @error('building_name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="address-button-wrapper">
            <button type="submit" class="submit-btn">更新する</button>
        </div>
    </form>
</div>
@endsection
