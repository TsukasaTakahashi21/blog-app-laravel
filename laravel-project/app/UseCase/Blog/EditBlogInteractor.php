<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\UseCase\Blog\EditBlogInput;
use Illuminate\Database\QueryException;

use App\ValueObject\Title;
use App\ValueObject\Content;

class EditBlogInteractor
{
  public function handle(EditBlogInput $input)
  {
    try {
      $blog = Blog::findOrFail($input->getId());
      $blog->title = $input->getTitle()->getValue();
      $blog->content = $input->getContent()->getValue();
      $blog->category_id = $input->getCategoryId();
      $blog->save();
    }  catch(QueryException $e) {
      throw new \Exception('ブログの編集に失敗しました。');
    }
  }
}