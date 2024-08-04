<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'blog_id',
        'commenter_name',
        'comments',
    ];

    // 関連するブログとのリレーション
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // 関連するユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
