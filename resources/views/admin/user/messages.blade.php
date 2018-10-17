@extends('admin.layouts.admin')

@section('css')
<style>
    .user_message_list li{
        width: 100%;
    }
    .users-list>li img{
        width: auto;
        max-width: 150px;
        height: 60px;
        border-radius:0;
    }
</style>
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
    @php
        $all_new_messages = collect($contacts->items())->sum('new_messages');
        $end = 'й';
        $ost = $all_new_messages%10;
        if(10 > $all_new_messages || $all_new_messages > 20){
            if($ost == 1){
                $end = 'е';
            } elseif($ost > 1 && $ost < 5){
                $end = 'я';
            }
        }
    @endphp
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <!-- USERS LIST -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Переписки</h3>

                    <div class="box-tools pull-right">
                       @if($all_new_messages) <span class="badge bg-red">{{$all_new_messages}} Новых сообщени{{$end}}</span>@endif
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding"  style="height: 73vh; overflow-y: auto; overflow-x: hidden;">
                    <ul class="row users-list clearfix user_message_list">
                        @include('admin.user.contact_parse')
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">

                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>
        <div class="col-md-6 col-md-offset-1">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$user->name}}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages messages-box" style="height: 70vh">
                        @include('admin.user.message_parse')
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
                            '{{route('admin.user.message.send', ['id'=>$dialog_id])}}',
                            {
                                message: message,
                                _token: '{{csrf_token()}}',
                            },
                            function (data) {
                                $('.messages-box').html(data);
                                $('.messages-box').scrollTop($(".scroll-to").offset().top);
                            }
                        );
                    });

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