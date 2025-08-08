<div class="product-list-wrapper">
    @foreach($products as $product)
        <a class="product-card" href="{{ route('items.show', $product->id) }}">
            <img class="product-image" src="{{ asset($product->image) }}" alt="商品画像">
            <h2 class="product-name">{{ $product->name }}</h2>
            @if ($product->is_sold)
                <span class="product-sold">Sold</span>
            @endif
        </a>
    @endforeach
</div>
