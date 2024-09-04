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
        'contents'
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite','blog_id', 'user_id')->withTimestamps();
    }
}
