<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Mail\RegisteredUser;
use App\Replay;
use App\Services\Base\UserActivityLogService;
use App\User;
use App\Http\Controllers\Controller;
use App\UserEmailToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Rules\Captcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $races = implode(",", Replay::$races);
        return Validator::make($data,
            [
                'name'      => 'required|max:30',
                'email'     => 'required|string|email|max:30|unique:users',
                'race'      => 'required|in:'.$races,
                'password'  => 'required|string|min:8|max:255|confirmed',
                'country'   => 'required|exists:countries,id',
                'g-recaptcha-response' => new Captcha()
            ],
            [
                'race.required'      => 'Раса обязательна для заполнения.',
                'race.in'            => 'Не верно указана расса',
                'password.required'  => 'Не указан новый пароль.',
                'password.confirmed' => 'Пароль не подтвержден или подтвержден не верно.',
                'password.min'       => 'Минимальная длина пароля 8 символов.',
                'password.max'       => 'Максимальная длина пароля 255 символов.',
                'name.required'      => 'Не указно имя.',
                'name.max'           => 'Максимальная длина имени 30 символов.',
                'email.required'     => 'Email обязательный для заполнения.',
                'email.email'        => 'Введен не верный формат Email.',
                'email.unique'       => 'Пользователь с таким Email уже зарегестрирован.',
                'email.max'          => 'Максимальная длина Email 30 символов.',
                'country.exists'     => 'Не верно указана страна.',
                'country.required'   => 'Страна обязательна для заполнения.',
                'recaptcha'=>'Please ensure that you are a human!'
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $recaptcha = $request['g-recaptcha-response'];
      
        // $captchaSecretkey = env("CAPTCHA_SECRET_KEY");
        // // verify
        // $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captchaSecretkey.'&response='.$recaptcha);
        // $responseData = json_decode($verifyResponse);
        
        // if(!$responseData->success) {
        //     return redirect()->back()->withInput($request->all())->with("status", " Google recaptcah verify is failed.");
        // }
        $data_save = [
            'name' => $data['name'],
            'email' => $data['email'],
            'race' => $data['race'],
            'password' => Hash::make($data['password']),
            'user_role_id' => 0,
            'updated_password' => 1
        ];

        if (isset($data['country']) && $data['country'] > 0) {
            $data_save['country_id'] = $data['country'];
        }

        $newUser = User::create($data_save);

        UserActivityLogService::log(UserActivityLogService::EVENT_USER_REGISTER, null, $newUser->id);

        return $newUser;
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register')->with('countries', Country::all());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        Mail::send(new RegisteredUser($user));

        $this->guard()->logout($user);
        return redirect()->route('notification',['notification' => "Вы успешно зарегистрировались! Для дальнейшего использования сайта подтвердите вашу почту. Ссылка отправлена на указанный email"]);
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function emailVerified($token)
    {
        try {
            /**@var UserEmailToken $email_token*/
            $email_token = UserEmailToken::where('token', $token)->where('function', UserEmailToken::TOK_FUNC_VERIFIED_EMAIL)->first();
            if (!$email_token) {
                throw new \DomainException('Неверная ссылка');
            }
            /**@var User $user*/
            $user = $email_token->user()->first();

            if($user->email_verified_at){
                throw new \DomainException('Ваш email уже подтвержден');
            }
            $user->email_verified_at = Carbon::now();
            $user->save();
            $this->guard()->login($user);

            UserActivityLogService::log(UserActivityLogService::EVENT_USER_REGISTER_CONFIRM, null, $user->id);

            return redirect('/');

        } catch (\DomainException $e) {
            return redirect()->route('error',['error' => $e->getMessage()]);
        }
    }

}
