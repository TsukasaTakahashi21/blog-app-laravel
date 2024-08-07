<?php
namespace App\UseCase\Blog;

use App\Models\Blog;

class ListBlogsInteractor
{
  public function handle(ListBlogsInput $input)
  {
    $query = Blog::query();

    // キーワード検索
    if ($keyword = $input->getKeyword()) {
      $query->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('content', 'like', '%'.$keyword.'%');
      }

    // ソート順
      if ($sort = $input->getSort()) {
        if ($sort === 'newest') {
          $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            // デフォルト
            $query->orderBy('created_at', 'desc');
        }
      }
        return $query->get();
  }
}