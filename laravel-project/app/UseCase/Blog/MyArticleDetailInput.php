<?php
namespace App\UseCase\Blog;

class MyArticleDetailInput
{
    private int $blogId;

    public function __construct(int $blogId)
    {
        $this->blogId = $blogId;
    }

    public function getBlogId(): int
    {
        return $this->blogId;
    }
}