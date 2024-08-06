<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\UseCase\Blog\DeleteBlogInput;


class DeleteBlogInteractor
{
  public function handle(DeleteBlogInput $input)
  {
    $blog = Blog::findOrFail($input->getId());

    if (!$blog) {
      throw new \Exception('ブログが見つかりません。');
    }

    $blog->delete();
  }
}