@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
@endsection

@section('page_header')
    {{$title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">{{$title}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Поиск пользователей</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        {{--<form>--}}
                            {{--<div class="row">--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Поиск(id, имя, почта):</label>--}}
                                    {{--<input type="text" class="form-control" name="search" placeholder="Enter ..." value="{{$request_data['search']??''}}">--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Страна:</label>--}}
                                    {{--<select class="form-control select2" style="width: 100%;" name="country">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--@foreach($countries as $country)--}}
                                            {{--<option value="{{$country->id}}" @if(isset($request_data['country']) && $request_data['country'] == $country->id) selected @endif>{{$country->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Роль:</label>--}}
                                    {{--<select class="form-control select2" style="width: 100%;" name="role">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="0"  @if(isset($request_data['role']) && $request_data['role'] == '0') selected @endif>Пользователь</option>--}}
                                        {{--@foreach(\App\UserRole::all() as $role)--}}
                                            {{--<option value="{{$role->id}}"  @if(isset($request_data['role']) && $request_data['role'] === $role->id) selected @endif>{{$role->title}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Почта подтверждена:</label>--}}
                                    {{--<select class="form-control select2" style="width: 100%;" name="email_verified">--}}
                                        {{--<option value="">Select...</option>--}}

                                        {{--<option value="0"  @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '0') selected @endif>Нет</option>--}}
                                        {{--<option value="1" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '1') selected @endif>Да</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3 col-md-offset-9">--}}
                                    {{--<label>Сортировать по:</label>--}}
                                    {{--<select class="form-control select2" style="width: 100%;" name="sort">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>--}}
                                        {{--<option value="name" @if(isset($request_data['sort']) && $request_data['sort'] == 'name') selected @endif>Имя</option>--}}
                                        {{--<option value="email" @if(isset($request_data['sort']) && $request_data['sort'] == 'email') selected @endif>Почта</option>--}}
                                        {{--<option value="rating" @if(isset($request_data['sort']) && $request_data['sort'] == 'rating') selected @endif>Рейтинг</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="text-right">--}}
                                        {{--<button type="submit" class="btn btn-primary">Поиск</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}

                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Replays ({{$topics->total()}})</h3>
                    <div class="box-tools">
                        {{--@include('admin.user.pagination')--}}
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
                            <th>Раздел</th>
                            <th>Просмотров</th>
                            <th>Коментарии</th>
                            <th>Нравится</th>
                            <th>Не нравится</th>
                            <th>Подтвержден</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topics->items() as $topic)
                            <tr>
                                <td>{{$topic->id}}</td>
                                <td>{{$topic->user->name}}</td>
                                <td>{{$topic->title}}</td>
                                <td>{{$topic->section->title}}</td>
                                <td>{{$topic->reviews}}</td>
                                <td>{{$topic->comments_count}}</td>
                                <td class="text-green">{{$topic->positive_count}}</td>
                                <td class="text-red">{{$topic->negative_count}}</td>
                                <td>{!! $topic->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть"><i class="fa fa-eye"></i></a>
                                        <a type="button" class="btn btn-default text-orange"  title="Править"><i class="fa fa-edit"></i></a>
                                        @if(!$topic->approved)
                                            <a type="button" class="btn btn-default text-green" title="Подтвердить"><i class="fa fa-check"></i></a>
                                        @else
                                            <a type="button" class="btn btn-default text-red"  title="Снять подтверждение"><i class="fa fa-clock-o"></i></a>
                                        @endif
                                        <a type="button" class="btn btn-default text-red"  title="Удалить"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{--@include('admin.user.pagination')--}}
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