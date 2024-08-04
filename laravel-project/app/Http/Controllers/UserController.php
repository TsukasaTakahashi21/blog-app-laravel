<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\UseCase\User\SignUp\RegisterInput;
use App\UseCase\User\SignUp\RegisterInteractor;

class UserController extends Controller
{
    public function signUp()
    {
        return view('user.register');
    }

    public function signIn()
    {
        return view('user.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'name.required' => 'UserNameの入力がありません',
            'email.required' => 'Emailの入力がありません',
            'email.unique' => 'すでに保存されているメールアドレスです。',
            'password.required' => 'Passwordの入力がありません',
            'password.confirmed' => 'パスワードが一致しません',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = new RegisterInput(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );

        $interactor = new RegisterInteractor();
        $interactor->handle($input);

        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'パスワードとメールアドレスを入力してください',
            'email.email' => '有効なメールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください'
        ]);

        // 1. ユーザー情報の取得
        $userInfo = $request->only('email', 'password');

        // 2. ユーザー認証の試行
        if (!Auth::attempt($userInfo)) {
            return redirect()->back()->withErrors([
                'login_error' => 'メールアドレスまたはパスワードが違います'
            ]);
        } 
         // 認証されているユーザーの情報を取得
        $user = Auth::user();

        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
        ]);

        return redirect()->route('top');
    }
}
