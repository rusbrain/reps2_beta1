@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Разделы форума
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Темы форума</li>
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
            <div class="box-header with-border">
                <h3 class="box-title">Разделов ({{$sections_count}})</h3>
                <a class="btn btn-info" href="{{route('admin.forum.section.add')}}">Создать</a>
                <div class="box-tools pagination-content">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 30px">ID</th>
                        <th>Название</th>
                        <th>Имя</th>
                        <th>Позиция</th>
                        <th>Описание</th>
                        <th>Количество тем</th>
                        <th>Активный</th>
                        <th>Основной</th>
                        <th>Пользователь добавляет</th>
                        <th style="width: 245px">Действия</th>
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
            getSections(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getSections(page);
            })
        });

        function getSections(page) {
            $.get('{{route('admin.forum_sections.pagination')}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection