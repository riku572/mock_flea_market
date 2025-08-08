<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SellController extends Controller
{
    public function create()
    {
        $conditions = ['新品', '未使用', '目立った傷なし', 'やや傷あり', '全体的に状態が悪い'];
        $categories = Category::all();

        return view('sell.create', compact('conditions', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
            'condition' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'categories_json' => ['required', 'string'],
        ]);

        $categoryIds = json_decode($request->input('categories_json'), true);

        if (!is_array($categoryIds) || empty($categoryIds)) {
            return back()->withInput()->withErrors(['categories_json' => '少なくとも１つのカテゴリを選択してください。']);
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->brand = $request->input('brand');
        $product->price = $request->input('price');
        $product->condition = $request->input('condition');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $product->image = $path;
        }

        $product->save();

        $product->categories()->sync($categoryIds);

        return redirect()->route('sell.index')->with('success', '商品を出品しました');
    }
}
