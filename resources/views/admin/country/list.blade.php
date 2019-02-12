@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
Общее
<small>Страны</small>
@endsection

@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
<li class="active">Страны</li>
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
                <h3 class="box-title">Страны ({{$country_count}})</h3>
                <a class="btn btn-info" data-toggle="modal" data-target="#modal-default-1" href="{{route('admin.country.add')}}">Создать</a>
                @if ($errors->has('name'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                @endif
                @if ($errors->has('code'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                @endif
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
                        <th>Код</th>
                        <th>Используется</th>
                        <th style="width: 135px">Действия</th>
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

<div class="pop-up-content"></div>

<div class="modal fade" id="modal-default-1">
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
    <script>
        $(function () {
            getCountry(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getCountry(page);
            })
        });

        function getCountry(page) {
            $.get('{{route('admin.country.pagination')}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection