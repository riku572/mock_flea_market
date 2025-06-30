@extends('layout.app')

@section('css')

@section('content')
<div class="product-detail-container">
    <div class="product-detail-card">
        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="product-detail-image">
        <h2 class="product-detail-name">{{ $product->name }}</h2>
        <p class="product-detail-brand-name">{{ $product->brand_name }}</p>
        <p class="product-detail-price">¥{{ number_format($product->price) }}</p>
        
        <div>
            <form action="{{ route('items.like', ['id' => $product->id]) }}" method="POST">
                @csrf
                <button type="submit">
                    <span class="{{ $liked ? 'text-red-500' : 'text-gray-400' }}">☆</span>
                    {{ $product->likes->count() }}
                </button>
            </form>

            <span>💬 {{ $product->comments->count() }}</span>

            <a href="{{ route('purchase.confirm', $product) }}">購入手続きへ</a>
        </div>

        <div class="product-description-card">
            <h3 class="product-description">商品説明</h3>
            <p class="product-detail-description">{{ $product->description }}</p>
        </div>

        <div class="product-information">
            <p>カテゴリ <span>{{ $product->categories->pluck('name')->join(', ') }}</span></p>
            <p>商品の状態 <span>{{ $product->condition }}</span></p>
        </div>

        <div class="product-comment-card">
            <h3 class="product-comment-card-title">コメント</h3>

            <ul>
                @foreach ($product->comments as $comment)
                    <li>
                        <p>{{ $comment->user->name }}</p>
                        <p>{{ $comment->content }}</p>
                    </li>
                @endforeach
            </ul>

            @auth
                <form action="{{ route('items.comment', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    <textarea name="content" class="product-comment" rows="3">{{ old('content') }}</textarea>
                    @error('content')
                        <p>{{ $message }}</p>
                    @enderror
                    <button class="product-comment-button">コメントを送信</button>
                </form>
            @else
                <p>コメントするにはログインしてください。</p>
            @endauth
        </div>
    </div>
</div>
@endsection
