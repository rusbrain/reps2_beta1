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
    <li class="active">Карты Replay</li>
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
                    <h3 class="box-title">Поиск карт</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Поиск(Название, id):</label>
                                    <input type="text" class="form-control" name="text" placeholder="Enter ..." value="{{$request_data['text']??''}}">
                                </div>
                                <div class="form-group col-md-3 col-md-offset-6">
                                    <label>Сортировать по:</label>
                                    <select class="form-control" style="width: 100%;" name="sort">
                                        <option value="">Select...</option>
                                        <option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>
                                        <option value="name" @if(isset($request_data['sort']) && $request_data['sort'] == 'name') selected @endif>Название</option>
                                    </select>
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
                    <h3 class="box-title">Карты Replay ({{$maps_count}})</h3>
                    <a class="btn btn-info" data-toggle="modal" data-target="#modal-default_add" href="{{route('admin.replay.map.add')}}">Создать</a>
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
                            <th style="width: 220px">Карта</th>
                            <th>Название</th>
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

        <div class="modal fade" id="modal-default_add">
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
            getFiles(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getFiles(page);
            })
        });

        function getFiles(page) {
            $.get('{{route('admin.replay.map.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection