<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Profile;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:convenience,card',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->is_sold) {
            return redirect()->route('home')->withErrors('この商品は既に売却済みです。');
        }

        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile || !$profile->address) {
            return redirect()->route('profile.create')->withErrors('配送先住所が登録されていません。');
        }

        session([
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = $request->payment_method === 'convenience' ? ['konbini'] : ['card'];

        $session = StripeSession::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success'),
            'cancel_url' => route('purchase.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $user = Auth::user();
        $productId = session('product_id');
        $paymentMethod = session('payment_method');

        if (!$productId || !$paymentMethod) {
            return redirect()->route('home')->withErrors('購入情報が見つかりません。');
        }

        $product = Product::findOrFail($productId);

        if ($product->is_sold) {
            return redirect()->route('home')->withErrors('この商品は既に売却済みです。');
        }

        $profile = Profile::where('user_id', $user->id)->first();
        if (!$profile || !$profile->address) {
            return redirect()->route('profile.create')->withErrors('配送先住所が登録されていません。');
        }

        purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'shipping_address' => $profile->address,
            'payment_method' => $paymentMethod,
            'image' => $product->image,
        ]);

        $product->update(['is_sold' => true]);

        session()->forget(['product_id', 'payment_method']);

        return view('purchase.success')->with('status', '購入が完了しました！');
    }

    public function cancel()
    {
        session()->forget(['product_id', 'payment_method']);
        return view('purchase.cancel')->with('status', '購入がキャンセルされました。');
    }
}
