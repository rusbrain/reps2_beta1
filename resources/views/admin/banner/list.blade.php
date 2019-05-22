@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    Баннеры
    <small>Управление баннерами</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Баннеры</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title ">Баннеры:</h3>
                    <a class="btn btn-info margin-left-20" href="{{route('admin.banner.create')}}">Создать</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered banners">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th width="15%">Изображение</th>
                            <th>Название</th>
                            <th>Ссылка</th>
                            <th style="width: 30px">Активный</th>
                            <th width="15%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($banners) > 0)
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{$banner->id}}</td>
                                    <td>
                                        <img class="img-preview"
                                             src="{{route('home').
                                             ($banner->file->link??'/dist/img/default-50x50.gif')}}"
                                             alt="Изображение">
                                    </td>
                                    <td>{{$banner->title}}</td>
                                    <td>{{$banner->url_redirect}}</td>
                                    <td class="text-center">{!! $banner->is_active?'<i class="fa fa-check text-aqua"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(!$banner->is_active)
                                                <a type="button" class="btn btn-default text-aqua" title="Сделать активным" href="{{route('admin.banner.is_active',['id' => $banner->id])}}"><i class="fa fa-check"></i></a>
                                            @else
                                                <a type="button" class="btn btn-default text-red"  title="Сделать не активным" href="{{route('admin.banner.not_active',['id' => $banner->id])}}"><i class="fa fa-clock-o"></i></a>
                                            @endif
                                            <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть Баннер" href="{{route('admin.banner.view',['id' => $banner->id])}}"><i class="fa fa-eye"></i></a>
                                            <a type="button" class="btn btn-default text-orange"  title="Править Баннер"  href="{{route('admin.banner.edit',['id' => $banner->id])}}"><i class="fa fa-edit"></i></a>
                                            <a type="button" class="btn btn-default text-red"  title="Удалить Баннер" href="{{route('admin.banner.delete',['id' => $banner->id])}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Баннеры отсутствуют</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </div>
    </div> <!-- /.row -->
@endsection