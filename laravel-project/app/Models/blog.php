<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title', 
        'contents',
        'user_id',
        'status'

    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite','blog_id', 'user_id')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }
}
