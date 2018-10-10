@extends('admin.layouts.admin')

@section('css')

@endsection

@section('page_header')
    Переписка с {{$user->name}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Переписка с {{$user->name}}</li>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-7 col-md-offset-4">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$user->name}}</h3>

                    <div class="box-tools pull-right">
                        {{--<span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>--}}
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages messages-box" style="height: 70vh">
                        @include('admin.user.message_parse')
                        <div class="scroll-to"></div>
                    </div>
                    <!--/.direct-chat-messages-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--<form action="#" method="post">--}}
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control send-message-text">
                            <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat send-message-btn">Отправить</button>
                      </span>
                        </div>
                    {{--</form>--}}
                </div>
                <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
        </div>

    </div>
@endsection

@section('js')
            <script>
                $(function () {
                    $('.messages-box').scrollTop($(".scroll-to").offset().top);
                    // $('.messages-box').scrollTo('.scroll-to');

                    $('.send-message-btn').on('click', function () {
                        var message = $('.send-message-text').val();
                        var url = $('.load-more').attr('date-href');
                        $('.send-message-text').val('');
                        console.log(message, url);
                        $.post(
                            '{{route('admin.user.message.send', ['id'=>$user->id])}}',
                            {
                                message: message,
                                _token: '{{csrf_token()}}',
                            },
                            function (data) {
                                $('.messages-box').html(data);
                            }
                        );
                    })

                    $('.messages-box').on('click', '.load-more', function () {
                        var url = $('.load-more').attr('date-href');
                        console.log(url);
                        $.post(
                            url,
                            {
                                _token: '{{csrf_token()}}',
                            },
                            function (data) {
                                $('.load-more-box').remove();
                                $('.messages-box').prepend(data);
                            }
                        );
                    })
                })
            </script>
@endsection