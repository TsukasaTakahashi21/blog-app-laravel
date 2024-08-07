<?php
namespace App\UseCase\Blog;

use App\Models\blog;
use App\Models\comment;

class ListBlogDetailInteractor
{
  public function handle(ListBlogDetailInput $input)
  {
    $blog = Blog::findOrFail($input->getBlogId());
    $comments = Comment::where('blog_id', $input->getBlogId())->get();

    return [
      'blog' => $blog,
      'comments' => $comments,
    ];
  }
}