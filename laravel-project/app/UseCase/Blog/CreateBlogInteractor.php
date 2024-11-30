<?php
namespace App\UseCase\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class CreateBlogInteractor 
{
    public function handle(CreateBlogInput $input) 
    {
        return DB::transaction(function() use ($input) {
            $blog = $this->createBlog($input);
            $this->attachCategory($blog, $input->getCategoryId());
            
            return $blog;
        });
    }

    private function createBlog(CreateBlogInput $input): Blog
    {
        $blog = new Blog();
        $blog->title = $input->getTitle()->getValue();
        $blog->content = $input->getContent()->getValue();
        $blog->user_id = session('user_id');
        $blog->status = $input->getStatus();
        $blog->save();

        return $blog;
    }

    private function attachCategory(Blog $blog, ?int $categoryId): void
    {
        if ($categoryId !== null) {
            $blog->categories()->attach($categoryId);
        }
    }
}
