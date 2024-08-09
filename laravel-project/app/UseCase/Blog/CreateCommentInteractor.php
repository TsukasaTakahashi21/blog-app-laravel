<?php
namespace App\UseCase\Blog;

use App\Models\Comment;
use Illuminate\Database\QueryException;

class CreateCommentInteractor
{
  public function handle(CreateCommentInput $input)
  {
    try {
      Comment::create([
        'user_id' => $input->userId,
        'blog_id' => $input->blogId,
        'commenter_name' => $input->commenterName->getValue(),
        'comments' => $input->comments->getValue(),
      ]);
    } catch (QueryException $e) {
        throw new \Exception('コメントの作成に失敗しました。');
    }
  }
}