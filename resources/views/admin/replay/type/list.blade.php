@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    Replay
<small>Типы Replay</small>
@endsection

@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
<li class="active">Типы Replay</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Типы Replay ({{$data->total()}})</h3>
                <a class="btn btn-info" data-toggle="modal" data-target="#modal-default-1" href="{{route('admin.replay.type.add')}}">Создать</a>
                @if ($errors->has('name'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                @endif
                @if ($errors->has('title'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                @endif
                <div class="box-tools">
                    @include('admin.user.pagination')
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 30px">ID</th>
                        <th>Имя</th>
                        <th>Название</th>
                        <th>Replays</th>
                        <th style="width: 135px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data->items() as $type)
                    <tr>
                        <td>{{$type->id}}</td>
                        <td>{{$type->name}}</td>
                        <td>{{$type->title}}</td>
                        <td>{{$type->replay_count}}</td>
                        <td>
                            <div class="btn-group">
                                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть профиль пользователя" href="{{route('admin.replay', ['type' => $type->id])}}"><i class="fa fa-eye"></i></a>
                                <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$type->id}}" href="{{route('admin.replay.type.edit', ['id' => $type->id])}}"><i class="fa fa-edit"></i></a>
                                <a type="button" class="btn btn-default text-red"  title="Удалить пользователя" href="{{route('admin.replay.type.remove', ['id' => $type->id])}}"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                @include('admin.user.pagination')
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
@foreach($data->items() as $type)
<div class="modal fade" id="modal-default_{{$type->id}}">
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
@endforeach
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
@endsection