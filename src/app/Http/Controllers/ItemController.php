<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Http\Requests\StoreCommentRequest;

class ItemController extends Controller
{
    public function index(Request $request) {
        $tab = $request->input('tab', 'recommend');

        if ($tab === 'recommend') {
            if (Auth::check()) {
                $products = Product::where('user_id', '!=', Auth::id())->get();
            } else {
                $products = Product::all();
            }
        } elseif ($tab === 'mylist') {
            if (Auth::check()) {
                $products = Auth::user()->likedProducts()->get();
            } else {
                $products = collect();
            }
        }

        return view('items.index', compact('products'));
    }

    public function show(Product $product) {
        $product->load(['categories', 'likes', 'comments.user']);

        return view('items.show', [
            'product' => $product,
            'liked' => Auth::check() && $product->likes->contains('user_id', Auth::id()),
        ]);
    }

    public function like(Product $product) {
        $user = Auth::user();

        $like = $product->likes()->where('user_id', $user->id)->first();
        if ($like) {
            $like->delete();
        } else {
            $product->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    public function comment(CommentRequest $request, Product $product) {
        $product->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', '%' . $keyword . '%')->get();

        return view('components.product_list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = ['新品', '未使用', '目立った傷なし', 'やや傷あり', '全体的に状態が悪い'];
        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'condition' => ['required', 'string'],
            'categories' =>['required', 'array'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $item = new Item($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $item->image_path = $path;
        }

        $item->save();
        $item->categories()->sync($request->input('categories'));

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }
}
