@extends('admin.layouts.admin')

@section('css')
    <style>
        .img-preview{
            width: 200px;
            height: auto;
        }
    </style>
@endsection

@section('page_header')
    Карты Replay
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Файлы</li>
@endsection

@section('content')
        {{--<div class="col-md-12">--}}
            {{--<div class="box">--}}
                {{--<div class="box-header with-border">--}}
                    {{--<h3 class="box-title">Поиск файлов</h3>--}}
                {{--</div>--}}
                {{--<div class="box-body">--}}
                    {{--<div class="box-tools col-md-12">--}}
                        {{--<form>--}}
                            {{--<div class="row">--}}
                                {{--<div class="form-group col-md-3">--}}
                                    {{--<label>Поиск(Название, id):</label>--}}
                                    {{--<input type="text" class="form-control" name="text" placeholder="Enter ..." value="{{$request_data['text']??''}}">--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-3 col-md-offset-6">--}}
                                    {{--<label>Сортировать по:</label>--}}
                                    {{--<select class="form-control" style="width: 100%;" name="sort">--}}
                                        {{--<option value="">Select...</option>--}}
                                        {{--<option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>--}}
                                        {{--<option value="name" @if(isset($request_data['sort']) && $request_data['sort'] == 'name') selected @endif>Название</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="text-right">--}}
                                        {{--<button type="submit" class="btn btn-primary">Поиск</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Карты Replay ({{$data->total()}})</h3>
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
                            <th style="width: 220px">Файл</th>
                            <th>Название</th>
                            <th>MimeType</th>
                            <th>Размер(Kb)</th>
                            <th style="width: 100px">Используется</th>
                            <th style="width: 100px">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data->items() as $file)
                            @php
                            $count = $file->banner_count + $file->country_count + $file->forum_topic_count + $file->replay_count + $file->avatar_count + $file->user_gallery_count;
                            @endphp
                            <tr>
                                <td>{{$file->id}}</td>
                                <td>
                                    <a class="img-preview" href="{{route('admin.file.download', ['id' => $file->id])}}">Скачать/Просмотреть</a>
                                </td>
                                <td>{{$file->title}}</td>
                                <td>{{$file->type??"Не определен"}}</td>
                                <td>{{$file->size?round($file->size/1024):"Не определен"}}</td>
                                <td>{!! $count > 0?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-minus text-red"></i>' !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-default text-orange"  title="Править"  data-toggle="modal" data-target="#modal-default_{{$file->id}}" href="{{route('admin.file.edit', ['id' => $file->id])}}"><i class="fa fa-edit"></i></a>
                                        <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.file.remove', ['id' => $file->id])}}"><i class="fa fa-trash"></i></a>
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

        @foreach($data->items() as $file)
            <div class="modal fade" id="modal-default_{{$file->id}}">
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
@endsection

@section('js')

@endsection