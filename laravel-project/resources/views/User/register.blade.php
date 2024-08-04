<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員登録</title>
</head>
<body>
  <main class="user">
    <div class="user-inner">
      <h1 class="title">会員登録</h1>
      <!-- エラーメッセージ -->
      @if ($errors->any())
      <div class="error-messages">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <!-- 会員登録フォーム -->
      <form action="{{ route('register') }}" method="post" class="form">
        @csrf 
        <!-- UserName -->
        <input type="text" class="input" name="name" id="name" placeholder="UserName" Value="{{ old('name')}}"><br>
        <!-- Email -->
        <input type="email" class="input" name="email" id="email" placeholder="Email" Value="{{ old('email') }}"><br>
        <!-- パスワード -->
        <input type="password" class="input" name="password" id="password" placeholder="Password"><br>
        <!-- パスワード確認 -->
        <input type="password" class="input" name="password_confirmation" id="password_confirmation" placeholder="Password確認"><br>
        <button type="submit" class="button">アカウント作成</button>
      </form>
      <a href="{{ route('signIn') }}" class="user-link">ログイン画面へ</a>
    </div>
  </main>
</body>
</html>