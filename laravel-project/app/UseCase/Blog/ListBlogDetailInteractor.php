<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\Models\comment;

class ListBlogDetailInteractor
{
  public function handle(ListBlogDetailInput $input)
  {
    $blog = Blog::with('comments')->findOrFail($input->getBlogId());

    return $blog;
  }
}