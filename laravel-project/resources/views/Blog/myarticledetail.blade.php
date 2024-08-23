<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事詳細</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/myarticledetail.css') }}">
</head>
<body>
  @include('blog.header')
  <div class="container">
    <div class="article-detail">
      <h3 class="article-title">{{ $blog->title }}</h3>
      <div class="article-content-wrapper">
        <p class="article-date">{{ $blog->created_at }}</p>
        <p class="article-content">{{ $blog->content }}</p>
      </div>
      <div class="article-actions">
        <a href="{{ route('edit', $blog->id) }}" class="button">編集</a>
        <form action="{{ route('destroy', $blog->id) }}" method="post" class="delete-form">
          @csrf
          @method('DELETE')
          <button type="submit" class="button delete-button">削除</button>
        </form>
        <a href="{{ route('mypage') }}" class="button">マイページへ</a>
      </div>
    </div>
  </div>
</body>
</html>
