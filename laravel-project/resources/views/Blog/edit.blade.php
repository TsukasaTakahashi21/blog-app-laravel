<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集</title>
</head>
<body>
  <div class="edit-container">
    @include('blog.header')

    @if ($errors->any())
    <div class="error-message">
      <ul>
        @foreach($errors ->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('update', $blog->id) }}" method="post" class="edit-form">
      @csrf
      @method('put')
      <div class="edit-field">
        <label for="title">タイトル</label>
        <!-- 古い入力値（old('title')）がある場合はそれを表示し、なければデフォルトでブログのタイトル（$blog->title）を表示 -->
        <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" class="edit-input">
      </div>
      <div class="edit-field">
        <label for="content">内容</label>
        <!-- 古い入力値（old('content')）がある場合はそれを表示し、なければデフォルトでブログの内容（$blog->content）を表示 -->
        <textarea  id="content" name="content" class="edit-textarea">{{ old('content', $blog->content) }}</textarea>
      </div>
      <button type="submit" class="edit-button">編集</button>
    </form>
  </div>
</body>
</html>