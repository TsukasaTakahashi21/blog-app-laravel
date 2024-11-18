<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\blog;
use App\Models\Category; 
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

    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request)
    {
        $input = new CreateBlogInput(
            new Title($request->title),
            new Content($request->content),
            $request['category'] ?? null,
            1 // デフォルトで公開状態に設定
        );

        try {
            $this->createBlogInteractor->handle($input); 

            return redirect()->route('mypage')->with('success', 'ブログが作成されました。');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->status = $blog->status == 0 ? 1 :0;
        $blog->save();

        return redirect()->route('mypage');
    }

    public function detail(int $id)
    {
        $input = new ListBlogDetailInput($id);
        $blog = $this->listBlogDetailInteractor->handle($input);

        return view('blog.detail',['blog' => $blog,
        'comments' => $blog->comments, ]);
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
            return redirect()->route('detail', ['id' => $id])->with('success', 'コメントが作成されました。');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    // マイページ詳細
    public function myPage()
    {
        $userId = Auth::id();
        $blogs = Blog::where('user_id', $userId)->get(); 

        return view('blog.mypage', compact('blogs'));
    }

    public function myArticleDetail(int $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->user_id !== Auth::id()) {
            return redirect()->route('mypage');
        }

        $input = new MyArticleDetailInput($id);
        $blog = $this->myArticleDetailInteractor->handle($input);

        return view('blog.myarticleDetail', compact('blog'));
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('signUp');
    }

    public function edit(int $id)
    {
        $blog = Blog::findOrFail($id);
        $blogCategoryId = $blog->categories()->pluck('category_id')->first();
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories', 'blogCategoryId'));
    }

    public function update(UpdateBlogRequest $request, int $id)
    {
        $input = new EditBlogInput(
            $id, 
            new Title($request->title), 
            new Content($request->content),
            $request->input('category') ?? null
        );

        try {
            $this->editBlogInteractor->handle($input);
            return redirect()->route('top')->with('success', 'ブログが更新されました。'); 
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    // ブログ削除
    public function destroy(int $id)
    {
        try {
            $input = new DeleteBlogInput($id);
            $this->deleteBlogInteractor->handle($input);
            return redirect()->route('mypage')->with('success', 'ブログを削除しました。');
        } catch  (\Exception $e) {
            return $this->handleError($e);
        }
    }

    private function handleError(\Exception $e)
    {
        return redirect()->back()->withErrors([
            'error' => $e->getMessage()
        ])->withInput();
    }
}
