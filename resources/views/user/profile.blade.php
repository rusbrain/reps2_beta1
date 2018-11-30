@extends('layouts.site')

@section('content')
    <div class="row">
        @if(Auth::user() && Auth::id() != $user->id)
            @include('user.inner_user_sidebar')
        @endif
        @if(!Auth::user())
            @include('user.inner_user_sidebar')
        @endif
        <div class="col-md-9 border-gray">
            <div class="profile-page ">
                <div class="page-title row">Профайл пользователя</div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Имя:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->name}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Страна:</span>
                    </div>
                    <div class="col-8">
                        @if($user->country)
                            <span class="value">{{$user->country->name}}</span>
                        @endif
                    </div>
                </div>
                <div class="row profile-avatar-row">
                    <div class="col-4">
                        <span class="key">Аватар:</span>
                    </div>
                    <div class="col-8">
                <span class="value">
                    @if($user->avatar)
                        <img class="img-responsive profile-avatar" src="{{$user->avatar->link}}" alt="">
                    @else
                        <span class="key">Аватар отсутствует</span>
                    @endif
                </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Посты:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->topics_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Госу реплеи:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->gosu_replay_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Пользовательские реплеи:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->replay_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Госу реплеи:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->gosu_replay_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Посты к реплеям:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->replay_comments_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Посты к реплеям:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->replay_comments_count}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">E-mail:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->email}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Дата рождения:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->birthday}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">WWW:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->homepage}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">ICQ:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->isq}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Skype:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->skype}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Мышь:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->mouse}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Коврик:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->mousepad}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Клавиатура:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->keyboard}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Наушники:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->headphone}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Репутация:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{{$user->rating}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <span class="key">Подпись:</span>
                    </div>
                    <div class="col-8">
                        <span class="value">{!! $user->signature !!}</span>
                    </div>
                </div>
            </div>
            @if(Auth::user() && Auth::id() != $user->id)
                <div class="user-profile-actions">
                    <a href="{{route('user.messages',['id' => $user->id])}}">Отправить личное сообщение</a>
                    <a href="{{route('user.add_friend',['id'=>$user->id])}}">Добавить в друзья</a>
                    <a href="{{route('user.set_ignore',['id'=>$user->id])}}">Добавить в игнор лист</a>
                </div>
            @endif

        </div>
    </div>
@endsection