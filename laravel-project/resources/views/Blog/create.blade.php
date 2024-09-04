<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
        <label for="category">カテゴリ</label>
        <select name="category" id="category" class="form-input">
          <option value="">カテゴリを選択してください</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
        </select>
      </div>
    
      <div class="form-group">
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}">
      </div>

      <div class="form-group">
        <label for="content">内容</label>
        <textarea name="content" id="content" class="form-textarea">{{ old('content') }}</textarea>
      </div>
      <button type="submit" class="form-button">新規作成</button>
    </form>
  </div>
</body>
</html>