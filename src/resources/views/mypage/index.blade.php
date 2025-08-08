@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    <div class="profile-info">
        <img src="{{ asset('storage/' . ($profile->image_path ?? 'default.png')) }}" alt="●">
        <p>{{ $profile->user_name ?? auth()->user()->name }}</p>
        <a href="{{ route('mypage.edit') }}">プロフィールを編集</a>
    </div>

    <div class="tab-buttons">
        <a href="{{ route('mypage.index', ['tab' => 'selling']) }}" class="tab-button {{ $tab === 'selling' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypage.index', ['tab' => 'purchased']) }}" class="tab-button {{ $tab === 'purchased' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    <hr class="tab-divider">

    @if ($tab === 'selling')
        <div class="product-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <img src="{{ Storage::url($product->image) }}" alt="商品画像" class="product-image">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @empty
                <p>出品した商品はありません。</p>
            @endforelse
        </div>
    @elseif ($tab === 'purchased')
        <div class="product-grid">
            @forelse ($purchases as $purchase)
                <div class="product-card">
                    <img src="{{ Storage::url($purchase->image) }}" alt="商品画像" class="product-image">
                    <p class="product-name">{{ $purchase->name }}</p>
                </div>
            @empty
                <p>購入した商品はありません。</p>
            @endforelse
        </div>
    @endif
</div>
@endsection