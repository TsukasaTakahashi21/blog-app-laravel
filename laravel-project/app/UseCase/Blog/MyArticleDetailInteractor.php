<?php
namespace App\UseCase\Blog;

use App\Models\Blog;

class MyArticleDetailInteractor
{
  public function handle(MyArticleDetailInput $input)
  {
    $blog = Blog::findOrFail($input->getBlogId());

    return [
      'blog' => $blog,
    ];
  }
}