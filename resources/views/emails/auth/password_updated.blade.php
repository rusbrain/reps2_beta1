@component('mail::message')
    Поздравляем!
    <br>
    Ваш пароль на сайте <a href="{{route('home')}}">reps.ru</a> обновлен.
    <br>
    @component('mail::button', ['url' => route('home')])
        На главную
    @endcomponent

    ![zerg]({{asset('/images/zerg.png')}})

@endcomponent