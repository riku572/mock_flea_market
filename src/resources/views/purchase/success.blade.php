@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/result.css') }}">
@endsection

@section('content')
<div class="purchase-complete">
    <h1>🎉 ご購入ありがとうございます！</h1>
    <p>決済が正常に完了しました。</p>
    <a href="{{ route('products.index') }}" class="btn-primary">商品一覧へ戻る</a>
</div>
@endsection
