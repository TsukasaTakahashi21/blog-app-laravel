<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\UseCase\User\SignUp\RegisterInput;
use App\UseCase\User\SignUp\RegisterInteractor;
use App\UseCase\User\SignIn\LoginInput;
use App\UseCase\User\SignIn\LoginInteractor;
use Exception;

class UserController extends Controller
{
    private $registerInteractor;
    private $loginInteractor;

    public function __construct(RegisterInteractor $registerInteractor, LoginInteractor $loginInteractor)
    {
        $this->registerInteractor = $registerInteractor;
        $this->loginInteractor = $loginInteractor;
    }

    public function signUp()
    {
        return view('user.register');
    }

    public function signIn()
    {
        return view('user.login');
    }

    public function register(RegisterRequest $request)
    {
        $input = new RegisterInput(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );

        try {
            $this->registerInteractor->handle($input);
            return redirect()->route('login');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    public function login(LoginRequest $request)
    {
        $input = new LoginInput(
            $request->input('email'),
            $request->input('password')
        );

        try {
            $user = $this->loginInteractor->handle($input);
    
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
            ]);

            return redirect()->route('top');
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }

    private function handleError(Exception $e)
    {
        return redirect()->back()->withErrors([
            'error' => $e->getMessage()
        ])->withInput();
    }
}
