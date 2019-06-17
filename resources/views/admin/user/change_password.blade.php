
@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('page_header')
Изменить пароль  {{$user->name}}
@endsection
@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$user->name}}</h3>
                </div>

                <div class="box-body">
                    @if($success = Session::get("updated_password"))
                        <div class="alert alert-success form-group">
                            <span class="help-error">
                                <strong>{{$success}}</strong>
                            </span>
                        </div><br>
                    @endif
                    @if($failed = Session::get("server_error"))
                        <div class="alert alert-error form-group">
                            <span class="help-error">
                                <strong>{{$failed}}</strong>
                            </span>
                        </div><br>
                    @endif
                    <form action="{{route('admin.user.update_password')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}" />
                        <div class="row">
                            <div class="col-md-6">
                             
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-chrome margin-r-5"></i></span>
                                    <input type="password" name="old_password" class="form-control" placeholder="Прежний пароль" value="{{old('old_password')}}" autocomplete="off">
                                </div>
                                @if($wrong_password = Session::get("errors_password"))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $wrong_password }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-chrome margin-r-5"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Новый пароль" value="" autocomplete="off">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-chrome margin-r-5"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Подтвердите пароль" value="" autocomplete="off">
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                                <br>
                                
                            </div><!-- /.col-md-6 -->
                        
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" class="btn btn-info pull-right">Обновить</button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div><!-- /.row -->
@endsection

@section('js')
    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        //Date picker
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        $(function () {
            if($('.form-select-2').length > 0){
                $('.form-select-2').select2({

                });
            }
        });
    </script>
@endsection