@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    Подвал сайта
    <small>Управление контентом подвала сайта</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Подвал - Footer</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title ">Редактируемые Блоки:</h3>
                    {{--<a class="btn btn-info margin-left-20" href="{{route('admin.footer.create')}}">Создать</a>--}}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th >Название</th>
                            <th >Текст</th>
                            <th style="width: 30px">Позиция</th>
                            <th style="width: 30px">Активный</th>
                            <th width="15%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($footer_widgets) > 0)
                            @foreach($footer_widgets as $footer_widget)
                                <tr>
                                    <td>{{$footer_widget->id}}</td>
                                    <td>{{$footer_widget->title}}</td>
                                    <td>{!! $footer_widget->text !!}</td>
                                    <td>{{$footer_widget->position}}</td>
                                    <td>{!! $footer_widget->approved?'<i class="fa fa-check text-aqua"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if(!$footer_widget->approved)
                                                <a type="button" class="btn btn-default text-aqua" title="Сделать активным" href="{{route('admin.footer.approved',['id' => $footer_widget->id])}}"><i class="fa fa-check"></i></a>
                                            @else
                                                <a type="button" class="btn btn-default text-red"  title="Сделать не активным" href="{{route('admin.footer.not_approved',['id' => $footer_widget->id])}}"><i class="fa fa-clock-o"></i></a>
                                            @endif
                                            <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть Виджет" href="{{route('admin.footer.view',['id' => $footer_widget->id])}}"><i class="fa fa-eye"></i></a>
                                            <a type="button" class="btn btn-default text-orange"  title="Править Виджет"  href="{{route('admin.footer.edit',['id' => $footer_widget->id])}}"><i class="fa fa-edit"></i></a>
                                            <a type="button" class="btn btn-default text-red"  title="Удалить Виджет" href="{{route('admin.footer.delete',['id' => $footer_widget->id])}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">В Подвале/Футере сайта нет редактируемых блок</td>
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