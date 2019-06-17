@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@inject('MessageService','App\Services\User\MessageService')

@section('content')
    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="{{route('user_profile',['id' =>Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="" class="active">/ Мои сообщения</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Мои сообщения</div>
        </div>
        <div class="col-md-12">
        @foreach($messages_list as $dialog)
            <div href="{{route('user.messages',['id' => $dialog->senders->where('id','<>',Auth::id())->first()->id])}}" class="dialog-slot row @if($dialog->messages_last->is_read == 0 and ($dialog->messages_last->user_id != Auth::id())) dialog-new-message @endif">
            <div class="dialog user-name">
                {{$dialog->senders->where('id','<>',Auth::id())->first()->name}}
            </div>
            <div class="dialog user-message-line">
            <div class="dialog message">
                @if($dialog->messages_last->user_id == Auth::id())
                <span class="me">Я:</span>
                @endif
                <div class="message-body @if($dialog->messages_last->is_read == 0 and ($dialog->messages_last->user_id == Auth::id())) dialog-new-message @endif">{{strip_tags($dialog->messages_last->message)}}</div>
            </div>
            @if(($dialog->messages_last->created_at->format('Y-m-d') != now()->format('Y-m-d')) and ($dialog->messages_last->created_at->format('Y') == now()->format('Y')))
                <div class="dialog date" >{{date_format($dialog->messages_last->created_at, 'd-M H:i')}}</div>
            @elseif(($dialog->messages_last->created_at < now()) and ($dialog->messages_last->created_at->format('Y') != now()->format('Y')))
                <div class="dialog date" >{{date_format($dialog->messages_last->created_at, 'Y-d-M H:i')}}</div>
            @elseif($dialog->messages_last->created_at->format('Y-m-d') == now()->format('Y-m-d') )
                <div class="dialog date" >Сегодня, {{date_format($dialog->messages_last->created_at, 'H:i')}}</div>
            @endif
            @if($dialog->messages->where('is_read', 0)->where('user_id','<>', Auth::id())->count())
            <span class="count-msg">{{$dialog->messages->where('is_read',0)->where('user_id','<>', Auth::id())->count()}}</span>
            @endif
            </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection

@section('js')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>

    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>
    <script>
        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            $('.dialog-slot').on('click', function(){
                window.location.replace($(this).attr('href'));
            })
        });
    </script>
@endsection