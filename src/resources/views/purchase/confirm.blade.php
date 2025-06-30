@extends('layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')
<div class="purchase-confirm">
    <div class="purchase-main">
        <div class="purchase-left">
            <div class="purchase-box">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                <p>{{ $product->name }}</p>
                <p>¥{{ number_format($product->price) }}</p>
            </div>

            <div class="purchase-box">
                <h2 class="purchase-heading">支払方法</h2>
                <form id="payment-form">
                    @csrf
                    <select name="payment_method" id="payment_method" class="">
                        <option value="convenience">コンビニ払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                </form>
            </div>

            <div class="purchase-box">
                <h2 class="purchase-heading">配送先</h2>
                <p>〒 {{ $profile->postal_code }}</p>
                <p>{{ $profile->address }}</p>
                <a href="{{ route('purchase.edit') }}" class="">変更する</a>
            </div>
        </div>

        <div class="purchase-right">
            <div class="purchase-summary">
                <p>商品代金 ¥ {{ number_format($product->price) }}</p>
                <p>支払方法   <span id="selected-method">選択されていません</span></p>

                <form action="{{ route('purchase.execute', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" id="final_method">
                    <button type="submit" class="purchase-button">購入する</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
