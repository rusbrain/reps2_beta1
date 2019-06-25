@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Создать новую тему
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.forum_topic')}}">Темы Форума</a></li>
    <li class="active">Новая тема</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Новая тема</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Раздел:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="section_id">
                                            @foreach($sections as $section)
                                                <option value="{{$section->id}}" {{$section->id == old('section_id')?'selected':''}}>{{$section->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
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


                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Превью:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Загрузить картинку превью</label>
                                        <input type="file" id="preview_img" name="preview_img">
                                    </div>
                                    @if ($errors->has('avatar'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div>
                                            <div class="box-header">
                                                <h3 class="box-title">Сокращенное содержание:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body pad">
                                        <textarea id="preview_content" name="preview_content" rows="5" cols="80">
                                                                {!! old('preview_content')!!}
                                        </textarea>
                                            </div>
                                            @if ($errors->has('preview_content'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('preview_content') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <div class="box-header">
                                        <h3 class="box-title">Содержание:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body pad">
                                        <textarea id="content" name="content" rows="10" cols="80">
                                                                {!! old('content')!!}
                                        </textarea>
                                    </div>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Date -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="box-header">
                                            <h3 class="box-title">Опубликовать с:</h3>
                                            <!-- /. tools -->
                                        </div>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="start_on" class="form-control pull-right" id="datepicker" value="{{old('start_on')}}">
                                            @if ($errors->has('start_on'))
                                                <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('start_on') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-1">
                                    <br>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="news" class="flat-red" {{old('news')?'checked':''}} value="1">
                                                Отображать в новостях
                                            </label>
                                            @if ($errors->has('news'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                    <strong>{{ $errors->first('news') }}</strong>
                                                </span>
                                            @endif
                                        </div>                                       
                                        <!-- /.input group -->
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

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

    //Date picker
    <script>
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        $(function () {
            addCountries();
            addRaces();
            addUpload();

            if ($('#content').length > 0) {
                var content = document.getElementById('content');

                sceditor.create(content, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time|' +
                    'countries|'+
                    'races|'+
                    'img|' +
                    'upload',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }

            if ($('#preview_content').length > 0) {
                var preview_content = document.getElementById('preview_content');

                sceditor.create(preview_content, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time|' +
                    'countries|'+
                    'races|'+
                    'img|' +
                    'upload',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection
