<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\blog;
use App\Models\Comment;
use App\UseCase\Blog\CreateBlogInput;
use App\UseCase\Blog\CreateBlogInteractor;
use App\UseCase\Blog\EditBlogInput;
use App\UseCase\Blog\EditBlogInteractor;

class BlogController extends Controller
{
    public function top(Request $request)
    {
        $query = Blog::query();

        // キーワード検索
        if ($keyword = $request->query('keyword')) {
            $query->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('content', 'like', '%'.$keyword.'%');
        }

        // ソート順
        if ($sort = $request->query('sort')) {
            if ($sort === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } else {
                // デフォルト
                $query->orderBy('created_at', 'desc');
            }
        }

        $blogs = $query->get();
        return view ('blog.top', compact('blogs'));
    }

    public function header()
    {
        return view('blog.header');
    }

    public function mypage()
    {
        $blogs = Blog::all();
        return view('blog.mypage', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ], [
            'title.required' => 'タイトルを入力してください',
            'content.required' => '内容を入力してください'
        ]);

        $input = new CreateBlogInput(
            $validated['title'],
            $validated['content']
        );

        try {
            $interactor = new CreateBlogInteractor();
            $interactor->handle($input);

            return redirect()->route('mypage');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'create_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    public function showDetail($id)
    {
        $blog = Blog::findOrFail($id);
        $comments = Comment::where('blog_id', $id)->get();
        return view('blog.detail', compact('blog', 'comments'));
    }

    public function storeComment(Request $request, $id)
    {
        $validated = $request->validate([
            'commenter_name' => 'required|string|max:20',
            'comments' => 'required|string',
        ], [
            'commenter_name.required' => 'コメント名を入力してください',
            'comments.required' => 'コメントを入力してください',
        ]);

        Comment::create([
            'user_id' => Auth()->id(), 
            'blog_id' => $id,
            'commenter_name' => $validated['commenter_name'],
            'comments' => $validated['comments'],
        ]);

        return redirect()->route('detail', ['id' => $id]);
    }

    public function showMyarticleDetail($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.myarticleDetail', compact('blog'));
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('signUp');
    }

    public function detail()
    {
        return view('blog.detail');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $input = new EditBlogInput($id, $validated['title'], $validated['content']);

        try {
            $interactor = new EditBlogInteractor();
            $interactor->handle($input);

            return redirect()->route('mypage');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'edit_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('mypage');
    }
}
