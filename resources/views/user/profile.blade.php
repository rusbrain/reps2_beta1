@extends('layouts.site')

@section('content')
    <div class="profile-page">
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
                        <span class="key">У Вас нет Аватара</span>
                    @endif
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <span class="key">Темы:</span>
            </div>
            <div class="col-8">
                <span class="value"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <span class="key">Посты:</span>
            </div>
            <div class="col-8">
                <span class="value"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <span class="key">Госу реплеи:</span>
            </div>
            <div class="col-8">
                <span class="value"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <span class="key">Пользовательские реплеи:</span>
            </div>
            <div class="col-8">
                <span class="value"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <span class="key">Посты к реплеям:</span>
            </div>
            <div class="col-8">
                <span class="value"></span>
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
@endsection