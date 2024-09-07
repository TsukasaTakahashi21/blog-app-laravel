<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
          '技術', 'ライフスタイル', '健康', '旅行', '食べ物',
          '趣味', '学習', 'ビジネス', 'エンタメ', 'ニュース',
          'スポーツ', 'アート', '音楽', '映画', '政治',
          'ファッション', '美容', 'ゲーム', '教育', '科学'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
