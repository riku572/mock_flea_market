<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'user_id' => 1,
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'storage/images/armani.jpg.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'storage/images/hdd.jpg.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ３束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ３束セット',
                'image' => 'storage/images/ilove.jpg.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image' => 'storage/images/shoes.jpg.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image' => 'storage/images/laptop.jpg.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => 1,
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image' => 'storage/images/mic.jpg.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id' => 1,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'storage/images/purse.jpg.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id' => 1,
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image' => 'storage/images/tumbler.jpg.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id' => 1,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image' => 'storage/images/waitress.jpg.jpg',
                'condition' => '良好',
            ],
            [
                'user_id' => 1,
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image' => 'storage/images/makeup.jpg.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
        ]);
    }
}
