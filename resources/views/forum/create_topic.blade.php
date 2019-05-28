@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
   @endsection

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
                    <a href="{{route('forum.topic.my_list')}}">/ Мои Темы</a>
                </li>
                <li>
                    <a href="#" class="active">/ Создать Тему</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div>
        <a href="{{route('forum.topic.create')}}" class="btn-blue create-theme-btn">Создать тему</a>
    </div>

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Создание темы</div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form action="{{route('forum.topic.store')}}" method="POST" enctype="multipart/form-data"
                      class="user-create-theme-form">
                    @csrf
                    <div class="form-group margin-top-25">
                        <label for="section_id">Раздел:</label>
                        <select class="custom-select {{ $errors->has('section_id') ? ' is-invalid' : '' }}"
                                id="section_id" name="section_id">
                            @foreach($sections as $section)
                                <option value="{{$section->id}}"
                                        {{$section->id == old('section_id')?'selected':''}}>
                                    {{$section->title}}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('section_id'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('section_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="title">* Название:</label>
                        <input type="text" id="title" name="title" value="{{old('title')}}"
                               class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="preview_img">Превью:
                            <span class="preview-image-wrapper">
                                <img src="{{route('home').('/dist/img/default-50x50.gif')}}" alt="">
                            </span>
                        </label>
                        <input type="file" id="preview_img"
                               class="form-control-file {{ $errors->has('preview_img') ? ' is-invalid' : '' }}"
                               name="preview_img">
                        @if ($errors->has('preview_img'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('preview_img') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="preview_content">* Краткое содержание:</label>
                        <textarea name="preview_content" id="preview_content"
                                  class="form-control {{ $errors->has('preview_content') ? ' is-invalid' : '' }}"
                                  rows="8">{!! old('preview_content') !!}</textarea>
                        @if ($errors->has('preview_content'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('preview_content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="content">* Основной текст:</label>
                        <textarea name="content" id="content"
                                  class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}"
                                  rows="15">{!! old('content') !!}</textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-blue btn-form">Опубликовать</button>
                    </div>
                </form>
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
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.bbcode.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script>
        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            /**custom commands for HTML text editor*/
            addCountries();
            addRaces();

            /**turn on HTML text editor for Topic's preview content**/
            if ($('#preview_content').length > 0) {
                var preview_content = document.getElementById('preview_content');

                sceditor.create(preview_content, {
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
                        'date,time|' +
                        'countries|'+
                        'races|' +
                        'maximize',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }

            /**turn on HTML text editor for Topic content**/
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
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time|' +
                    'countries|'+
                    'races|' +
                    'maximize',
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