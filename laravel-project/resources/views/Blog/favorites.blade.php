<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog一覧</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
</head>
<body>
  @include('blog.header')
  <div class="container">
    <div class="main-title">
      <h1 class="main-title-text">お気に入り一覧</h1>
    </div>
    @if ($favorites->isEmpty())
      <p>お気に入りの投稿はまだありません。</p>
    @else
        <div class="blog-list">
          @foreach($favorites as $blog)
            <div class="blog-item">
              <h2 class="blog-item-title">{{ $blog->title }}</h2>
              <p class="blog-item-date">{{ $blog->created_at }}</p>
              <p class="blog-item-content">{{ Str::limit($blog->content, 15) }}</p>
              <a href="{{ route('detail', $blog->id) }}" class="blog-item-detail-link">記事詳細へ</a>
            </div>
          @endforeach
        </div>
    @endif
  </div>
</body>
</html>