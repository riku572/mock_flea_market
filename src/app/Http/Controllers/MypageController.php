<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class MypageController extends Controller
{
    public function setupForm()
    {
        return view('mypage.setup');
    }

    public function setup(Request $request)
    {
        $request->validate ([
            'user_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building_name' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'file', 'mimes:jpeg,png'],
        ],[
            'user_name.required' => 'お名前を入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンありの形式 (例：123-4567) で入力してください',
            'address.required' => '住所を入力してください',
            'building_name.required' => '建物名を入力してください',
            'image_path.mimes' => 'プロフィール画像は.jpegまたは.png形式のファイルをアップロードしてください',
        ]);

        $user = Auth::user();

        $profile = new Profile(['user_id' => $user->id]);

        $profile->user_name = $request->input('user_name');
        $profile->postal_code = $request->input('postal_code');
        $profile->address = $request->input('address');
        $profile->building_name = $request->input('building_name');

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('profile_images', 'public');
            $profile->image_path = $path;
        }

        $profile->save();

        return redirect()->route('items.index')->with('success', 'プロフィールを設定しました');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->input('tab', 'selling');

        $profile = $user->profile;

        if ($tab === 'selling') {
            $products = $user->products()->get();
            $purchases = collect();
        }elseif ($tab === 'purchased') {
            $products = collect();
            $purchases = $user->purchasedProducts()->get();
        }

        return view('mypage.index', compact('profile', 'products', 'purchases', 'tab'));
    }

    public function edit() {
        return view('mypage.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $profile = $user->profile;

        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building_name' => ['required', 'string', 'max:255'],
            'image_path' => ['nullable', 'file', 'mimes:jpeg,png'],
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('profile_images', 'public');
            $profile->image_path = $path;
        }

        $profile->user_name = $validated['user_name'];
        $profile->postal_code = $validated['postal_code'];
        $profile->address = $validated['address'];
        $profile->building_name = $validated['building_name'];

        $profile->save();

        return redirect()->back()->with('status', 'ユーザー情報を更新しました');
    }
}
