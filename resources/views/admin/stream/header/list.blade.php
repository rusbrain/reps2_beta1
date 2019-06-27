@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    Stream
    <small>Заголовок</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Заголовок</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title ">Заголовок:</h3>
                    <a class="btn btn-info margin-left-20" href="{{route('admin.stream.header.create')}}">Создать</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 50px">ID</th>
                            <th style="width: 300px">Название</th>
                            <th >Url</th>
                            <th width="15%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($data) > 0)
                            @foreach($data as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->title}}</td>
                                    <td>{!! $row->url !!}</td>
                                    <td>
                                        <div class="btn-group">                                           
                                            <a type="button" class="btn btn-default text-orange"  title="Править"  href="{{route('admin.stream.header.edit',['id' => $row->id])}}"><i class="fa fa-edit"></i></a>
                                            <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.stream.header.delete',['id' => $row->id])}}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Нет данных</td>
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