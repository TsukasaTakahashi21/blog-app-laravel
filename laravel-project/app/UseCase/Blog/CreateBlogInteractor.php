<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\UseCase\Blog\CreateBlogInput;
use Illuminate\Database\QueryException;

class CreateBlogInteractor 
{
  public function handle(CreateBlogInput $input) 
  {
    try {
      $blog = new Blog();
      $blog->title = $input->getTitle();
      $blog->content = $input->getContent();
      $blog->save();
    } catch (QueryException $e) {
        throw new \Exception('ブログ作成に失敗しました。');
    }
  }
}