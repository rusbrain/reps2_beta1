@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

@endsection

@section('page_header')
    Редактировать {{$replay->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.replay')}}">Replays</a></li>
    <li class="active">Редактировать {{$replay->title}}</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$replay->user_replay?"Пользовательский Replay":"Gosu Replay"}} / {{$replay->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..." value="{{old('title')??$replay->title}}">
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
                                            <option value="0" {{0 == $replay->user_replay?'selected':''}}>Gosy</option>
                                            <option value="1" {{1 == $replay->user_replay?'selected':''}}>Пользовательский</option>
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
                                                <option value="{{$type->id}}" {{$type->id == $replay->type_id?'selected':''}}>{{$type->title}}({{$type->name}})</option>
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
                                        <select class="form-control" name="map_id">
                                            @foreach($maps as $map)
                                                <option value="{{$map->id}}" {{$map->id == $replay->map_id?'selected':''}}>{{$map->name}}</option>
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
                                                        <option value="{{$race}}" {{$race == $replay->first_race?'selected':''}}>{{$race}}</option>
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
                                                <select class="form-control" name="first_country_id">
                                                    @foreach($admin_helper->getCountries() as $country)
                                                        <option value="{{$country->id}}" {{$country->id == $replay->first_country_id?'selected':''}}>{{$country->name}}</option>
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
                                            <input type="text" name="first_location" class="form-control" placeholder="Локация..." value="{{old('first_location')??$replay->first_location}}">
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
                                                        <option value="{{$race}}" {{$race == $replay->second_race?'selected':''}}>{{$race}}</option>
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
                                                <select class="form-control" name="second_country_id">
                                                    @foreach($admin_helper->getCountries() as $country)
                                                        <option value="{{$country->id}}" {{$country->id == $replay->second_country_id?'selected':''}}>{{$country->name}}</option>
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
                                            <input type="text" name="second_location" class="form-control" placeholder="Локация..." value="{{old('second_location')??$replay->second_location}}">
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
                                            <option value="{{$game_version->id}}" {{$game_version->id == $replay->game_version->version?'selected':''}}>{{$game_version->version}}</option>
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
                                    <input type="text" name="championship" class="form-control" placeholder="Чемпионат..." value="{{old('championship')??$replay->championship}}">
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
                                            <option value="{{$creating_rate}}" {{$creating_rate == $replay->creating_rate?'selected':''}}>{{$creating_rate}}</option>
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
                                            <input type="checkbox" name="approved" class="flat-red" {{old('approved')?'checked':($replay->approved?'checked':'')}} value="1">
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
                                        <input type="file" id="preview_img" name="preview_img">
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div>
                                            <div class="box-header">
                                                <h3 class="box-title">Комментарий:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body pad">
                                        <textarea id="content" name="content" rows="5" cols="80">
                                                                {!! old('content')??$replay->content !!}
                                        </textarea>
                                            </div>
                                            @if ($errors->has('content'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-md-offset-11">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-flat send-message-btn">Сохранить</button>
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
    <!-- CK Editor -->
    <script src="{{route('home')}}/bower_components/ckeditor/ckeditor.js"></script>
    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

    //Date picker
    <script>
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        });
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('content');
            CKEDITOR.replace('content');
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
    </script>
@endsection