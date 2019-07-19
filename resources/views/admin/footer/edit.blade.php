@extends('admin.layouts.admin')
@inject('general_helper', 'App\Services\GeneralViewHelper')
<?php
$countries = $general_helper->getCountries();
$races = \App\Replay::$races;
$extraSmiles = $general_helper->getextraSmiles();
?>
@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Подвал сайта: редактирование виджета - {{$footer_widget->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.footer')}}">Подвал/Футер сайта</a></li>
    <li class="active">Редактирование виджета: {{$footer_widget->title}}</li>
@endsection

@section('content')
    {{--{{dd($footer_widget)}}--}}
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$footer_widget->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" action="{{route('admin.footer.update',['id' => $footer_widget->id])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..."
                                           value="{{old('title')??$footer_widget->title}}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div>
                                            <div class="box-header">
                                                <h3 class="box-title">Текст:</h3>
                                                <!-- /. tools -->
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body pad">
                                                <textarea id="text"
                                                          name="text"
                                                          rows="5"
                                                          cols="80">{!! old('text')??$footer_widget->text !!}</textarea>
                                            </div>
                                            @if ($errors->has('text'))
                                                <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('text') }}</strong>
                                            </span>
                                            @endif
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
                                            </div><!-- /.box-header -->
                                            <div class="box-body pad">
                                                <input type="email" id="email" name="email"
                                                       value="{{old('email')??$footer_widget->email}}"
                                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div>
                                            <div class="box-header">
                                                <h3 class="box-title">ICQ:</h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body pad">
                                                <input type="icq" id="icq" name="icq"
                                                       value="{{old('icq')??$footer_widget->icq}}"
                                                       class="form-control {{ $errors->has('icq') ? ' is-invalid' : '' }}">
                                                @if ($errors->has('icq'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('icq') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="box-header">
                                        <h3 class="box-title">Позиция:</h3>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="position">
                                            <option value="1" {{$footer_widget->position == 1?'selected':''}}>1
                                            </option>
                                            <option value="2" {{$footer_widget->position == 2?'selected':''}}>2
                                            </option>
                                            <option value="3" {{$footer_widget->position == 3?'selected':''}}>3
                                            </option>
                                            <option value="4" {{$footer_widget->position == 4?'selected':''}}>4
                                            </option>
                                            <option value="5" {{$footer_widget->position == 5?'selected':''}}>5
                                            </option>
                                        </select>
                                        @if ($errors->has('position'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('position') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="box-header">
                                            <h3 class="box-title">Подтвердить
                                                <input type="checkbox" name="approved" class="flat-red"
                                                       {{old('approved')?'checked':($footer_widget->approved?'checked':'')}} value="1">
                                                @if ($errors->has('approved'))
                                                    <span class="invalid-feedback text-red" role="alert">
                                                        <strong>{{ $errors->first('approved') }}</strong>
                                                    </span>
                                                @endif
                                            </h3>
                                            <!-- /. tools -->
                                        </div>
                                    </div>
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

        $(function () {
            if ($('#text').length > 0) {
                var content = document.getElementById('text');
                var extraSmiles = <?php echo json_encode($extraSmiles) ?>;
                sceditor.create(content, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/images/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                        'left,center,right,justify|' +
                        'font,size,color,removeformat|' +
                        'source,quote,code|' +
                        'link,unlink|' +
                        'emoticon|' +
                        'date,time',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(extraSmiles),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection