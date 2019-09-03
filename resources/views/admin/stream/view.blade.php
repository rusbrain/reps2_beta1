@extends('admin.layouts.admin')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Stream
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.stream')}}">Streams</a></li>
    <li class="active">{{$stream->title}}</li>
@endsection

@section('content')
    {{--{{dd($stream)}}--}}
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{"Stream"}} / {{$stream->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-5">
                                            Название:
                                        </div>
                                        <div class="col-md-7">
                                            {{$stream->title}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Страны:
                                        </div>
                                        <div class="col-md-7">
                                            {{($stream->country->name)}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Расы:
                                        </div>
                                        <div class="col-md-7">
                                            {{$stream->race}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            Подтвержден:
                                        </div>
                                        <div class="col-md-7">
                                            {!! $stream->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            Коментарий:
                                        </div>
                                        <div class="col-md-7">
                                            {!! $general_helper->oldContentFilter($stream->content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                @if($stream->stream_url)
                                    <div class="video-link-wrapper">
                                        {!! $stream->stream_url !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="user-block">
                            @if(isset($stream->user->avatar))
                                <img class="img-circle img-bordered-sm" src="{{route('home').$stream->user->avatar->link}}" alt="User img">
                            @else
                                <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
                            @endif
                            <span class="username">
                                <a href="{{route('admin.user.profile', ['id' => $stream->user->id])}}">{{$stream->user->name}}</a>
                            </span>
                            <span class="description">{{$stream->created_at->format('h:m d-m-Y')}}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

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

    </script>
@endsection
