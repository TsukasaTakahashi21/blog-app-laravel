<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事詳細</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
  <link rel="stylesheet" href="{{ asset('css/favorite.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  @include('blog.header')
  <div class="container">
    <div class="detail-container">
      <div class="detail-title">
        <h3>{{ $blog->title }}</h3>
        <div class="favorite-section">
          <form action="{{ route('toggleFavorite', $blog->id) }}" method="post" class="favorite-form">
            @csrf 
            <button type="submit" class="favorite-button">
              @if (Auth::user()->favorites()->where('blog_id', $blog->id)->exists())
                <i class="fas fa-heart"></i>
              @else
                <i class="far fa-heart"></i>
              @endif
            </button>
          </form>
        </div>
      </div>
      <div class="detail-content-wrapper">
        <p class="detail-date">{{ $blog->created_at }}</p>
        <p class="detail-content">{{ $blog->content}}</p>
      </div>
      <div class="detail-link">
        <form action="{{ route('top') }}" method="get">
          @csrf 
          <button type="submit" class="button">一覧ページへ</button>
        </form>
      </div>
      <div class="comment-section">
        <h3 class="comment-title">この投稿にコメントしますか？</h3>
        @if ($errors->any())
        <div class="error-message">
          <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form action="{{ route('storeComment', $blog->id) }}" method="post" class="comment-form">
          @csrf 
          <label for="commenter_name" class="comment-label">コメント名</label><br>
          <input type="text" name="commenter_name" id="commenter_name" class="comment-input"><br>
          <label for="comments" class="comment-label">内容</label><br>
          <textarea name="comments" id="comments" class="comment-textarea"></textarea><br>
          <button type="submit" class="comment-button">コメント</button>
        </form>
      </div>
      <div class="comment-list">
        <h3 class="comment-list-title">コメント一覧</h3>
        @foreach($comments as $comment)
        <div class="comment-item">
          <p class="comment-text">{{ $comment->comments }}</p>
          <p class="comment-date">{{ $comment->created_at }}</p>
          <p class="comment-name">{{ $comment->commenter_name }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</body>
</html>
