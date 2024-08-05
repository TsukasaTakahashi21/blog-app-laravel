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
use App\UseCase\Blog\ListBlogsInput;
use App\UseCase\Blog\ListBlogsInteractor;
use App\UseCase\Blog\ListBlogDetailInput;
use App\UseCase\Blog\ListBlogDetailInteractor;

class BlogController extends Controller
{
    private CreateBlogInteractor $createBlogInteractor;
    private EditBlogInteractor $editBlogInteractor;
    private ListBlogsInteractor $listBlogsInteractor;
    private ListBlogDetailInteractor $listBlogDetailInteractor;

    public function __construct(
        CreateBlogInteractor $createBlogInteractor,
        EditBlogInteractor $editBlogInteractor,
        ListBlogsInteractor $listBlogsInteractor,
        ListBlogDetailInteractor $listBlogDetailInteractor
    ) {
        $this->createBlogInteractor = $createBlogInteractor;
        $this->editBlogInteractor = $editBlogInteractor;
        $this->listBlogsInteractor = $listBlogsInteractor;
        $this->listBlogDetailInteractor = $listBlogDetailInteractor;
    }


    // 絞り込み機能
    public function top(Request $request)
    {
        $input = new ListBlogsInput(
            $request->query('keyword'),
            $request->query('sort')
        );

        $blogs = $this->listBlogsInteractor->handle($input);

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

    // ブログ作成
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
            $this->createBlogInteractor->handle($input);
            return redirect()->route('mypage');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'create_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    // ブログ詳細
    public function detail()
    {
        return view('blog.detail');
    }

    public function showDetail($id)
    {
        $input = new ListBlogDetailInput($id);
        $result = $this->listBlogDetailInteractor->handle($input);

        $blog = $result['blog'];
        $comments = $result['comments'];

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

    // マイページ詳細
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
            $this->editBlogInteractor->handle($input);
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
