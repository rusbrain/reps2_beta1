@component('mail::message')
    Вам необходимо обновить пароль на сайте <a href="{{route('home')}}">reps.ru</a>
    <br>
    Для обновления пароля перейдите <a class="" href="{{route('update_old_password', ['token'=>$token])}}">по ссылке</a>
    <br>
    @component('mail::button', ['url' => route('update_old_password', ['token'=>$token])])
        Обновить пароль
    @endcomponent
@endcomponent