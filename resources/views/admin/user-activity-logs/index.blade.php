@extends('admin.layouts.admin')

@section('page_header')
    Пользователи
    <small>Лог активности</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Лог активности</li>
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
    <script>
        $(function () {
            getLogs(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getLogs(page);
            })
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
