@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
@endsection

@section('page_header')
    Пользователи
    <small>Список пользователей</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Пользователи</li>
@endsection

@section('content')
    {{--{{dd($data->getUrlRange(1,10))}}--}}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Поиск пользователей</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Поиск(id, имя, почта):</label>
                                    <input type="text" class="form-control" name="search" placeholder="Enter ..." value="{{$request_data['search']??''}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Страна:</label>
                                    <select class="form-control select2" style="width: 100%;" name="country">
                                        <option value="">Select...</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if(isset($request_data['country']) && $request_data['country'] == $country->id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Роль:</label>
                                    <select class="form-control select2" style="width: 100%;" name="role">
                                        <option value="">Select...</option>
                                        <option value="0"  @if(isset($request_data['role']) && $request_data['role'] == '0') selected @endif>Пользователь</option>
                                        @foreach(\App\UserRole::all() as $role)
                                            <option value="{{$role->id}}"  @if(isset($request_data['role']) && $request_data['role'] === $role->id) selected @endif>{{$role->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Почта подтверждена:</label>
                                    <select class="form-control select2" style="width: 100%;" name="email_verified">
                                        <option value="">Select...</option>

                                        <option value="0"  @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '0') selected @endif>Нет</option>
                                        <option value="1" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '1') selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-md-offset-9">
                                    <label>Сортировать по:</label>
                                    <select class="form-control select2" style="width: 100%;" name="sort">
                                        <option value="">Select...</option>
                                        <option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>
                                        <option value="name" @if(isset($request_data['sort']) && $request_data['sort'] == 'name') selected @endif>Имя</option>
                                        <option value="email" @if(isset($request_data['sort']) && $request_data['sort'] == 'email') selected @endif>Почта</option>
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
                    <h3 class="box-title">Пользователи ({{$data->total()}})</h3>
                    <div class="box-tools">
                        @include('admin.user.pagination')
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>Имя</th>
                            <th>Почта</th>
                            <th>Страна</th>
                            <th>Роль</th>
                            <th>Рейтинг</th>
                            <th>Почта подтверждена</th>
                            <th>Заблокирован</th>
                            <th style="width: 300px">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data->items() as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->country->name??"Нет"}}</td>
                                <td>{{$user->role->title??"Пользователь"}}</td>
                                <td>{{$user->rating}}</td>
                                <td>{!! $user->email_verified_at?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
                                <td>{!! $user->is_ban?'<i class="fa fa-circle-o text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-default text-green" title="Написать сообщение"><i class="fa fa-send-o"></i></a>
                                        <a type="button" class="btn btn-default text-purple"  title="Написать письмо на E-mail"><i class="fa fa-envelope-o"></i></a>
                                        <a type="button" class="btn btn-default" title="Реплеи пользователя"><i class="fa fa-film"></i></a>
                                        <a type="button" class="btn btn-default text-aqua"  title="Темы пользователя на форуме"><i class="fa fa-list"></i></a>
                                        <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"><i class="fa fa-edit"></i></a>
                                        @if($user->is_ban)
                                            <a type="button" class="btn btn-default text-olive" title="Снять блокировку пользователя"><i class="fa fa-thumbs-o-up"></i></a>
                                        @else
                                            <a type="button" class="btn btn-default text-yellow"  title="Заблокировать пользователя"><i class="fa fa-thumbs-o-down"></i></a>
                                        @endif
                                        <a type="button" class="btn btn-default text-red"  title="Удалить пользователя"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    @include('admin.user.pagination')
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>

@endsection

@section('js')
    <script src="{{route('home')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2();
        })
    </script>
@endsection