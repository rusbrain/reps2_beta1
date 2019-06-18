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
            <div class="row">
            @foreach($messages_list as $dialog)
            <div>{{$dialog->senders->first()->name}}</div>
            <div>{{strip_tags($dialog->messages_last->message)}}</div>
            <div>{{$dialog->messages_last->created_at}}</div>
            <div>{{$dialog->messages_last->user_id}}</div>
            @endforeach
            </div>
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