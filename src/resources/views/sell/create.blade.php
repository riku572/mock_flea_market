@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="container product-create-container">
    <h2 class="product-create-title">商品の出品</h2>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" class="product-create-form">
        @csrf

        <div class="form-group product-image">
            <label for="image" class="form-label">商品画像</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <p class="form-section-title">商品の詳細</p>

        <div class="form-group product-categories">
            <label for="categories" class="form-label">カテゴリー</label>
            <div class="form-control" id="category-buttons">
                @foreach($categories as $category)
                    <button type="button" class="category-button" data-id="{{ $category->id }}" data-selected="{{ in_array($category->id, old('categories', [])) ? 'true' : 'false' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="categories_json" id="categories-json">
        </div>

        <div class="form-group product-condition">
            <label for="condition" class="form-label">商品の状態</label>
            <select name="condition" id="condition" class="form-control">
                @foreach($conditions as $condition)
                    <option value="{{ $condition }}" {{ old('condition') == $condition ? 'selected' : '' }}>
                        {{ $condition }}
                    </option>
                @endforeach
            </select>
        </div>

        <p class="form-section-title">商品名と説明</p>

        <div class="form-group product-name">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group product-brand">
            <label for="brand" class="form-label">ブランド名</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}">
        </div>

        <div class="form-group product-price">
            <label for="price" class="form-label">販売価格</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>

        <div class="form-group product-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.category-button');
        const hiddenInput = document.getElementById('categories-json');

        let selected = [];

        buttons.forEach(btn => {
            const isSelected = btn.dataset.selected === 'true';
            const id = btn.dataset.id;
            if (isSelected) {
                btn.classList.add('selected');
                selected.push(id);
            }
        });

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id =this.dataset.id;
                this.classList.toggle('selected');

                if (selected.includes(id)) {
                    selected = selected.filter(i => i !== id);
                } else {
                    selected.push(id);
                }

                hiddenInput.value = JSON.stringify(selected);
            });
        });

        hiddenInput.value = JSON.stringify(selected);
    });
</script>
@endpush