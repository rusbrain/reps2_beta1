@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $game_versions = $general_helper->getGameVersion();
@endphp
@section('content')
    <div class="row create-file">
        <div class="col-md-10">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title text-blue">Создать новый Replay</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <div class="post">
                            <form method="post" enctype="multipart/form-data" action="{{route('replay.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Название:</label>
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
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Пользовательский/Gosu:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="user_replay">
                                                <option value="0" {{0 == old('user_replay')?'selected':''}}>Gosy
                                                </option>
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
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Тип:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="type_id">
                                                @foreach($types as $type)
                                                    <option value="{{$type->id}}" {{$type->id == old('type_id')?'selected':''}}>
                                                        {{$type->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('type_id'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('type_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Карта:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="map_id">
                                                @foreach($maps as $map)
                                                    <option value="{{$map->id}}" {{$map->id == old('map_id')?'selected':''}}>
                                                        {{$map->name}}
                                                    </option>
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
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Первая раса:</label>
                                                    <!-- /. tools -->
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="first_race">
                                                        @foreach(\App\Replay::$races as $race)
                                                            <option value="{{$race}}" {{$race == old('first_race')?'selected':''}}>
                                                                {{$race}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('first_race'))
                                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('first_race') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Первая страна:</label>
                                                    <!-- /. tools -->
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="first_country_id">
                                                        @foreach($countries as $country)
                                                            <option
                                                                    value="{{$country->id}}" {{$country->id == old('first_country_id')?'selected':''}}>
                                                                {{$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('first_country_id'))
                                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('first_country_id') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Первая локация:</label>
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
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Вторая раса:</label>
                                                    <!-- /. tools -->
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="second_race">
                                                        @foreach(\App\Replay::$races as $race)
                                                            <option value="{{$race}}" {{$race == old('second_race')?'selected':''}}>
                                                                {{$race}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('second_race'))
                                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('second_race') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Вторая страна:</label>
                                                    <!-- /. tools -->
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="second_country_id">
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}" {{$country->id == old('second_country_id')?'selected':''}}>
                                                                {{$country->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('second_country_id'))
                                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('second_country_id') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box-header">
                                                    <label class="box-title">Вторая локация:</label>
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
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Версия игры:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <select class="form-control" name="game_version_id">
                                            @foreach($game_versions as $game_version)
                                                <option value="{{$game_version->id}}" {{$game_version->id == old('game_version_id')?'selected':''}}>
                                                    {{$game_version->version}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('game_version_id'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('game_version_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Чемпионат:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <input type="text" name="championship" class="form-control"
                                               placeholder="Локация..."
                                               value="{{old('championship')}}">
                                        @if ($errors->has('championship'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('championship') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Оценка:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <select class="form-control" name="creating_rate">
                                            @foreach(\App\Replay::$creating_rates as $creating_rate)
                                                <option value="{{$creating_rate}}" {{$creating_rate == old('creating_rate')?'selected':''}}>
                                                    {{$creating_rate}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('creating_rate'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('creating_rate')}}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="box-title">Загрузить новый Replay:</label>
                                            <input type="file" id="replay" name="replay" class="filestyle">
                                        </div>
                                        @if ($errors->has('replay'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('replay') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header">
                                            <label class="box-title">Комментарий:</label>
                                            <!-- /. tools -->
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body pad">
                                        <textarea id="content" class="form-control"
                                                  name="content" rows="5" cols="80">{!! old('content') !!}</textarea>
                                        </div>
                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1 col-md-offset-11">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-flat send-message-btn">
                                            Сохранить
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

    </div>
@endsection