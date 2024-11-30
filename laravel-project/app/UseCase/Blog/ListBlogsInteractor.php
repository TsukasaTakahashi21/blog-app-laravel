<?php

namespace App\UseCase\Blog;

use App\Models\Blog;

class ListBlogsInteractor
{
  const ORDER_DESC = 'desc';
  const ORDER_ASC = 'asc';

  public function handle(ListBlogsInput $input)
  {
    $query = Blog::query();
    // 公開状態の投稿のみを表示
    $query->where('status', 1);

    // キーワード検索
    if ($keyword = $input->getKeyword()) {
      $query->where('title', 'like', '%' . $keyword . '%')
        ->orWhere('content', 'like', '%' . $keyword . '%');
    }

    // カテゴリでの絞り込み
    if ($category = $input->getCategory()) {
      $query->whereHas('categories', function ($query) use ($category) {
        $query->where('category_id', $category);
      });
    }

    // ソート順
    if ($sort = $input->getSort()) {
      $order = ($sort === 'oldest') ? self::ORDER_ASC : self::ORDER_DESC;
      $query->orderBy('created_at', $order);
    } else {
      $query->orderBy('created_at', self::ORDER_DESC);
    }

    return $query->get();
  }
}
