@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Подвал сайта: просмотр виджета - {{$footer_widget->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.footer')}}">Подвал/Футер сайта</a></li>
    <li class="active">{{$footer_widget->title}}</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$footer_widget->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post site-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                        <span>{{$footer_widget->title}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">Текст:</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body pad">
                                            {!! $footer_widget->text !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">E-mail:</h3>
                                            @if($footer_widget->email)
                                                <span>{{$footer_widget->email}}</span>
                                            @else
                                                <span>Не указано</span>
                                            @endif
                                        </div><!-- /.box-header -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">ICQ:</h3>
                                            @if($footer_widget->icq)
                                                <span>{{$footer_widget->icq}}</span>
                                            @else
                                                <span>Не указано</span>
                                            @endif
                                        </div><!-- /.box-header -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="box-header">
                                        <h3 class="box-title">Позиция:</h3>
                                        <span>{{$footer_widget->position}}</span>
                                    </div><!-- /.box-header -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="box-header">
                                        <h3 class="box-title">Подтвердить:</h3>
                                        <input type="checkbox" name="approved" class="flat-red" disabled
                                               {{$footer_widget->approved?'checked':''}} value="1">
                                    </div><!-- /.box-header -->
                                </div>
                            </div>
                        </div>
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