<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Profile;

class PurchaseController extends Controller
{
    public function execute(Request $request, Product $product)
    {
        $user = Auth::user();

        $product->is_sold = true;
        $product->save();

        $profile = Profile::where('user_id', $user->id)->first();

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address' => $profile->address,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('mypage.index')->with('status', '購入が完了しました');
    }
    
    public function confirm(Request $request) {
        return view('purchase.confirm');
    }

    public function changeAddress() {
        return view('purchase.address');
    }

    public function store(Request $request) {

    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return redirect()->back()->withErrors(['profile' => 'プロフィールが見つかりません']);
        }

        $temporaryAddress = $request->address;

        return view('purchase.confirm', [
            'address' => $temporaryAddress,
            'profile' => $profile,
        ]);
    }
}
