@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
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
                                    <label>Поиск(id, имя, почта):</label>
                                    <input type="text" class="form-control" name="search" placeholder="Enter ..." value="{{$request_data['search']??''}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Страна:</label>
                                    <select class="form-control" style="width: 100%;" name="country">
                                        <option value="">Select...</option>
                                        @foreach($admin_helper->getCountries() as $country)
                                            <option value="{{$country->id}}" @if(isset($request_data['country']) && $request_data['country'] == $country->id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Роль:</label>
                                    <select class="form-control" style="width: 100%;" name="role">
                                        <option value="">Select...</option>
                                        <option value="0" @if(isset($request_data['role']) && $request_data['role'] == '0') selected @endif>Пользователь</option>
                                        @foreach(\App\UserRole::all() as $role)
                                            <option value="{{$role->id}}"  @if(isset($request_data['role']) && $request_data['role'] == $role->id) selected @endif>{{$role->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Почта подтверждена:</label>
                                    <select class="form-control" style="width: 100%;" name="email_verified">
                                        <option value="">Select...</option>
                                        <option value="0" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '0') selected @endif>Нет</option>
                                        <option value="1" @if(isset($request_data['email_verified']) && $request_data['email_verified'] == '1') selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Бан:</label>
                                    <select class="form-control" style="width: 100%;" name="is_ban">
                                        <option value="">Select...</option>
                                        <option value="0" @if(isset($request_data['is_ban']) && $request_data['is_ban'] == '0') selected @endif>Нет</option>
                                        <option value="1" @if(isset($request_data['is_ban']) && $request_data['is_ban'] == '1') selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-md-offset-6">
                                    <label>Сортировать по:</label>
                                    <select class="form-control" style="width: 100%;" name="sort">
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
                    <h3 class="box-title">Пользователи ({{$users_count}})</h3>
                    <div class="box-tools pagination-content">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>Аватар</th>
                            <th>Имя</th>
                            <th>Почта</th>
                            <th>Страна</th>
                            <th>Роль</th>
                            <th>Рейтинг</th>
                            <th>Темы</th>
                            <th>Replay</th>
                            <th>Галерея</th>
                            <th>Коментарии</th>
                            <th>Почта</th>
                            <th>Бан</th>
                            <th>Активность</th>
                            <th style="width: 330px">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-content">
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix pagination-content">
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            getUsers(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getUsers(page);
            })
        });

        function getUsers(page) {
            $.get('{{route('admin.users.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection