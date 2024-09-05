<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/create-edit.css') }}">
</head>
<body>
  @include('blog.header')
  
  <div class="container">
    <div class="container-title">
      <h2>編集</h2>
    </div>

    @if ($errors->any())
    <div class="error-message">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('update', $blog->id) }}" method="post" class="submit-form">
      @csrf
      @method('put')
      <div class="form-group">
        <label for="category">カテゴリ</label>
        <select name="category" id="category" class="form-input">
          <option value="">カテゴリを選択してください</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ $blogCategoryId == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $blog->title) }}">
      </div>

      <div class="form-group">
        <label for="content">内容</label>
        <textarea name="content" id="content" class="form-textarea">{{ old('content', $blog->content) }}</textarea>
      </div>
      <button type="submit" class="form-button">編集</button>
    </form>
  </div>
</body>
</html>
