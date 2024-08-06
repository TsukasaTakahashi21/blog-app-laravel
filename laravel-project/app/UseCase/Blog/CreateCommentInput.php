<?php
namespace App\UseCase\Blog;

class CreateCommentInput
{
  public int $userId;
  public int $blogId;
  public string $commenterName;
  public string $comments;

  public function __construct(int $userId, int $blogId, string $commenterName, string $comments)
  {
    $this->userId = $userId;
    $this->blogId = $blogId;
    $this->commenterName = $commenterName;
    $this->comments = $comments;
  }
}