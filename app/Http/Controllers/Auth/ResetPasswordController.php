<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveNewPasswordRequest;
use App\Mail\UpdateOldUserPassword;
use App\UserEmailToken;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOldPassword(Request $request)
    {
        $user = $request->session()->get('user');

        if(!$user){
            return back();
        }

        $token = md5(time());

        UserEmailToken::create(
            [
                'user_id' => $user->id,
                'function' => UserEmailToken::TOK_FUNC_VERIFIED_EMAIL,
                'token' => $token
            ]
        );

        Mail::to($user->email)->send(new UpdateOldUserPassword($token));

        return view('auth.passwords.update_old')->with('email', $user->email);
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewNewPassword($token)
    {
        if (UserEmailToken::where('token',$token)->where('function', UserEmailToken::TOK_FUNC_UPDATE_PASSWORD)->count()){
            return view('auth.passwords.new')->with('update_email_token', $token);
        }

        return view('auth.passwords.not_correct_token');
    }

    /**
     * @param SaveNewPasswordRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function saveNewPassword(SaveNewPasswordRequest $request)
    {
        if( $user = UserEmailToken::where('token',$request->get('password_update_token'))->where('function', UserEmailToken::TOK_FUNC_UPDATE_PASSWORD)->first()->user()->first()) {
            $user->password = Hash::make($request->get('password'));
            $user->updated_password = true;
            $user->save();

            Mail::to($user->email)->send(new UpdateOldUserPassword());

            return redirect('/');
        }

        return view('auth.passwords.not_correct_token');
    }
}
