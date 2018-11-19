@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
@endsection

@section('page_header')
    Отправить Email {{$user->name}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Отправить Email {{$user->name}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>

                    <h3 class="box-title">Email</h3>
                </div>
                <div class="box-body">
                    <form action="{{route('admin.send_quick_email')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="emailto"><h4>TO: {{$user->name}}</h4></label>
                            <input type="hidden" class="form-control" name="emailto" placeholder="Email to:" value="{{$user->email}}">

                            @if ($errors->has('emailto'))
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('emailto') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Subject">
                            @if ($errors->has('subject'))
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div>
                  <textarea class="textarea" placeholder="Message" name="content"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                        @endif
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default" id="sendEmail">Send
                                <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- /.col -->
    </div>

@endsection

@section('js')

@endsection