<?php
namespace App\UseCase\Blog;

use App\ValueObject\CommenterName;
use App\ValueObject\Comments;

class CreateCommentInput
{
  public int $userId;
  public int $blogId;
  public CommenterName $commenterName;
  public Comments $comments;

  public function __construct(int $userId, int $blogId, CommenterName $commenterName, Comments $comments)
  {
    $this->userId = $userId;
    $this->blogId = $blogId;
    $this->commenterName = $commenterName;
    $this->comments = $comments;
  }
}