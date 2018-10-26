@extends('admin.layouts.admin')


@section('css')
@endsection

@section('page_header')
    Dashboard
    <small>Control panel</small>
@endsection

@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active">Dashboard</li>
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua-gradient">
                    <div class="inner">
                        <h3>{{$topic_count}}</h3>

                        <p>Forum Topics</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list-outline"></i>
                    </div>
                    <a href="{{route('admin.forum_topic')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-light-blue-gradient">
                    <div class="inner">
                        <h3>{{$gosu_replay_count}}</h3>

                        <p>Gosu Replays</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-film-outline"></i>
                    </div>
                    <a href="{{route('admin.replay', ['users' => '0'])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal-gradient">
                    <div class="inner">
                        <h3>{{$user_replay_count}}</h3>

                        <p>User Replays</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-film"></i>
                    </div>
                    <a href="{{route('admin.replay', ['users' => 1])}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple-gradient">
                    <div class="inner">
                        <h3>{{$user_count}}</h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="{{route('admin.users')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

        <!-- quick email widget -->
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-envelope"></i>

                <h3 class="box-title">Быстрая отправка Email</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <form action="{{route('admin.send_quick_email')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="emailto" placeholder="Email to:">
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
                        <textarea class="textarea" placeholder="Message" name="content" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
@endsection

@section('js')
@endsection