<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\UseCase\Blog\CreateBlogInput;
use Illuminate\Database\QueryException;
use App\ValueObject\Title;
use App\ValueObject\Content;

class CreateBlogInteractor 
{
  public function handle(CreateBlogInput $input) 
  {
    try {
      $blog = new Blog();
      $blog->title = $input->getTitle()->getValue();
      $blog->content = $input->getContent()->getValue();
      $blog->user_id = session('user_id'); 
      $blog->save();
    } catch (QueryException $e) {
        throw new \Exception('ブログ作成に失敗しました。');
    }
  }
}