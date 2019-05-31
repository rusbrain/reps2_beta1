<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Mail\RegisteredUser;
use App\Replay;
use App\User;
use App\Http\Controllers\Controller;
use App\UserEmailToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

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
                'name'      => 'required|max:255',
                'email'     => 'required|string|email|max:255|unique:users',
                'race'      => 'required|in:'.$races,
                'password'  => 'required|string|min:8|max:255|confirmed',
                'country'   => 'nullable|exists:countries,id',
            ],
            [
                'race.required'      => 'Раса обязательна для заполнения.',
                'race.in'            => 'Не верно указана расса',
                'password.required'  => 'Не указан новый пароль.',
                'password.confirmed' => 'Пароль не подтвержден или подтвержден не верно.',
                'password.min'       => 'Минимальная длина пароля 8 символов.',
                'password.max'       => 'Максимальная длина пароля 255 символов.',
                'name.required'      => 'Не указно имя.',
                'name.max'           => 'Максимальная длина имени 255 символов.',
                'email.required'     => 'Email обязательный для заполнения.',
                'email.email'        => 'Введен не верный формат Email.',
                'email.unique'       => 'Пользователь с таким Email уже зарегестрирован.',
                'email.max'          => 'Максимальная длина Email 255 символов.',
                'country.exists'     => 'Не верно указана страна.',
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

        return User::create($data_save);
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

        return redirect()->route('edit_profile');
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

            return redirect('/');

        } catch (\DomainException $e) {
            return redirect()->route('error',['error' => $e->getMessage()]);
        }
    }

}
