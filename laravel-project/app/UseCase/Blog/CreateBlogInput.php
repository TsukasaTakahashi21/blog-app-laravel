<?php
namespace App\UseCase\Blog;

class CreateBlogInput
{
  private string $title;
  private string $contents;

  public function __construct(string $title, string $contents)
  {
    $this->title = $title;
    $this->contents = $contents;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getContent(): string
  {
    return $this->contents;
  }
}