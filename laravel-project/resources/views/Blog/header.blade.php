<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ヘッダー</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>
  <div class="header-container">
    <div class="header-title">
      <h2>こんにちは！{{ session('user_name') }}さん</h2>
    </div>
    <div class="nav">
      <ul class="nav-list">
        <li><a href="{{ route('top') }}" class="navigation-link">ホーム</a></li>
        <li><a href="{{ route('mypage') }}" class="navigation-link">マイページ</a></li>
        <li><a href="{{ route('logout') }}" class="navigation-link">ログアウト</a></li>
      </ul>
    </div>
  </div>
</body>
</html>