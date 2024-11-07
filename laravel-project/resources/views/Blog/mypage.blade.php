<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
</head>
<body>
  @include('blog.header')
  <div class="container">
    <div class="main-title">
      <h1 class="main-title-text">マイページ</h1>
    </div>
    <div class="create-new">
      <a href="{{ route('create') }}" class="create-new-link">新規作成</a>
    </div>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->has('delete_blog_error'))
      <div class="alert alert-danger">
        {{ $errors->first('delete_blog_error') }}
      </div>
    @endif

    <div class="blog-list">
      @foreach($blogs as $blog)
      <div class="blog-item">
        <h2 class="blog-item-title">{{ $blog-> title }}</h2>
        <p class="blog-item-date">{{ $blog-> created_at }}</p>
        <p class="blog-item-content">{{ Str::limit($blog-> content, 15) }}</p>

        <form action="{{ route('toggleStatus', $blog->id) }}" method="POST">
          @csrf 
          <button type = "submit" class="toggle-button">
            {{ $blog->status == 1 ? '非公開にする' : '公開にする' }}
          </button>
        </form>
        <a href="{{ route('myarticleDetail', $blog->id) }}" class="blog-item-detail-link">記事詳細へ</a>
      </div>
      @endforeach
    </div>
  </div>
</body>
</html>