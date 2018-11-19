@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">
@endsection

@section('page_header')
    Создать новый раздел
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.forum_sections')}}">Разделы Форума</a></li>
    <li class="active">Создать новый</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Новый раздел</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..." value="{{old('title')}}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-header">
                                        <h3 class="box-title">Имя:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="Имя..." value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-header">
                                        <h3 class="box-title">Описание:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="description" class="form-control" placeholder="Описание..." value="{{old('description')}}">
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Позиция:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="number" name="position" class="form-control" value="{{old('position')}}">
                                    @if ($errors->has('position'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        <label>
                                            <input type="checkbox" name="is_active" class="flat-red" {{old('is_active')?'checked':''}} value="1">
                                            Активный
                                        </label>
                                        @if ($errors->has('is_active'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('is_active') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        <label>
                                            <input type="checkbox" name="is_general" class="flat-red" {{old('is_general')?'checked':''}} value="1">
                                            Основной
                                        </label>
                                        @if ($errors->has('is_general'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('is_general') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        <label>
                                            <input type="checkbox" name="user_can_add_topics" class="flat-red" {{old('user_can_add_topics')?'checked':''}} value="1">
                                            Пользователь может добавлять записи
                                        </label>
                                        @if ($errors->has('user_can_add_topics'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('user_can_add_topics') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-md-offset-11">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-flat send-message-btn">Сохранить</button>
                                </div>
                            </div>

                            <!-- /.form group -->
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- FastClick -->
    <script src="{{route('home')}}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{route('home')}}/dist/js/demo.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

    //Date picker
    <script>
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
    </script>
@endsection