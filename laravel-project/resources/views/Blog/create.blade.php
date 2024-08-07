<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  @include('blog.header')
  <div class="create-container">
    <h2>新規記事</h2>
    @if ($errors->any())
    <div class="error-message">
      <ul>
        @foreach($errors ->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    
    <form action="{{ route('store') }}" method="post" class="create-form">
      @csrf
      <div class="form-group">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}">
      </div>
      <div class="form-group">
        <label for="content">内容</label>
        <textarea name="content" id="content" class="form-textarea">{{ old('content') }}</textarea>
      </div>
      <div class="button">
        <button type="submit" class="submit-button">新規作成</button>
      </div>
    </form>
  </div>
</body>
</html>