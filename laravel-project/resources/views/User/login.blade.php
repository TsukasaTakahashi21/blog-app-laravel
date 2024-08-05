<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
</head>
<body>
  <div class="user">
    <div class="user-inner">
      <h1 class="title">ログイン</h1>
      <!-- エラーメッセージ -->
      @if ($errors->has('login_error'))
        <div class="error-messages">
          <ul>
            @foreach ($errors->get('login_error') as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- ログインフォーム -->
      <form action="{{ route('login') }}" method="post" class="form">
        @csrf 
        <!-- Email -->
        <input type="email" class="input" name="email" id="email" placeholder="Email" value="{{ old('email') }}"><br>
        <!-- Password -->
        <input type="password" class="input" name="password" id="password" placeholder="Password"><br>
        <button type="submit" class="button">ログイン</button>
      </form>
      <a href="{{ route('signUp') }}" class="user-link">アカウントを作る</a>
    </div>
  </div>
</body>
</html>