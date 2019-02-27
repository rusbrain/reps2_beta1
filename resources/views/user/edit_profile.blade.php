@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('sidebar-left')
    @include('sidebar-widgets.votes')

    @include('sidebar-widgets.gosu-replays')
@endsection

@section('content')

    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="{{route('user_profile',['id' =>Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="#" class="active">/ Настройки пользователя</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <h1>настройки пользователя</h1>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form action="{{route('save_profile')}}" enctype="multipart/form-data" method="POST"
                      class="user-account-edit-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">*Имя:</label>
                        <input type="text" id="name" name="name" value="{{old('name')??$user->name}}"
                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="avatar">
                            <div class="margin-bottom-10">Аватар:</div>
                            @if($user->avatar)
                                <div class="preview-image-wrapper">
                                    <img class="" src="{{$user->avatar->link}}" alt="">
                                </div>
                            @endif
                        </label>
                        <input type="file" id="avatar"
                               class="form-control-file {{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                               name="avatar">
                        @if ($errors->has('avatar'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="country">Страна:</label>
                        <select name='country' id="country" size=1
                                class="custom-select {{ $errors->has('country') ? ' is-invalid' : '' }}">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" {{$country->id == old('country') ? ' selected' : '' }}>{{$country->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group form-group user-account-birthday">
                        <label for="birthday">Дата рождения:</label>
                        <input type="date" id="birthday"
                               class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" name="birthday"
                               value="{{old('birthday')??$user->birthday}}">
                        @if ($errors->has('birthday'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="site">Сайт:</label>
                        <input type="text" id="homepage"
                               class="form-control {{ $errors->has('homepage') ? ' is-invalid' : '' }}"
                               name="homepage"
                               value="{{old('homepage')??$user->homepage}}">

                        @if ($errors->has('homepage'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('homepage') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="isq">ISQ:</label>
                        <input type="text" id="isq" class="form-control {{ $errors->has('isq') ? ' is-invalid' : '' }}"
                               name="isq"
                               value="{{old('isq')??$user->isq}}">
                        @if ($errors->has('isq'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('isq') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="skype">Skype:</label>
                        <input type="text" id="skype"
                               class="form-control {{ $errors->has('skype') ? ' is-invalid' : '' }}"
                               name="skype"
                               value="{{old('skype')??$user->skype}}">
                        @if ($errors->has('skype'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('skype') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="signature">Подпись:</label>
                        <textarea name="signature" id="signature"
                                  class="form-control {{ $errors->has('signature') ? ' is-invalid' : '' }}"
                                  rows="10">{!! old('skype')??$user->signature !!}</textarea>
                        @if ($errors->has('signature'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('signature') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="mouse">Мышь:</label>
                        <input type="text" id="mouse"
                               class="form-control {{ $errors->has('mouse') ? ' is-invalid' : '' }}" name="mouse"
                               value="{{old('mouse')??$user->mouse}}">
                        @if ($errors->has('mouse'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('mouse') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="keyboard">Клавиатура:</label>
                        <input type="text" id="keyboard"
                               class="form-control {{ $errors->has('keyboard') ? ' is-invalid' : '' }}" name="keyboard"
                               value="{{old('keyboard')??$user->keyboard}}">
                        @if ($errors->has('keyboard'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('keyboard') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="headphone">Наушники:</label>
                        <input type="text" id="headphone"
                               class="form-control {{ $errors->has('headphone') ? ' is-invalid' : '' }}"
                               name="headphone"
                               value="{{old('headphone')??$user->headphone}}">
                        @if ($errors->has('headphone'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('headphone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="mousepad">Коврик:</label>
                        <input type="text" id="mousepad"
                               class="form-control {{ $errors->has('headphone') ? ' is-invalid' : '' }}" name="mousepad"
                               value="{{old('mousepad')??$user->mousepad}}">
                        @if ($errors->has('mousepad'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('mousepad') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="view_signs">Просматривать подписи на форуме:</label>
                        <input type="checkbox" id="view_signs"
                               class="{{ $errors->has('headphone') ? ' is-invalid' : '' }}" name="view_signs"
                               value="1" @if((old('view_signs')??$user->view_signs)) checked @endif >
                        @if ($errors->has('view_signs'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('view_signs') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="view_avatars">Просматривать аватары на форуме:</label>
                        <input type="checkbox" id="view_avatars"
                               class="{{ $errors->has('headphone') ? ' is-invalid' : '' }}" name="view_avatars"
                               value="1" @if((old('view_avatars')??$user->view_avatars)) checked @endif>
                        @if ($errors->has('view_avatars'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('view_avatars') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-blue btn-form">Сохранить</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div><!-- close div /.content-box -->
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection

@section('js')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script>
        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            if ($('#signature').length > 0) {
                var textarea = document.getElementById('signature');

                sceditor.create(textarea, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time'
                });
            }
        });
    </script>
@endsection