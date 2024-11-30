<?php
namespace App\UseCase\Blog;

class ListBlogsInput
{
  private ?string $keyword;
  private ?string $sort;
  private ?int $category;

  public function __construct(?string $keyword, ?string $sort, ?int $category)
  {
    $this->keyword = $keyword;
    $this->sort = $sort;
    $this->category = $category;
  }

  public function getKeyword(): ?string
  {
    return $this->keyword;
  }

  public function getSort(): ?string
  {
    return $this->sort;
  }

  public function getCategory(): ?int
  {
    return $this->category;
  }
}