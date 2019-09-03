@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')
@inject('general_helper', 'App\Services\GeneralViewHelper')
<?php
$countries = $general_helper->getCountries();
$races = \App\Replay::$races;
$extraSmiles = $general_helper->getextraSmiles();
?>
@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>

    <!--JS plugin Select2 - autocomplete -->
    <link rel="stylesheet" href="{{route('home')}}/css/select2.min.css"/>
    <style>
    .select2-container .select2-selection--single{
        height: 34px !important;
    }
    </style>
@endsection

@section('page_header')
    Редактировать {{$stream->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.stream')}}">Streams</a></li>
    <li class="active">Редактировать {{$stream->title}}</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Редактировать {{$stream->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Название:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <input type="text" name="title" class="form-control" placeholder="Название..." value="{{old('title')??$stream->title}}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Первая раса:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="race">
                                            @foreach(\App\Stream::$races as $race)
                                                <option value="{{$race}}" {{$race == $stream->race?'selected':''}}>{{$race}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('race'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('race') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="box-header">
                                        <h3 class="box-title">Первая страна:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control form-select-2" name="country_id">
                                            @foreach($admin_helper->getCountries() as $country)
                                                <option value="{{$country->id}}" {{$country->id == $stream->country_id?'selected':''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country_id'))
                                            <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <br>
                                        <label>
                                            <input type="checkbox" name="approved" class="flat-red" {{old('approved')?'checked':($stream->approved?'checked':'')}} value="1">
                                            Подтвердить
                                        </label>
                                        @if ($errors->has('approved'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('approved') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box-header">
                                        <h3 class="box-title">Комментарий:</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body pad">
                                            <textarea
                                                    id="content"
                                                    name="content"
                                                    rows="10"
                                                    cols="80">{!! old('content')??$general_helper->removeExtraTag($stream->content) !!}</textarea>
                                    </div>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="box-body pad">
                                        <div class="box-header">
                                            <h3 class="box-title">Вставить HTML код с Youtube с видео реплеем:</h3>
                                         </div>
                                        <textarea name="stream_url"
                                                  class="form-control {{ $errors->has('stream_url') ? ' is-invalid' : '' }}"
                                                  id="stream_url" rows="10">{!! $stream->stream_url??old('stream_url') !!}</textarea>
                                        @if ($errors->has('stream_url'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('stream_url') }}</strong>
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
    <div id="preview" style="display:none"></div>
@endsection

@section('js')
    <!-- FastClick -->
    <script src="{{route('home')}}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{route('home')}}/dist/js/demo.js"></script>

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>

    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.bbcode.min.js"></script>
    <script src="{{route('home')}}/js/html2bbcode.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

    <!--JS plugin Select2 - autocomplete -->
    <script src="{{route('home')}}/js/select2.full.min.js"></script>

    <script>
        //Date picker
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            /**
             * Convert Html to Bbcode
             */
            var div = $("#preview");
            div.html($('#content').val());
            output = bbencode(div);
            console.log(output)
            $('#content').val(output);
            div.html('');

            addUpload();
            addStream();
            var extraSmiles = <?php echo json_encode($extraSmiles) ?>;
            if ($('#content').length > 0) {
                var content = document.getElementById('content');

                sceditor.create(content, {
                    format: 'bbcode',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/images/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                        'left,center,right,justify|' +
                        'font,size,color,removeformat|' +
                        'source,quote,code|' +
                        'image,link,unlink|' +
                        'emoticon|' +
                        'date,time|' +
                        'countries|'+
                        'races|' +
                        'upload',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(extraSmiles),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }

            if ($('#stream_url').length > 0) {
                var stream_url = document.getElementById('stream_url');

                sceditor.create(stream_url, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/images/',
                    locale: 'ru',
                    toolbar: 'streams'
                });
            }
        });
        $(function () {
            if($('.form-select-2').length > 0){
                $('.form-select-2').select2({

                });
            }
        });
    </script>
@endsection
