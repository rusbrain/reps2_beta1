@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

@endsection

@section('page_header')
    Баннеры: просмотр баннера - {{$banner->title}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.banner')}}">Баннеры</a></li>
    <li class="active">{{$banner->title}}</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$banner->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post site-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">Изображение:</h3>
                                        </div><!-- /.box-header -->
                                        <div class="banner-img-wrapper">
                                            @if($banner->file)
                                                <img class="img-preview"
                                                     src="{{route('home').($banner->file->link??'/dist/img/default-50x50.gif')}}"
                                                     alt="Изображение">
                                            @else
                                                <span>Не указано</span>
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
                                        <span>{{$banner->title}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div>
                                        <div class="box-header">
                                            <h3 class="box-title">Ссылка:</h3>
                                            @if($banner->url_redirect)
                                                <span>{{$banner->url_redirect}}</span>
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
                                    <div class="box-header">
                                        <h3 class="box-title">Активный:</h3>
                                        <input type="checkbox" name="is_active" class="flat-red" disabled
                                               {{$banner->is_active?'checked':''}} value="1">
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