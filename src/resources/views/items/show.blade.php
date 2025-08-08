@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    <div class="product-detail-card">
        <img src="{{ asset($product->image) }}" alt="商品画像" class="product-detail-image">

        <div class="product-detail-content">
            <h2 class="product-detail-name">{{ $product->name }}</h2>
            <p class="product-detail-brand-name">{{ $product->brand_name }}</p>
            <p class="product-detail-price">¥{{ number_format($product->price) }} <span class="tax-label"> (税込) </span></p>
        
            <div class="like-comment-purchase">
                <div class="like-comment-row">
                    <form action="{{ route('items.like', ['product' => $product->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="like-button">
                            <span class="{{ $liked ? '#ef4444' : '#9ca3af' }}">☆</span>
                            {{ $product->likes->count() }}
                        </button>
                    </form>

                    <span class="comment-count">💬 {{ $product->comments->count() }}</span>
                </div>

                <form action="{{ route('purchase.confirm') }}" method="GET">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="purchase-button">購入手続きへ</button>
                </form>
            </div>

            <div class="product-description-card">
                <h3 class="product-description-title">商品説明</h3>
                <p class="product-detail-description">{{ $product->description }}</p>
            </div>

            <div class="product-information">
                <h3 class="product-description-title">商品の情報</h3>
                <p>カテゴリ <span>{{ $product->categories->pluck('name')->join(', ') }}</span></p>
                <p>商品の状態 <span>{{ $product->condition }}</span></p>
            </div>

            <div class="product-comment-card">
                <h3 class="product-comment-card-title">コメント（{{ $product->comments->count() }}）</h3>

                <ul>
                    @foreach ($product->comments as $comment)
                        <li class="comment-item">
                            <div class="comment-header">
                                <img src="{{ asset($comment->user->profile_image ?? 'images/default-user.png') }}" alt="ユーザー画像" class="comment-user-image" />
                                <div class="comment-header-info">
                                    <p class="comment-user-name">{{ $comment->user->name }}</p>
                                </div>
                            </div>
                            <p class="comment-content">{{ $comment->content }}</p>
                        </li>
                    @endforeach
                </ul>

                @auth
                    <form action="{{ route('items.comment', ['product' => $product->id]) }}" method="POST" class="comment-form">
                        @csrf
                        <textarea name="content" class="product-comment" rows="3" placeholder="コメントを入力してください">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <button class="product-comment-button" type="submit">コメントを送信</button>
                    </form>
                @else
                    <p>コメントするにはログインしてください。</p>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
