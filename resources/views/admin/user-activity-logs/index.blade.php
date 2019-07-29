@extends('admin.layouts.admin')

@section('page_header')
    Пользователи
    <small>Лог активности</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Лог активности</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.css" />

    <style>
        .select2-container .select2-selection--single {
            height: 34px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }
    </style>
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
                    <h3 class="box-title">Поиск</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Тип:</label>
                                    <select class="form-control" style="width: 100%;" name="type">
                                        <option value="">Select...</option>
                                        @foreach(\App\Services\Base\UserActivityLogService::getEventTypes() as $type)
                                            <option value="{{$type}}" @if(isset($request_data['type']) && $request_data['type'] == $type) selected @endif>{{__('messages.user_activity_log.type.'.$type)}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Пользователь:</label>
                                    <select id="user-filter-dropdown" class="form-control" style="width: 100%;" name="user_id" value="{{$request_data['user_id'] ?? null}}">
                                        @if ($selectedUser)
                                            <option value="{{$selectedUser->id}}" selected="selected">{{$selectedUser->name}}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Дни:</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input form-control" name="start" autocomplete="off" value="{{$request_data['start']}}"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input form-control" name="end" autocomplete="off" value="{{$request_data['end']}}"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="text-right">
                                        <a href="{{route('admin.user.activity-log')}}" class="btn btn-default">Сброс</a>
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
                    <h3 class="box-title">Лог активности</h3>
                    <div class="box-tools pagination-content">
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Событие</th>
                                <th>Пользователь</th>
                                <th>Время</th>
                                <th>Описание</th>
                                <th>Подробно</th>
                            </tr>
                        </thead>
                        <tbody class="table-content">
                        </tbody>
                    </table>
                </div>

                <div class="box-footer clearfix pagination-content">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="{{route('home')}}/bower_components/select2/dist/js/select2.js"></script>

    <script>
        $(function () {
            getLogs(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getLogs(page);
            })

            $('.input-daterange').datepicker({
                format: "yyyy-mm-dd"
            });

            $('#user-filter-dropdown').select2({
                ajax: {
                    url: "{{route('admin.user.activity-log.users-query')}}",
                },
                // minimumInputLength: 3
            });
        });

        function getLogs(page) {
            $.get('{{route('admin.user.activity-log.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection
