<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\blog;
use App\Models\Category; 
use App\Models\Comment;
use App\UseCase\Blog\CreateBlogInput;
use App\UseCase\Blog\CreateBlogInteractor;
use App\UseCase\Blog\EditBlogInput;
use App\UseCase\Blog\EditBlogInteractor;
use App\UseCase\Blog\ListBlogsInput;
use App\UseCase\Blog\ListBlogsInteractor;
use App\UseCase\Blog\ListBlogDetailInput;
use App\UseCase\Blog\ListBlogDetailInteractor;
use App\UseCase\Blog\MyArticleDetailInput;
use App\UseCase\Blog\MyArticleDetailInteractor;
use App\UseCase\Blog\DeleteBlogInput;
use App\UseCase\Blog\DeleteBlogInteractor;
use App\UseCase\Blog\CreateCommentInput;
use App\UseCase\Blog\CreateCommentInteractor;

use App\ValueObject\Title;
use App\ValueObject\Content;
use App\ValueObject\CommenterName;
use App\ValueObject\Comments;


class BlogController extends Controller
{

    // 絞り込み機能
    public function top(Request $request)
    {
        $keyword = $request->query('keyword');
        $sort = $request->query('sort');
        $categoryId = $request->query('category');

        $input = new ListBlogsInput(
            $keyword,
            $sort,
            $categoryId 
        );

        $interactor = new ListBlogsInteractor();
        $blogs = $interactor->handle($input);

        // 全ての投稿のうち、公開状態のものだけを表示
        $blogs = $blogs->filter(function ($blog) {
            return $blog->status == 1;
        });

        // カテゴリで絞り込む
        if ($categoryId) {
            $blogs = $blogs->filter(function ($blog) use ($categoryId) {
                return $blog->categories->contains('id', $categoryId);
            });
        }

        $categories = Category::all();

        return view ('blog.top', compact('blogs', 'categories'));
    }

    public function header()
    {
        return view('blog.header');
    }

    // ブログ作成
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'nullable|integer',
            'title' => 'required|max:255',
            'content' => 'required'
        ], [
            'title.required' => 'タイトルを入力してください',
            'content.required' => '内容を入力してください'
        ]);

        $input = new CreateBlogInput(
            new Title($validated['title']),
            new Content($validated['content']),
            $validated['category'] ?? null,
            1 // デフォルトで公開状態に設定
        );

        try {
            $interactor = new CreateBlogInteractor();
            $blog = $interactor->handle($input); 

            return redirect()->route('mypage');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'create_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->status = $blog->status == 0 ? 1 :0;
        $blog->save();

        return redirect()->route('mypage');
    }

    // ブログ詳細
    public function detail()
    {
        return view('blog.detail');
    }

    public function showDetail($id)
    {
        $input = new ListBlogDetailInput($id);
        $interactor = new ListBlogDetailInteractor();
        $result = $interactor->handle($input);

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

        $input = new CreateCommentInput(
            Auth::id(),
            $id,
            new CommenterName($validated['commenter_name']),
            new Comments($validated['comments']),
        );

        try {
            $interactor = new CreateCommentInteractor();
            $interactor->handle($input);
            return redirect()->route('detail', ['id' => $id]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'create_comment_error' => $e->getMessage()
            ])->withInput();
        }
    }

    // マイページ詳細
    public function mypage()
    {
        $userId = Auth::id();// ログインユーザーのIDを取得
        $blogs = Blog::where('user_id', $userId)->get(); // ログインユーザーの作成した記事のみ取得

        return view('blog.mypage', compact('blogs'));
    }

    public function showMyarticleDetail($id)
    {
        $blog = BLog::findOrFail($id);

        if ($blog->user_id !== Auth::id()) {
            return redirect()->route('mypage');
        }

        $input = new MyArticleDetailInput($id);
        $interactor = new MyArticleDetailInteractor();
        $result = $interactor->handle($input);

        $blog =$result['blog'];

        return view('blog.myarticleDetail', compact('blog'));
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('signUp');
    }

    // ブログ編集
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $blogCategoryId = DB::table('blog_category')
        ->where('blog_id', $id)
        ->value('category_id');
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories', 'blogCategoryId'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|integer',
        ]);

        $input = new EditBlogInput(
            $id, 
            new Title($validated['title']), 
            new Content($validated['content']),
            $validated['category'] ?? null
        );

        try {
            $interactor = new EditBlogInteractor();
            $interactor->handle($input);
            return redirect()->route('top'); 
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'edit_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    // ブログ削除
    public function destroy($id)
    {
        $input = new DeleteBlogInput($id);
        $interactor = new DeleteBlogInteractor();
        $interactor->handle($input);
        return redirect()->route('mypage');
    }
}
