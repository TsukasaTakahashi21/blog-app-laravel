<?php
namespace App\UseCase\Blog;

use App\Models\Blog;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditBlogInteractor
{
  public function handle(EditBlogInput $input): Blog
  {
    return DB::transaction(function() use ($input) {
      try {
        $blog = Blog::findOrFail($input->getId());
        $blog->title = $input->getTitle()->getValue();
        $blog->content = $input->getContent()->getValue();
        $blog->save();

        // category_id が存在する場合は blog_category テーブルに関連付けを行う
        if ($input->getCategoryId() !== null) {
          $blog->categories()->sync([$input->getCategoryId()]);
            } else {
              $blog->categories()->detach();
              }

          return $blog; 
        } catch (QueryException $e) {
            Log::error('ブログ編集に失敗しました', ['error' => $e->getMessage()]);
            throw new \Exception('ブログの編集に失敗しました。');
          }
      });
    }
  }
