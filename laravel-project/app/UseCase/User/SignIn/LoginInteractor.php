<?php
namespace App\UseCase\User\SignIn;

use Illuminate\Support\Facades\Auth;
use App\UseCase\User\SignIn\LoginInput;

class LoginInteractor
{
  public function handle(LoginInput $input) 
  {
    $loginData = [
      'email' => $input->getEmail(),
      'password' => $input->getPassword()
    ];

    // 2. ユーザー認証の試行
    if (!Auth::attempt($loginData)) {
        throw new \Exception('メールアドレスまたはパスワードが違います');
    }

    return Auth::user();
  }
}