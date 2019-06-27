@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Заголовок  - {{$data->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.stream.header')}}">Заголовок</a></li>
    <li class="active">Заголовок: {{$data->title}}</li>
@endsection

@section('content')
   
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
           
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" action="{{route('admin.stream.header.update',['id' => $data->id])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..."
                                           value="{{old('title')??$data->title}}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Url:</h3>
                                    </div>
                                    <input type="text" name="url" class="form-control" placeholder="Url..."
                                            value="{{old('url')??$data->url}}">
                                    @if ($errors->has('url'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>                           
                            
                            <div class="row">
                                <div class="col-md-1 col-md-offset-11">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-flat send-message-btn">Сохранить
                                    </button>
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

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

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