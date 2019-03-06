@component('mail::message')
    Вы зарегистрировались на сайте <a href="{{route('home')}}">reps.ru</a>
    <br>
    Пожалуйста, подтвердите Вашу почту
    <br>
    Для подтверждения почты, пожалуйста, пройдите <a class="" href="{{ route('email_verified', ['token'=>$token])}}">по ссылке</a>
    <br>
    @component('mail::button', ['url' => route('email_verified', ['token'=>$token]),])
        Подтвердить почту
    @endcomponent

    Спасибо,
    {{ config('app.name') }}
@endcomponent