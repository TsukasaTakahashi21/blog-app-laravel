<?php
namespace App\UseCase\User\SignUp;

use App\Models\User;
use App\UseCase\User\SignUp\RegisterInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class RegisterInteractor
{
  public function handle(RegisterInput $input) 
  {
    try {
      $user = new User();
      $user->name = $input->getName();
      $user->email = $input->getEmail();
      $user->password = Hash::make($input->getPassword());
      $user->save();
    } catch (QueryException $e) {
      throw new \Exception('ユーザー登録に失敗しました。');
    }
  }
}