@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

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
Hастройки
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.stream')}}">Cтрим</a></li>
    <li class="active">Hастройки</li>
@endsection
{{-- @php dd($settings); @endphp --}}
@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">Hастройки</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <form action="{{route('admin.stream.setting.save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">                               
                                <div class="col-md-12">
                                    <div class="form-group">                                       
                                        <br>
                                        <label>
                                            <input type="checkbox" name="headline" class="flat-red" {{old('headline')?'checked':((!empty($settings) && $settings->headline)?'checked':'')}} value="1">
                                            Заголовок
                                        </label>
                                        @if ($errors->has('headline'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('headline') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>                              
                            </div>    
                            <div class="row">                               
                                <div class="col-md-12">
                                    <div class="form-group">                                       
                                        <br>
                                        <label>
                                            <input type="checkbox" name="main_section" class="flat-red" {{old('main_section')?'checked':((!empty($settings) && $settings->main_section)?'checked':'')}} value="1">
                                            Cтрим раздел
                                        </label>
                                        @if ($errors->has('main_section'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('main_section') }}</strong>
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

@endsection
