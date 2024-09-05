<?php
namespace App\UseCase\Blog;

use App\ValueObject\Title;
use App\ValueObject\Content;

class EditBlogInput
{
  private int $id;
  private Title $title;
  private Content $content;
  private ?int $categoryId;

  public function __construct(int $id, Title $title, Content $content, ?int $categoryId)
  {
    $this->id = $id;
    $this->title = $title;
    $this->content = $content;
    $this->categoryId = $categoryId;
  }

  public function getId(): int 
  {
    return $this->id;
  }

  public function getTitle(): Title
  {
    return $this->title;
  }

  public function getContent(): Content
  {
    return $this->content;
  }

  public function getCategoryId(): ?int
  {
    return $this->categoryId;
  }
}