<?php
namespace App\UseCase\Blog;

use App\Models\Blog;

class MyArticleDetailInteractor
{
  public function handle(MyArticleDetailInput $input): Blog
  {
    return Blog::findOrFail($input->getBlogId());
  }
}