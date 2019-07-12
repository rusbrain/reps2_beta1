@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
@endsection

@section('page_header')
Cообщения
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Cообщения чата</li>
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
                    <h3 class="box-title">Cообщения</h3>                    
                    <div class="box-tools pagination-content">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>имя пользователя</th>
                            <th>Сообщение</th>                      
                            <th>Дата и время</th>
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

            getMessages(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getMessages(page);
            })
        });

        function getMessages(page) {
            $.get('{{route('admin.chat.pagination')}}?page='+page, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection