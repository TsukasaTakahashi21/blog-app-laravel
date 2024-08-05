<?php
namespace App\UseCase\Blog;

class EditBlogInput
{
  private int $id;
  private string $title;
  private string $contents;

  public function __construct(int $id, string $title, string $contents)
  {
    $this->id = $id;
    $this->title = $title;
    $this->contents = $contents;
  }

  public function getId(): int 
  {
    return $this->id;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getContents(): string
  {
    return $this->contents;
  }
}