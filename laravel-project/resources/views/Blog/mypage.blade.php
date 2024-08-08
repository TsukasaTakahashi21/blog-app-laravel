<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
</head>
<body>
  @include('blog.header')
  <div class="main">
    <div class="main-title">
      <h1 class="main-title-text">マイページ</h1>
    </div>
    <div class="create-new">
      <a href="{{ route('create') }}" class="create-new-link">新規作成</a>
    </div>

    <div class="blog-list">
      @foreach($blogs as $blog)
      <div class="blog-item">
        <h2 class="blog-item-title">{{ $blog-> title }}</h2>
        <p class="blog-item-date">{{ $blog-> created_at }}</p>
        <p class="blog-item-content">{{ Str::limit($blog-> content, 15) }}</p>
        <a href="{{ route('myarticleDetail', $blog->id) }}" class="blog-item-detail-link">記事詳細へ</a>
      </div>
      @endforeach
    </div>
  </div>
</body>
</html>