@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

@endsection

@section('page_header')
    Баннеры: Редактирование баннера: {{$banner->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.banner')}}">Баннеры</a></li>
    <li class="active">Редактирование баннера</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Редактирование баннер: {{$banner->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" action="{{route('admin.banner.update', ['id' => $banner->id])}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="box-header">
                                                <h3 class="box-title">Баннер:</h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body pad">
                                                <label for="banner">
                                                <span class="preview-image-wrapper">
                                                    <img class="img-preview"
                                                         src="{{route('home').($banner->file->link??'/dist/img/default-50x50.gif')}}"
                                                         alt="Изображение">
                                                </span>
                                                </label>
                                                <input type="file" id="banner"
                                                       class="form-control-file {{ $errors->has('preview_img') ? ' is-invalid' : '' }}"
                                                       name="banner">
                                                @if ($errors->has('banner'))
                                                    <span class="invalid-feedback text-red">
                                                        <strong>{{ $errors->first('banner') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="box-header">
                                            <h3 class="box-title">Название:</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body pad">
                                            <input type="text" name="title" class="form-control" placeholder="Название..."
                                                   value="{{old('title')??$banner->title}}">
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="box-header">
                                            <h3 class="box-title">Ссылка</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body pad">
                                            <input type="text" id="url_redirect" name="url_redirect"
                                                   value="{{old('url_redirect')??$banner->url_redirect}}"
                                                   class="form-control {{ $errors->has('url_redirect') ? ' is-invalid' : '' }}">
                                            @if ($errors->has('url_redirect'))
                                                <span class="invalid-feedback text-red">
                                                    <strong>{{ $errors->first('url_redirect') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="box-header">
                                            <h3 class="box-title">Активный
                                                <input type="checkbox" name="is_active" class="flat-red"
                                                       {{old('is_active')?'checked':($banner->is_active?'checked':'')}}
                                                       value="1">
                                                @if ($errors->has('is_active'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                        <strong>{{ $errors->first('is_active') }}</strong>
                                                    </span>
                                                @endif
                                            </h3><!-- /.box-title -->
                                        </div><!-- /.box-header -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1 col-md-offset-11">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-flat send-message-btn">
                                        Сохранить
                                    </button>
                                </div>
                            </div>
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

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>
    <script>
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>
@endsection