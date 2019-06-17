@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Ответы на опросы пользователя <b>{{$user->name}}</b>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}"><i class="fa fa-dashboard"></i>Пользователи</a></li>
    <li><a href="{{route('admin.user.profile', ['id' => $user->id])}}"><i class="fa fa-dashboard"></i>{{$user->name}}</a></li>
    <li class="active">Ответы на опросы</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="box">
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Комментарии <span class="user-name">{{$user->name}}</span> ({{$answer_count}})</h3>
                <div class="box-tools pagination-content">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 30px">ID</th>
                        <th>Вопрос</th>
                        <th>Ответ</th>
                        <th>Дата</th>
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
            $.get('{{route('admin.user.answers.pagination', ['id' => $user->id])}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection