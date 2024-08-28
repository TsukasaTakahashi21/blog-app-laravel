<?php
namespace App\UseCase\Blog;

use App\ValueObject\Title;
use App\ValueObject\Content;

class CreateBlogInput
{
  private Title $title;
  private Content $content;
  private $status;

  public function __construct(Title $title, Content $content, int $status)
  {
    $this->title = $title;
    $this->content = $content;
    $this->status = $status;
  }

  public function getTitle(): Title
  {
    return $this->title;
  }

  public function getContent(): Content
  {
    return $this->content;
  }

  public function getStatus(): int 
  {
    return $this->status;
  }
}