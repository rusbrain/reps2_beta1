@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <style>
        .img-preview{
            width: 200px;
            height: auto;
        }
    </style>
@endsection

@section('page_header')
    Пользователи
    <small>Галерея пользователей</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Галерея пользователей</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--<div class="box">--}}
                {{--<div class="box-header with-border">--}}
                    {{--<h3 class="box-title">Поиск пользователей</h3>--}}
                {{--</div>--}}
                {{--<div class="box-body">--}}
                    {{--<div class="box-tools col-md-12">--}}
                        {{--<form>--}}
                            {{--<div class="row">--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Поиск(id, имя, почта):</label>--}}
                                    {{--<input type="text" class="form-control" name="search" placeholder="Enter ..." value="{{$request_data['search']??''}}">--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Страна:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="country">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--@foreach($admin_helper->getCountries() as $country)--}}
                                            {{--<option value="{{$country->id}}" @if(isset($request_data['country']) && $request_data['country'] == $country->id) selected @endif>{{$country->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Роль:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="role">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="0" @if(isset($request_data['role']) && $request_data['role'] == '0') selected @endif>Пользователь</option>--}}
                                        {{--@foreach(\App\UserRole::all() as $role)--}}
                                            {{--<option value="{{$role->id}}"  @if(isset($request_data['role']) && $request_data['role'] === $role->id) selected @endif>{{$role->title}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Почта подтверждена:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="email_verified">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="0" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '0') selected @endif>Нет</option>--}}
                                        {{--<option value="1" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '1') selected @endif>Да</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Бан:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="is_ban">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="0" @if(isset($request_data['is_ban']) && $request_data['is_ban'] == '0') selected @endif>Нет</option>--}}
                                        {{--<option value="1" @if(isset($request_data['is_ban']) && $request_data['is_ban'] == '1') selected @endif>Да</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3 col-md-offset-6">--}}
                                    {{--<label>Сортировать по:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="sort">--}}
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

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Галерея пользователей ({{$data->total()}})</h3>
                    <a class="btn btn-info" data-toggle="modal" data-target="#modal-default-add" href="{{route('admin.user.gallery.add')}}">Создать</a>

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
                            <th>Изображение</th>
                            <th>Пользователь</th>
                            <th>Подпись</th>
                            <th>18+</th>
                            <th>Рейтинг</th>
                            <th>Комментариев</th>
                            <th style="width: 175px">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data->items() as $gallery)
                            <tr>
                                <td>{{$gallery->id}}</td>
                                <td>
                                    <img class="img-preview" src="{{route('home').($gallery->file->link??'/dist/img/default-50x50.gif')}}" alt="Изображение">
                                </td>
                                <td><a href="{{route('admin.user.profile', ['id' => $gallery->user->id])}}">{{$gallery->user->name}}</a></td>
                                <td>{{$gallery->comment}}</td>
                                <td>{!! $gallery->for_adults?'<i class="fa fa-check text-red"></i>':'<i class="fa fa-minus text-gray"></i>' !!}</td>
                                <td> <i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>{{$gallery->positive_count}} /
                                    <i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>{{$gallery->negative_count}}
                                    - ({{$gallery->rating}})</td>
                                <td>{{$gallery->comments_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть" href="{{route('admin.users.gallery.view', ['id' => $gallery->id])}}"><i class="fa fa-eye"></i></a>
                                        <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$gallery->id}}" href="{{route('admin.user.gallery.edit', ['id' => $gallery->id])}}"><i class="fa fa-edit"></i></a>
                                        @if($gallery->for_adults)
                                            <a type="button" class="btn btn-default text-gray"  title="Снять отметку 18+" href="{{route('admin.users.gallery.not_for_adults', ['id' => $gallery->id])}}"><i class="fa fa-minus text-gray"></i></a>
                                        @else
                                            <a type="button" class="btn btn-default text-red" title="Пометить как 18+" href="{{route('admin.users.gallery.for_adults', ['id' => $gallery->id])}}"><i class="fa fa-check"></i></a>
                                        @endif
                                        <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.users.gallery.remove', ['id' => $gallery->id])}}"><i class="fa fa-trash"></i></a>
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
    @foreach($data->items() as $gallery)
        <div class="modal fade" id="modal-default_{{$gallery->id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Default Modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endforeach
    <div class="modal fade" id="modal-default-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('js')
@endsection