<?php
namespace App\UseCase\User\SignUp;

use App\Models\User;
use App\UseCase\User\SignUp\RegisterInput;
use Illuminate\Support\Facades\Hash;

class RegisterInteractor
{
  public function handle(RegisterInput $input) 
  {
    $user = new User();
    $user->name = $input->getName();
    $user->email = $input->getEmail();
    $user->password = Hash::make($input->getPassword());
    $user->save();
  }
}