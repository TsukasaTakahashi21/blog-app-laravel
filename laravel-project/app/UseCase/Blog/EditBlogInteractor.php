<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\UseCase\Blog\EditBlogInput;
use Illuminate\Database\QueryException;

class EditBlogInteractor
{
  public function handle(EditBlogInput $input)
  {
    try {
      $blog = Blog::findOrFail($input->getId());
      $blog->title = $input->getTitle();
      $blog->content = $input->getContent();
      $blog->save();
    }  catch(QueryException $e) {
      throw new \Exception('ブログの編集に失敗しました。');
    }
  }
}