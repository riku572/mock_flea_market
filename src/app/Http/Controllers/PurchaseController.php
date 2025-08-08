<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Profile;

class PurchaseController extends Controller
{
    public function confirm(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('ログインしてください');
        }

        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        if ($product->is_sold) {
            return redirect()->route('home')->withErrors('この商品は既に売却済みです。');
        }

        $profile = Profile::where('user_id', $user->id)->first();
        if (!$profile || !$profile->address) {
            return redirect()->route('profile.create')->withErrors('配送先住所が登録されていません。');
        }

        return view('purchase.confirm', [
            'product' => $product,
            'profile' => $profile,
        ]);
    }

    public function changeAddress()
    {
        $profile = auth()->user()->profile;
        return view('purchase.address', compact('profile'));
    }

    
    public function updateAddress(Request $request)
    {
        $request->validate([
            'postal_code' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', 'max:255'],
            'building_name' => ['required', 'string', 'max:255'],
        ], [
            'postal_code.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
            'building_name' => '建物名を入力してください。',
        ]);

        $user = Auth::user();

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building_name' => $request->building_name,
            ]
        );

        return redirect()->route('purchase.confirm', ['product_id' => $request->input('product_id')])->with('status', '配送先を更新しました');
    }
}
