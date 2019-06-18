<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * User login
     *
     * @param UserLoginRequest $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userLogin(UserLoginRequest $request)
    {
        /**if true - redirect to password recovering*/
        if (User::getOld($request->get('email'))) {
            return redirect()->route('password.request');
        }
        $this->login($request);

        if (Auth::user()->is_ban) {
            /**if is ban*/
            if($this->logout($request, true)){
                return redirect()->route('error',
                    ['error' => 'Ваш аккаунт заблокирован, для выяснения причин обращайтесь к администрации сайта']);
            }
        }

        if (!Auth::user()->email_verified_at) {
            /**if is not verified*/
            if($this->logout($request, true)){
                return redirect()->route('error',
                    ['error' => 'Ваш аккаунт не подтверждён, для подвтерждения перейдите по ссылке , которая пришла к вам на почту, или обращайтесь к администрации сайта']);
            }
        }

        return redirect('/');
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email|exists:users,email',
            'password' => 'required|string',
        ], [
            $this->username() . '.required' => 'Не указан E-mail',
            $this->username() . '.email' => 'Не верно указана почта',
            $this->username() . '.exist' => 'Пользователя с указаной почьтой не существует',
            'password.required' => 'Не указан пароль',
            'password.string' => 'Пароль должен быть строкой',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $is_ban
     * @return bool|\Illuminate\Http\Response
     */
    public function logout(Request $request, $is_ban = false)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        if($is_ban == true){
            return true;
        }
        return redirect('/');
    }
}
