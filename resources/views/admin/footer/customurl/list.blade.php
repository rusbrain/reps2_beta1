@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    Подвал сайта
    <small>Управление Url</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Подвал - Footer Url</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title ">Footer Urls:</h3>
                    <a class="btn btn-info margin-left-20" href="{{route('admin.footer.customurl.create')}}">Создать</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 50px">ID</th>
                            <th style="width: 300px">Название</th>
                            <th >Url</th>
                            <th style="width: 30px">Активный</th>
                            <th width="15%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($footer_urls) > 0)
                            @foreach($footer_urls as $footer_url)
                                <tr>
                                    <td>{{$footer_url->id}}</td>
                                    <td>{{$footer_url->title}}</td>
                                    <td>{!! $footer_url->url !!}</td>
                                    <td>{!! $footer_url->approved?'<i class="fa fa-check text-aqua"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if(!$footer_url->approved)
                                                <a type="button" class="btn btn-default text-aqua" title="Сделать активным" href="{{route('admin.footer.customurl.approved',['id' => $footer_url->id])}}"><i class="fa fa-check"></i></a>
                                            @else
                                                <a type="button" class="btn btn-default text-red"  title="Сделать не активным" href="{{route('admin.footer.customurl.not_approved',['id' => $footer_url->id])}}"><i class="fa fa-clock-o"></i></a>
                                            @endif
                                            <a type="button" class="btn btn-default text-orange"  title="Править Виджет"  href="{{route('admin.footer.customurl.edit',['id' => $footer_url->id])}}"><i class="fa fa-edit"></i></a>
                                            <a type="button" class="btn btn-default text-red"  title="Удалить Виджет" href="{{route('admin.footer.customurl.delete',['id' => $footer_url->id])}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Там нет URL</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection