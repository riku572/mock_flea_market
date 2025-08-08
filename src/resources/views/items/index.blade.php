@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="tab-buttons">
        <a href="{{ route('items.index', ['tab' => 'recommend']) }}" class="tab-button {{ request('tab', 'recommend') === 'recommend' ? 'active' : ''}}">
            おすすめ
        </a>
        <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="tab-button {{ request('tab', 'recommend') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>
</div>

<hr class="section-divider">

<div class="product-list" id="product-list">
    @include('components.product_list', ['products' => $products])
</div>
@endsection
