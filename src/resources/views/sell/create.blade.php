@extends('layouts.app')

@section('content')
<div class= "container">
    <h2>商品を出品する</h2>
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>商品説明</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>商品の状態</label>
            <select name="condition">
                @foreach($conditions as $condition)
                    <option value="{{ $condition }}" {{ old('condition') == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>カテゴリ (複数選択可)</label>
            <select name="categories[]" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (collect(old('categories'))->contains($category->id)) ? 'selected':'' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>商品画像</label>
            <input type="file" name="image">
        </div>

        <button type="submit">出品する</button>
    </form>
</div>
@endsection