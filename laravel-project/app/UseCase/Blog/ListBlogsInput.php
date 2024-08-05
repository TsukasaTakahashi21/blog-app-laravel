<?php
namespace App\UseCase\Blog;

class ListBlogsInput
{
  private ?string $keyword;
  private ?string $sort;

  public function __construct(?string $keyword, ?string $sort)
  {
    $this->keyword = $keyword;
    $this->sort = $sort;
  }

  public function getKeyword(): ?string
  {
    return $this->keyword;
  }

  public function getSort(): ?string
  {
    return $this->sort;
  }
}