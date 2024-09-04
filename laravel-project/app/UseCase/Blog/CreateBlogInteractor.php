<?php
namespace App\UseCase\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use App\ValueObject\Title;
use App\ValueObject\Content;

class CreateBlogInteractor 
{
    public function handle(CreateBlogInput $input) 
    {
        // 複数のデータベース操作をグループ化し、一貫性と整合性を保つ
        return DB::transaction(function() use ($input) {
            // ブログを作成
            $blog = new Blog();
            $blog->title = $input->getTitle()->getValue();
            $blog->content = $input->getContent()->getValue();
            $blog->user_id = session('user_id');
            $blog->status = $input->getStatus();
            $blog->save();

            // カテゴリが指定されている場合、blog_category テーブルに関連付け
            if ($input->getCategoryId() !== null) {
              $blog->categories()->attach($input->getCategoryId());
            }

            return $blog;
        });
    }
}
