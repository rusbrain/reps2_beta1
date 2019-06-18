@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!-- User messages widget -->
    @include('sidebar-widgets.user-messages',['all_new_messages'=>collect($contacts->items())->sum('new_messages'),'contacts' => $contacts])
    <!-- END User Messages widget -->
@endsection

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
            <div class="row">
                <div class="user-messages-info">
                    @if($user->avatar)
                        <a href="{{route('user_profile',['id' => $user->id])}}" class="margin-right-5">
                            <img src="{{$user->avatar->link}}" alt="" class="margin-right-5">
                        </a>
                    @else
                        <a href="{{route('user_profile',['id' => $user->id])}}"
                           class="logged-user-avatar no-header margin-right-5">A</a>
                    @endif
                    <a href="{{route('user_profile',['id' =>$user->id])}}" class="user-name">{{$user->name}}</a>

                    @if($general_helper->isOnline($user))
                        <!-- if online displays this -->
                        <span class="user-online-status">online</span>
                    @else
                        <!-- if INACTIVE displays this -->
                        <div class="user-last-online">{{$user->activity_at??'offline'}}</div>
                    @endif
                </div>
            </div>
            <!-- CHAT MESSAGES -->
            <div class="messages-wrapper messages-box">
                @include('user.messages-partials.message_parse')
            </div>
            <!--END CHAT MESSAGES -->
        </div>

        <!-- ADD MESSAGE FORM -->
        <div class="col-md-12">
            @include('user.messages-partials.add-message-form')
        </div>
        <!-- END ADD MESSAGE FORM -->
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
            if ($('.user-message-form').length > 0) {
                var textarea = document.getElementById('message');

                sceditor.create(textarea, {
                    format: 'xhtml',
                    style: '{{route('home')}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route('home')}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });

                $('body').on('submit','.user-message-form', function (e) {
                    e.preventDefault();
                    var message = $('.send-message-text').val().substring(0, 1000);

                    /**clean textarea field*/
                    sceditor.instance(textarea).val('');

                    $.post(
                        '{{route('user.message.send', ['id'=>$dialog_id])}}',
                        {
                            message: message,
                            _token: '{{csrf_token()}}'
                        },
                        function (data) {
                            $('.messages-box').html(data);
                            $('.messages-box').scrollTop($(".scroll-to").offset().top);
                        }
                    );
                });

                $('body').find('.messages-box').scrollTop($(".scroll-to").offset().top);

                $('body').on('click', '.load-more', function () {
                    var url = $('.load-more').attr('date-href');

                    $.get(
                        url,
                        {
                            _token: '{{csrf_token()}}'
                        },
                        function (data) {
                            $('.load-more-box').remove();
                            $('.messages-box').prepend(data);
                        }
                    );
                })
            }
        });
    </script>
@endsection