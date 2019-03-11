@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

<?php
$countries = $general_helper->getCountries();
$races = \App\Replay::$races;
$maps = $general_helper->getReplayMaps();
$types = $general_helper->getReplayTypes();
$game_versions = $general_helper->getGameVersion();
?>

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.search-replay-form')
    <!-- END All Forum Topics -->
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
                    <a href="#" class="active">/ Создать новый Replay</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Создать новый Replay</div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form action="{{route('replay.store')}}" method="POST" enctype="multipart/form-data"
                      class="user-create-replay-form">
                    @csrf
                    <div class="form-fields-box">
                        <div class="form-group">
                            <label for="title">* Название:</label>
                            <input type="text" id="title" value="{{old('title')}}" name="title"
                                   class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback">
                                <strong>{{$errors->first('title')}}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_replay">* Пользовательский/Gosu:</label>
                                    <select class="custom-select {{ $errors->has('user_replay') ? ' is-invalid' : '' }}"
                                            id="user_replay" name="user_replay">
                                        <option value="0" {{0 == old('user_replay')?'selected':''}}>Госу
                                        </option>
                                        <option value="1" {{1 == old('user_replay')?'selected':''}}>
                                            Пользовательский
                                        </option>
                                    </select>
                                    @if ($errors->has('user_replay'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('user_replay') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_id">* Тип:</label>
                                    <select class="custom-select {{ $errors->has('type_idy') ? ' is-invalid' : '' }}"
                                            id="type_id" name="type_id">
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" {{$type->id == old('type_id')?'selected':''}}>
                                                {{$type->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('type_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="map_id">* Карта:</label>
                            <select class="custom-select {{ $errors->has('map_id') ? ' is-invalid' : '' }}"
                                    id="map_id" name="map_id">
                                @foreach($maps as $map)
                                    <option value="{{$map->id}}" {{$map->id == old('map_id')?'selected':''}}>
                                        {{$map->name}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('map_id'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('map_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div><!--close div /.form-fields-box-->

                    <div class="form-fields-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_race">* Первая раса:</label>
                                    <select class="custom-select {{ $errors->has('first_race') ? ' is-invalid' : '' }}"
                                            id="first_race" name="first_race">
                                        @foreach(\App\Replay::$races as $race)
                                            <option value="{{$race}}" {{$race == old('first_race')?'selected':''}}>
                                                {{$race}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('first_race'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('first_race') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_country_id">* Первая страна:</label>
                                    <select class="custom-select {{ $errors->has('first_country_id') ? ' is-invalid' : '' }}"
                                            id="first_country_id"
                                            name="first_country_id">
                                        @foreach($countries as $country)
                                            <option
                                                    value="{{$country->id}}" {{$country->id == old('first_country_id')?'selected':''}}>
                                                {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('first_country_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('first_country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_location">* Первая локация:</label>
                            <input type="text" id="first_location" value="{{old('first_location')}}"
                                   name="first_location"
                                   class="form-control {{ $errors->has('first_location') ? ' is-invalid' : '' }}">
                            @if ($errors->has('first_location'))
                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('first_location') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div><!--close div /.form-fields-box-->

                    <div class="form-fields-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="second_race">* Вторая раса:</label>
                                    <select class="custom-select {{ $errors->has('second_race') ? ' is-invalid' : '' }}"
                                            id="second_race" name="second_race">
                                        @foreach(\App\Replay::$races as $race)
                                            <option value="{{$race}}" {{$race == old('second_race')?'selected':''}}>
                                                {{$race}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('second_race'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('second_race') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="second_country_id">* Вторая страна:</label>
                                    <select class="custom-select {{ $errors->has('second_country_id') ? ' is-invalid' : '' }}"
                                            id="second_country_id"
                                            name="second_country_id">
                                        @foreach($countries as $country)
                                            <option
                                                    value="{{$country->id}}" {{$country->id == old('second_country_id')?'selected':''}}>
                                                {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('second_country_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('second_country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="second_location">* Вторая локация:</label>
                            <input type="text" id="second_location" value="{{old('second_location')}}"
                                   name="second_location"
                                   class="form-control {{ $errors->has('second_location') ? ' is-invalid' : '' }}">
                            @if ($errors->has('second_location'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('second_location') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div><!--close div /.form-fields-box-->

                    <div class="form-fields-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="game_version_id">* Версия игры:</label>
                                    <select class="custom-select {{ $errors->has('game_version_id') ? ' is-invalid' : '' }}"
                                            id="game_version_id" name="game_version_id">
                                        @foreach($game_versions as $game_version)
                                            <option value="{{$game_version->id}}" {{$game_version->id == old('game_version_id')?'selected':''}}>
                                                {{$game_version->version}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('game_version_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('game_version_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="championship">Чемпионат:</label>
                            <input type="text" value="{{old('title')}}" id="championship" name="championship"
                                   class="form-control {{ $errors->has('championship') ? ' is-invalid' : '' }}">
                            @if ($errors->has('championship'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('championship') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="creating_rate">* Оценка:</label>
                                    <select class="custom-select {{ $errors->has('creating_rate') ? ' is-invalid' : '' }}"
                                            id="creating_rate"
                                            name="creating_rate">
                                        @foreach(\App\Replay::$creating_rates as $creating_rate)
                                            <option value="{{$creating_rate}}" {{$creating_rate == old('creating_rate')?'selected':''}}>
                                                {{$creating_rate}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('creating_rate'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('creating_rate') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--close div /.form-fields-box-->

                    <div class="form-group margin-top-30">
                        <label for="replay">*Загрузить новый Replay:
                            <span class="preview-image-wrapper">
                                <img src="{{route('home')}}/images/icons/add_photo_icon.png" alt="">
                            </span>
                        </label>
                        <input type="file" id="replay"
                               class="form-control-file {{ $errors->has('replay') ? ' is-invalid' : '' }}"
                               name="replay">
                        @if ($errors->has('replay'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('replay') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="content">Короткое описание:</label>
                        <textarea name="content" id="content"
                                  class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}"
                                  rows="10">{{old('content')}}</textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-blue btn-form">Создать</button>
                    </div>
                </form><!-- close div /.user-create-replay-form -->
            </div>
            <div class="col"></div>
        </div><!-- close div /.row -->
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
            if ($('#content').length > 0) {
                var content = document.getElementById('content');

                sceditor.create(content, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'emoticon|' +
                    'date,time',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection