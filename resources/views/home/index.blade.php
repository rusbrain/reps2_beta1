@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!-- Gosu Replay -->
    @include('sidebar-widgets.gosu-replays')
    <!-- END Gosu Replay -->

    <!-- Main Forum Topics -->
    @include('sidebar-widgets.general-forum-sections')
    <!-- END Main Forum Topics -->
@endsection

@section('content')
    <!--Last News-->
    <div id="ajax_last_news" data-path="{{route('home.last_news')}}">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!--END Last News-->

    <!--Last Forums-->
    <div id="ajax_last_forums" data-path="{{route('home.last_forum')}}">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!--END Last Forums-->

    <!--Popular Forums-->
    <div id="ajax_top_forums" data-path="{{route('home.top_forum')}}">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!--END Popular Forums-->
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!--Votes-->
    @include('sidebar-widgets.votes')
    <!-- END Vote -->

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
    <script>
        $(function () {
            var last_news = $('#ajax_last_news');
            var last_forums = $('#ajax_last_forums');
            var top_forums = $('#ajax_top_forums');
            getLastNews(last_news);
            getLastNews(last_forums);
            getLastNews(top_forums);
        });
        function getLastNews(container) {
            $.get(container.attr('data-path'), {}, function (html) {
                container.html(html);
                container.find('.load-wrapp').hide();
            });
        }
    </script>
@endsection