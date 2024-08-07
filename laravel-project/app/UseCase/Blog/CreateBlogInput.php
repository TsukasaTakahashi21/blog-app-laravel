<?php
namespace App\UseCase\Blog;

use App\ValueObject\Title;
use App\ValueObject\Content;

class CreateBlogInput
{
  private Title $title;
  private Content $content;

  public function __construct(Title $title, Content $content)
  {
    $this->title = $title;
    $this->content = $content;
  }

  public function getTitle(): Title
  {
    return $this->title;
  }

  public function getContent(): Content
  {
    return $this->content;
  }
}