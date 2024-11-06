<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateBlogRequest;
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
    private $createBlogInteractor;
    private $editBlogInteractor;
    private $listBlogsInteractor;
    private $listBlogDetailInteractor;
    private $myArticleDetailInteractor;
    private $deleteBlogInteractor;
    private $createCommentInteractor;
    
    public function __construct(
        CreateBlogInteractor $createBlogInteractor,
        EditBlogInteractor $editBlogInteractor,
        ListBlogsInteractor $listBlogsInteractor,
        ListBlogDetailInteractor $listBlogDetailInteractor,
        MyArticleDetailInteractor $myArticleDetailInteractor,
        DeleteBlogInteractor $deleteBlogInteractor,
        CreateCommentInteractor $createCommentInteractor
    ) {
        $this->createBlogInteractor = $createBlogInteractor;
        $this->editBlogInteractor = $editBlogInteractor;
        $this->listBlogsInteractor = $listBlogsInteractor;
        $this->listBlogDetailInteractor = $listBlogDetailInteractor;
        $this->myArticleDetailInteractor = $myArticleDetailInteractor;
        $this->deleteBlogInteractor = $deleteBlogInteractor;
        $this->createCommentInteractor = $createCommentInteractor;
    }

    // 絞り込み機能
    public function filterBlogs(Request $request)
    {
        $keyword = $request->query('keyword');
        $sort = $request->query('sort');
        $categoryId = $request->query('category');

        $input = new ListBlogsInput(
            $keyword,
            $sort,
            $categoryId 
        );

        $blogs = $this->listBlogsInteractor->handle($input);
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

    public function store(StoreBlogRequest $request)
    {
        $input = new CreateBlogInput(
            new Title($request->title),
            new Content($request->content),
            $validated['category'] ?? null,
            1 // デフォルトで公開状態に設定
        );

        try {
            $this->createBlogInteractor->handle($input); 

            return redirect()->route('mypage')->with('success', 'ブログが作成されました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'create_blog_error' => $e->getMessage()
            ])->withInput()->with('error', 'ブログ作成に失敗しました。');
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
        $result = $this->listBlogDetailInteractor->handle($input);

        $blog = $result['blog'];
        $comments = $result['comments'];

        return view('blog.detail', compact('blog', 'comments'));
    }

    public function storeComment(StoreCommentRequest $request, $id)
    {
        $input = new CreateCommentInput(
            Auth::id(),
            $id,
            new CommenterName($request->commenter_name),
            new Comments($request->comments),
        );

        try {
            $this->createCommentInteractor->handle($input);
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
        $result = $this->myArticleDetailInteractor->handle($input);

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

    public function update(UpdateBlogRequest $request, $id)
    {

        $input = new EditBlogInput(
            $id, 
            new Title($request->title), 
            new Content($request->content),
            $validated['category'] ?? null
        );

        try {
            $this->editBlogInteractor->handle($input);
            return redirect()->route('top'); 
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'edit_blog_error' => $e->getMessage()
            ])->withInput();
        }
    }

    // ブログ削除
    public function destroy(int $id)
    {
        $input = new DeleteBlogInput($id);
        $this->deleteBlogInteractor->handle($input);
        return redirect()->route('mypage');
    }
}
