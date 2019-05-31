@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>

    <!--JS plugin Select2 - autocomplete -->
    <link rel="stylesheet" href="{{route('home')}}/css/select2.min.css"/>
@endsection

@section('page_header')
    Создать новый Replay
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.replay')}}">Replays</a></li>
    <li class="active">Создать новый Replay</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Создать новый Replay</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" enctype="multipart/form-data" action="{{route('admin.replay.create')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..."
                                           value="{{old('title')}}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Пользовательский/Gosu:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="user_replay">
                                            <option value="0" {{0 == old('user_replay')?'selected':''}}>Gosy</option>
                                            <option value="1" {{1 == old('user_replay')?'selected':''}}>
                                                Пользовательский
                                            </option>
                                        </select>
                                        @if ($errors->has('user_replay'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('user_replay') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="box-header">
                                        <h3 class="box-title">Тип:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="type_id">
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}" {{$type->id == old('type_id')?'selected':''}}>{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type_id'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('type_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Карта:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-select-2" name="map_id">
                                            @foreach($maps as $map)
                                                <option value="{{$map->id}}" {{$map->id == old('map_id')?'selected':''}}>{{$map->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('map_id'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('map_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Первая раса:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="first_race">
                                                    @foreach(\App\Replay::$races as $race)
                                                        <option value="{{$race}}" {{$race == old('first_race')?'selected':''}}>{{$race}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('first_race'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('first_race') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Первая страна:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control form-select-2" name="first_country_id">
                                                    @foreach($admin_helper->getCountries() as $country)
                                                        <option value="{{$country->id}}" {{$country->id == old('first_country_id')?'selected':''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('first_country_id'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('first_country_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Первая локация:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <input type="text" name="first_location" class="form-control"
                                                   placeholder="Локация..." value="{{old('first_location')}}">
                                            @if ($errors->has('first_location'))
                                                <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('first_location') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Вторая раса:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="second_race">
                                                    @foreach(\App\Replay::$races as $race)
                                                        <option value="{{$race}}" {{$race == old('second_race')?'selected':''}}>{{$race}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('second_race'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('second_race') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Вторая страна:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control form-select-2" name="second_country_id">
                                                    @foreach($admin_helper->getCountries() as $country)
                                                        <option value="{{$country->id}}" {{$country->id == old('second_country_id')?'selected':''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('second_country_id'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('second_country_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box-header">
                                                <h3 class="box-title">Вторая локация:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <input type="text" name="second_location" class="form-control"
                                                   placeholder="Локация..." value="{{old('second_location')}}">
                                            @if ($errors->has('second_location'))
                                                <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('second_location') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Версия игры:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <select class="form-control" name="game_version_id">
                                        @foreach($admin_helper->getGameVersions() as $game_version)
                                            <option value="{{$game_version->id}}" {{$game_version->id == old('game_version_id')?'selected':''}}>{{$game_version->version}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('game_version_id'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('game_version_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Чемпионат:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="championship" class="form-control"
                                           placeholder="Чемпионат..." value="{{old('championship')}}">
                                    @if ($errors->has('championship'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('championship') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Оценка:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <select class="form-control" name="creating_rate">
                                        @foreach(\App\Replay::$creating_rates as $creating_rate)
                                            <option value="{{$creating_rate}}" {{$creating_rate == old('creating_rate')?'selected':''}}>{{$creating_rate}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('creating_rate'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('creating_rate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        <label>
                                            <input type="checkbox" name="approved" class="flat-red"
                                                   {{old('approved')?'checked':''}} value="1">
                                            Подтвердить
                                        </label>
                                        @if ($errors->has('approved'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('approved') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Загрузить новый Replay:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <input type="file" id="replay" name="replay">
                                    </div>
                                    @if ($errors->has('replay'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('replay') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box-header">
                                        <h3 class="box-title">Комментарий:</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body pad">
                                            <textarea
                                                    id="content"
                                                    name="content"
                                                    rows="10"
                                                    cols="80">{!! old('content') !!}</textarea>
                                    </div>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="box-body pad">
                                        <div class="box-header">
                                            <h3 class="box-title">Вставить HTML код с Youtube с видео реплеем:</h3>
                                        </div><!-- /.box-header -->
                                        <textarea name="video_iframe"
                                                  class="form-control {{ $errors->has('video_iframe') ? ' is-invalid' : '' }}"
                                                  id="video_iframe"
                                                  rows="10">{!! old('video_iframe') !!}</textarea>
                                        @if ($errors->has('video_iframe'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('video_iframe') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.row -->
                            <div class="row">
                                <div class="col-md-1 col-md-offset-11">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-flat send-message-btn">Сохранить
                                    </button>
                                </div>
                            </div>

                            <!-- /.form group -->
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- FastClick -->
    <script src="{{route('home')}}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{route('home')}}/dist/js/demo.js"></script>

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

    <!--JS plugin Select2 - autocomplete -->
    <script src="{{route('home')}}/js/select2.full.min.js"></script>

    <script>
        //Date picker
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

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

            if ($('#video_iframe').length > 0) {
                var video_iframe = document.getElementById('video_iframe');

                sceditor.create(video_iframe, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'youtube,source'
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