<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事詳細</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/myarticledetail.css') }}">
</head>
<body>
  @include('blog.header')
  <div class="my-article-detail-container">
    <div class="my-article-detail-title">
      <h3>{{ $blog->title }}</h3>
      <div class="my-article-detail-content-wrapper">
        <p class="my-article-detail-date">{{ $blog->created_at }}</p>
        <p class="my-article-detail-content">{{ $blog->content}}</p>
      </div>
      <div class="my-article-detail-link">
        <a href="{{ route('edit', $blog->id) }}" class="button">編集</a>

        <form action="{{ route('destroy', $blog->id) }}" method="post" class="my-article-delete-form">
          @csrf
          @method('DELETE')
          <button type="submit" class="button">削除</button>
        </form>
        <a href="{{ route('mypage') }}" class="button">マイページへ</a>
      </div>
    </div>
  </div>
</body>
</html>