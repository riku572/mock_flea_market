<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// トップページ (商品一覧)
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

// 商品詳細ページ
Route::get('/items/{product}', [ItemController::class, 'show'])->name('items.show');
Route::post('/items/{product}/like', [ItemController::class, 'like'])->middleware('auth')->name('items.like');
Route::post('/items/{product}/comment', [ItemController::class, 'comment'])->middleware('auth')->name('items.comment');

// 購入確認～住所変更
Route::middleware('auth')->group(function () {
    Route::get('/purchase/confirm', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
    Route::get('/purchase/address', [PurchaseController::class, 'changeAddress'])->name('purchase.address');
    Route::post('/purchase/address/update', [PurchaseController::class, 'updateAddress'])->name('purchase.updateAddress');

    // Stripe支払い関連
    Route::post('/purchase/checkout', [PaymentController::class, 'checkout'])->name('purchase.checkout');
    Route::get('/purchase/success', [PaymentController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/cancel', [PaymentController::class, 'cancel'])->name('purchase.cancel');
});

// 商品出品ページ (GET) + 出品処理 (POST)
Route::get('/sell/create', [SellController::class, 'create'])->name('sell.create');
Route::post('/sell/create', [SellController::class, 'store'])->name('sell.store');

// プロフィールページ (GET) + 編集ページ (GET) + 更新処理 (POST)
Route::get('/mypage/setup', [MypageController::class, 'setupForm'])->name('mypage.setup');
Route::post('/mypage/setup', [MypageController::class, 'setup'])->name('mypage.setup.store');
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
Route::get('/mypage/edit', [MypageController::class, 'edit'])->name('mypage.edit');
Route::put('/mypage/update', [MypageController::class, 'update'])->name('mypage.update');
