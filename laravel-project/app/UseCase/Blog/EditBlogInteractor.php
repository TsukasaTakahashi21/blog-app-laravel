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
      $blog->contents = $input->getContents();
      $blog->save();
    }  catch(QueryException $e) {
      throw new \Exception('ブログの編集に失敗しました。');
    }
  }
}