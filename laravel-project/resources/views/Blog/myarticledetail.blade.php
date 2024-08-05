<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事詳細</title>
</head>
<body>
  <div class="detail">
    @include('blog.header')
    <div class="detail-title">
      <h3>{{ $blog->title }}</h3>
      <div class="detail-container">
        <p class="detail-date">{{ $blog->created_at }}</p>
        <p class="detail-content">{{ $blog->content}}</p>
      </div>
      <div class="detail-link">
        <a href="{{ route('edit', $blog->id) }}">編集</a>

        <form action="{{ route('destroy', $blog->id) }}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit">削除</button>
        </form>
        <a href="{{ route('mypage') }}">マイページへ</a>
      </div>
    </div>
  </div>
</body>
</html>