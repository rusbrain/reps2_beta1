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
                    <h3 class="box-title">Поиск файлов</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Поиск(Название, id, MimeType):</label>
                                    <input type="text" class="form-control" name="text" placeholder="Enter ..." value="{{$request_data['text']??''}}">
                                    @if ($errors->has('text'))
                                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('text') }}</strong>
                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-md-12">
                                        <label>Размер (в Kb):</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" style="width: 100%;" name="size_to">
                                            <option value="">Select...</option>
                                            <option value="1" @if(isset($request_data['size_to']) && $request_data['size_to'] == '1') selected @endif>Больше</option>
                                            <option value="0" @if(isset($request_data['size_to']) && $request_data['size_to'] == '0') selected @endif>Меньше</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="size" placeholder="Enter ..." value="{{$request_data['size']??''}}">
                                    </div>
                                    <div class="col-md-12">
                                    @if ($errors->has('size_to'))
                                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('size_to') }}</strong>
                            </span>
                                    @endif
                                    @if ($errors->has('size'))
                                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('size') }}</strong>
                            </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-3 ">
                                    <label>Сортировать по:</label>
                                    <select class="form-control" style="width: 100%;" name="sort">
                                        <option value="">Select...</option>
                                        <option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>
                                        <option value="title" @if(isset($request_data['sort']) && $request_data['sort'] == 'title') selected @endif>Название</option>
                                        <option value="type" @if(isset($request_data['sort']) && $request_data['sort'] == 'type') selected @endif>MimeType</option>
                                        <option value="size" @if(isset($request_data['sort']) && $request_data['sort'] == 'size') selected @endif>Размер</option>
                                        <option value="created_at" @if(isset($request_data['sort']) && $request_data['sort'] == 'created_at') selected @endif>Дате добавленя</option>
                                    </select>
                                    @if ($errors->has('sort'))
                                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('sort') }}</strong>
                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Поиск</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Карты Replay ({{$file_count}})</h3>
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
                    <div class="box-tools pagination-content">
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
                        <tbody class="table-content">
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix pagination-content">
                </div>
            </div>
        </div>
<div class="pop-up-content"></div>
@endsection

@section('js')
    <script>
        $(function () {
            getFiles(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getFiles(page);
            })
        });

        function getFiles(page) {
            $.get('{{route('admin.file.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection