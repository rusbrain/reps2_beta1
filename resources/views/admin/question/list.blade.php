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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Опросы ({{$data->total()}})</h3>
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
                        <th>Вопрос</th>
                        <th>Количество вариатов</th>
                        <th>Количество ответов</th>
                        <th>Активный</th>
                        <th>Только для авторизированных</th>
                        <th>Приоритетный</th>
                        <th style="width: 250px">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data->items() as $question)
                    <tr>
                        <td>{{$question->id}}</td>
                        <td>{{$question->question}}</td>
                        <td>{{$question->answers_count}}</td>
                        <td>{{$question->user_answers_count}}</td>
                        <td>{!! $question->is_active?'<i class="fa fa-check text-aqua"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
                        <td>{!! $question->for_login?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-minus"></i>' !!}</td>
                        <td>{!! $question->is_favorite?'<i class="fa fa-plus text-green"></i>':'<i class="fa fa-minus text-gray"></i>' !!}</td>
                        <td>
                            <div class="btn-group">
                                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть профиль пользователя" data-toggle="modal" data-target="#modal-default_view_{{$question->id}}" href="{{route('admin.question.view', ['id' => $question->id])}}"><i class="fa fa-eye"></i></a>
                                <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_edit_{{$question->id}}" href="{{route('admin.question.edit', ['id' => $question->id])}}"><i class="fa fa-edit"></i></a>
                                @if(!$question->is_active)
                                    <a type="button" class="btn btn-default text-aqua" title="Сделать активным" href="{{route('admin.question.active', ['id' => $question->id])}}"><i class="fa fa-check"></i></a>
                                @else
                                    <a type="button" class="btn btn-default text-red"  title="Сделать не активным" href="{{route('admin.question.not_active', ['id' => $question->id])}}"><i class="fa fa-clock-o"></i></a>
                                @endif
                                @if(!$question->for_login)
                                    <a type="button" class="btn btn-default text-green" title="Сделать доступным только для авторизорованных" href="{{route('admin.question.for_login', ['id' => $question->id])}}"><i class="fa fa-check"></i></a>
                                @else
                                    <a type="button" class="btn btn-default"  title="Сделать доступным для всех" href="{{route('admin.question.not_for_login', ['id' => $question->id])}}"><i class="fa fa-minus"></i></a>
                                @endif
                                @if(!$question->is_favorite)
                                    <a type="button" class="btn btn-default text-green" title="Сделать приоритетным" href="{{route('admin.question.favorite', ['id' => $question->id])}}"><i class="fa fa-plus"></i></a>
                                @else
                                    <a type="button" class="btn btn-default text-gray"  title="Сделать не приоритетным" href="{{route('admin.question.not_favorite', ['id' => $question->id])}}"><i class="fa fa-minus"></i></a>
                                @endif
                                <a type="button" class="btn btn-default text-red"  title="Удалить пользователя" href="{{route('admin.question.remove', ['id' => $question->id])}}"><i class="fa fa-trash"></i></a>
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
@foreach($data->items() as $question)
<div class="modal fade" id="modal-default_view_{{$question->id}}">
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
<div class="modal fade modal-default_edit" id="modal-default_edit_{{$question->id}}">
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
        $('.modal-default_edit').on('click', '.add_input', function () {
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

        $('.modal-default_edit').on('click', '.remove_input', function () {
            console.log(this.dataset.answer);
            $('#'+this.dataset.answer).remove();
        })
    </script>
@endsection