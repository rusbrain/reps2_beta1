@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
@endsection

@section('page_header')
    Replays
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Replays</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Поиск пользователей</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Поиск(id, название):</label>
                                    <input type="text" class="form-control" name="search" placeholder="Enter ..." value="{{$request_data['search']??''}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Карта:</label>
                                    <select class="form-control" style="width: 100%;" name="map">
                                        <option value="">Select...</option>
                                        @foreach($admin_helper->getMaps() as $map)
                                            <option value="{{$map->id}}" @if(isset($map['map']) && $map['map'] == $map->id) selected @endif>{{$map->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Страна:</label>
                                    <select class="form-control" style="width: 100%;" name="country">
                                        <option value="">Select...</option>
                                        @foreach($admin_helper->getCountries() as $country)
                                            <option value="{{$country->id}}"  @if(isset($request_data['country']) && $request_data['country'] == $country->id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Тип:</label>
                                    <select class="form-control" style="width: 100%;" name="type">
                                        <option value="">Select...</option>
                                        @foreach(\App\ReplayType::all() as $type)
                                            <option value="{{$type->id}}"  @if(isset($request_data['type']) && $request_data['type'] == $type->id) selected @endif>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Gosu/Пользоватлеьский:</label>
                                    <select class="form-control" style="width: 100%;" name="users">
                                        <option value="">Select...</option>
                                        <option value="1"  @if(isset($request_data['users']) && $request_data['users'] == 1) selected @endif>Пользовательский</option>
                                        <option value="0"  @if(isset($request_data['users']) && $request_data['users'] == 0) selected @endif>Gosu</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Подтвержденные:</label>
                                    <select class="form-control" style="width: 100%;" name="approved">
                                        <option value="">Select...</option>
                                        <option value="1"  @if(isset($request_data['approved']) && $request_data['approved'] == 1) selected @endif>Да</option>
                                        <option value="0"  @if(isset($request_data['approved']) && $request_data['approved'] == 0) selected @endif>Нет</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Раса</label>:</label>
                                    <select class="form-control" style="width: 100%;" name="race">
                                        <option value="">Select...</option>
                                        @foreach(\App\Replay::$races as $race)
                                            <option value="{{$race}}"  @if(isset($request_data['race']) && $request_data['race'] == $race) selected @endif>{{$race}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Сортировать по:</label>
                                    <select class="form-control" style="width: 100%;" name="sort">
                                        <option value="">Select...</option>
                                        <option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>
                                        <option value="title" @if(isset($request_data['sort']) && $request_data['sort'] == 'title') selected @endif>Название</option>
                                        <option value="user_rating" @if(isset($request_data['sort']) && $request_data['sort'] == 'user_rating') selected @endif>Оценка пользователей</option>
                                        <option value="rating" @if(isset($request_data['sort']) && $request_data['sort'] == 'rating') selected @endif>Рейтинг</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Поиск</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Replays ({{$replay_count}})</h3>
                    <a class="btn btn-info" href="{{route('admin.replay.add')}}">Создать</a>
                    <div class="box-tools pagination-content">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>Пользователь</th>
                            <th>Название</th>
                            <th>Карта</th>
                            <th>Страны</th>
                            <th>Расы</th>
                            <th>Тип</th>
                            <th>Gosu/Пользоватлеьский</th>
                            <th>Коментарии</th>
                            <th>Оценка пользователей</th>
                            <th>Рейтинг</th>
                            <th>Подтвержден</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-content">
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-tools pagination-content">
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <div class="pop-up-content"></div>
@endsection

@section('js')
    <script src="{{route('home')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2();

            getUsers(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getUsers(page);
            })
        });

        function getUsers(page) {
            $.get('{{route('admin.replay.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection