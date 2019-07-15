@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">   
    <style>
        .img-preview{
            max-width: 200px;
            height: auto;
        }
    </style>
@endsection

@section('page_header')
    Изображение
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Изображение</li>
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
                    <h3 class="box-title">Изображение ({{$pictures_count}})</h3>
                    <a class="btn btn-info" data-toggle="modal" data-target="#modal-default-add"  href="{{route('admin.chat.pictures.create')}}">Создать</a>
                    <div class="box-tools pagination-content">
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
                            <th>Персонажи</th>                    
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
    <script src="{{route('home')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>
        $(function () {
            $('.select2').select2();

            getPictures(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getPictures(page);
            })
        });

        function getPictures(page) {
            $.get('{{route('admin.chat.pictures.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection