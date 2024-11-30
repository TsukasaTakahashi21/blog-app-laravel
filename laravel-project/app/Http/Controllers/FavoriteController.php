<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class FavoriteController extends Controller
{
    public function toggle(Blog $blog)
    {
        $user = Auth::user();

        if ($user->favorites()->where('blog_id', $blog->id)->exists()) {  
            $user->favorites()->detach($blog->id);
        } else {
            $user->favorites()->attach($blog->id);
        }

        return redirect()->back();
    }

    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->get(); 

        return view('blog.favorites', compact('favorites'));
    }
}
