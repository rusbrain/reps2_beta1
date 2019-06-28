@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>

    <!--JS plugin Select2 - autocomplete -->
    <link rel="stylesheet" href="{{route('home')}}/css/select2.min.css"/>
@endsection

<?php
$countries = $general_helper->getCountries();
$races = \App\Replay::$races;
?>

@section('sidebar-left')
  <!-- All Forum Topics -->
  @include('sidebar-widgets.all-forum-sections')
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
                    <a href="#" class="active">/ Создать cтрим</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Создать cтрим</div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form action="{{route('stream.store')}}" method="POST" enctype="multipart/form-data"
                      class="user-create-stream-form">
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
                        
                    </div><!--close div /.form-fields-box-->

                    <div class="form-fields-box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="race">* Pаса:</label>
                                    <select class="custom-select {{ $errors->has('race') ? ' is-invalid' : '' }}"
                                            id="race" name="race">
                                        @foreach(\App\Replay::$races as $race)
                                            <option value="{{$race}}" {{$race == old('race')?'selected':''}}>
                                                {{$race}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('race'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('race') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_id">* Cтрана:</label>
                                    <select class="form-select-2 custom-select {{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                            id="country_id"
                                            name="country_id">
                                        @foreach($countries as $country)
                                            <option
                                                    value="{{$country->id}}" {{$country->id == old('country_id')?'selected':''}}>
                                                {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>                       
                    </div><!--close div /.form-fields-box-->

                    
                    <div class="form-group margin-top-30">
                        <label for="stream_url">Вставить HTML с видео cтрим</label>
                        <textarea name="stream_url"
                                  class="form-control {{ $errors->has('stream_url') ? ' is-invalid' : '' }}"
                                  id="stream_url" rows="16">{{old('stream_url')}}</textarea>
                        @if ($errors->has('stream_url'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('stream_url') }}</strong>
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

    <!-- Top Points Users-->
    @include('sidebar-widgets.top-pts-users')
    <!-- END New Users-->

    <!-- Top Rating Users-->
    @include('sidebar-widgets.top-rating-users')
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
    <!--JS plugin Select2 - autocomplete -->
    <script src="{{route('home')}}/js/select2.full.min.js"></script>
    <script>
        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        
        $(function () {
            addStream();
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

            if ($('#stream_url').length > 0) {
                var stream_url = document.getElementById('stream_url');

                sceditor.create(stream_url, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'streams'
                });
            }
        });
        $(function () {
            if($('.form-select-2').length > 0){
                $('.form-select-2').select2({

                });
            }
        });
    </script>
@endsection