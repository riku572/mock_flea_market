@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/result.css') }}">
@endsection

@section('content')
<div class="purchase-cancel">
    <h1>⚠️ 購入がキャンセルされました</h1>
    <p>決済が完了しませんでした。再度お試しください。</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">商品一覧へ戻る</a>
</div>