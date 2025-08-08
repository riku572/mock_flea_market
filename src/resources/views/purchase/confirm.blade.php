@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<form action="{{ route('purchase.checkout', $product->id) }}" id="confirm-form" method="POST">
    @csrf
    <div class="purchase-confirm">
        <div class="purchase-main">

            <div class="purchase-left">
                <div class="purchase-box product-info">
                    <img src="{{ asset($product->image) }}" alt="商品画像">
                    <div class="product-text">
                        <p>{{ $product->name }}</p>
                        <p>¥{{ number_format($product->price) }}</p>
                    </div>
                </div>

                <div class="purchase-box">
                    <h2 class="purchase-heading">支払方法</h2>
                    <select name="payment_method" id="payment_method" required>
                        <option value="convenience">コンビニ払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                </div>

                <div class="purchase-box">
                    <div class="purchase-heading-wrapper">
                        <h2 class="purchase-heading">配送先</h2>
                        <a href="{{ route('purchase.updateAddress', ['product_id' => $product->id]) }}">変更する</a>
                    </div>

                    @if($profile)
                        <p>〒 {{ $profile->postal_code }}</p>
                        <p>{{ $profile->address }}</p>
                    @else
                        <p>配送先住所が登録されていません。プロフィールから登録してください。</p>
                        <a href="{{ route('purchase.address') }}">住所を登録する</a>
                    @endif
                </div>
            </div>

            <div class="purchase-right-with-button">
                <div class="purchase-right">
                    <div class="purchase-summary-box">
                        <div class="purchase-summary-item">
                            <p>商品代金</p>
                            <p>¥ {{number_format($product->price) }}</p>
                        </div>
                        <div class="purchase-summary-item">
                            <p>支払い方法</p>
                            <p> <span id="selected-method">選択されいません</span></p>
                        </div>
                    </div>
                </div>

                <div class="purchase-button-container">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="payment_method" id="final_method">
                    <button type="submit" class="purchase-button">購入する</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById('payment_method');
        const selectedMethod = document.getElementById('selected-method');
        const finalMethodInput = document.getElementById('final_method');

        if (select) {
            const label = select.options[select.selectedIndex].text;
            selectedMethod.textContent = label;
            finalMethodInput.value = select.value;

            select.addEventListener('change', function () {
                const label = select.options[select.selectedIndex].text;
                selectedMethod.textContent = label;
                finalMethodInput.value = select.value;
            });
        }
    });
</script>
@endpush
