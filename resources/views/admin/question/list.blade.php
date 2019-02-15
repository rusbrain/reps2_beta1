@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <style>
        .add_input:hover{
            cursor:pointer;
        }
    </style>
@endsection

@section('page_header')
Общее
<small>Опросы</small>
@endsection

@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
<li class="active">Опросы</li>
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
                <h3 class="box-title">Опросы ({{$question_count}})</h3>
                <a class="btn btn-info" data-toggle="modal" data-target="#modal-default-add" href="{{route('admin.question.add')}}">Создать</a>
                @if ($errors->has('question'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('question') }}</strong>
                            </span>
                @endif
                @if ($errors->has('new_answers'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('new_answers') }}</strong>
                            </span>
                @endif
                @if ($errors->has('old_answers'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('old_answers') }}</strong>
                            </span>
                @endif
                @if ($errors->has('new_answers.*'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('new_answers.*') }}</strong>
                            </span>
                @endif
                @if ($errors->has('old_answers.*'))
                    <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('old_answers.*') }}</strong>
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
                        <th>Вопрос</th>
                        <th>Количество вариатов</th>
                        <th>Количество ответов</th>
                        <th>Активный</th>
                        <th>Только для авторизированных</th>
                        <th>Приоритетный</th>
                        <th style="width: 250px">Действия</th>
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
    <!-- /.col -->
</div>
<div class="pop-up-content"></div>

<div class="modal fade modal-default_edit" id="modal-default-add">
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
        $('.pop-up-content').on('click', '.add_input', function () {
            console.log(this);
            $html = ' <div class="row">\n' +
                '                                <div class="col-md-10">\n' +
                '                                    <input type="text" name="new_answers[]" class="form-control" placeholder="Вариант ответа">\n' +
                '                                </div>\n' +
                '                                <div class="col-md-2">\n' +
                '                                    <h4>\n' +
                '                                        <i class="fa fa-plus text-green add_input" data-question="'+this.dataset.question+'"></i>\n' +
                '                                    </h4>\n' +
                '                                </div>\n' +
                '                            </div>';

            $("#"+this.dataset.question).append($html);
        });

        $('.pop-up-content').on('click', '.remove_input', function () {
            console.log(this.dataset.answer);
            $('#'+this.dataset.answer).remove();
        });

        $(function () {
            getQuestions(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getQuestions(page);
            })
        });

        function getQuestions(page) {
            $.get('{{route('admin.question.pagination')}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.pop-up-content').html(data.pop_up);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection