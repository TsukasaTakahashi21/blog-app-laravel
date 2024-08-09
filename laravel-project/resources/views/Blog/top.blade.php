<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog一覧</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
  @include('blog.header')
  <div class="main">
    <div class="main-title">
      <h1 class="main-title-text">blog一覧</h1>
    </div>
    <!-- 絞り込み機能 -->
    <div class="filter-section">
      <form action="{{ route('top') }}" method="get" class="search-form">
        @csrf 
        <!-- キーワード検索 -->
        <input type="text" name="keyword" class ="search-input" placeholder="キーワードを入力" value="{{ request('keyword') }}">
        <!-- ソート順 -->
        <div class="sort-options">
          <input type="radio" name="sort" value="newest" {{ request('sort') == 'newest' ? 'checked' : '' }}>新着順
          <input type="radio" name="sort" value="oldest" {{ request('sort') == 'oldest' ? 'checked' : '' }}>古い順<br>
        </div>
        <button type="submit" class="search-button">検索</button>
      </form>
    </div>

    <!-- blog一覧表示 -->
    <div class="blog-list">
    @foreach($blogs as $blog)
      <div class="blog-item">
        <h2 class="blog-item-title">{{ $blog->title }}</h2>
        <p class="blog-item-date">{{ $blog->created_at }}</p>
        <p class="blog-item-content">{{ Str::limit($blog->content, 15) }}</p>
        <a href="{{ route('detail', $blog->id) }}" class="blog-item-detail-link">記事詳細へ</a>
      </div>
    @endforeach
    </div>
  </div>
</body>
</html>