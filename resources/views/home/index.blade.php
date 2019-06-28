@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

{{-- Stream Section --}}

@section('stream-header')
    <!-- Headline -->
    @include('stream-section.headline')
    <!-- END Headline -->
@endsection

@section('stream-message')
    @include('stream-section.message')
@endsection

@section('video-frame-section')
    @include('stream-section.stream')
@endsection

@section('stream-list')
    @include('stream-section.stream-list')
@endsection

{{-- Main Section --}}
@section('sidebar-left')
    <!-- Gosu Replay -->
    @include('sidebar-widgets.gosu-replays')
    <!-- END Gosu Replay -->

    <!-- Main Forum Topics -->
    @include('sidebar-widgets.general-forum-sections')
    <!-- END Main Forum Topics -->
@endsection

@section('content')
    <!--Last Forums-->
    <div id="ajax_last_forums">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!--END Last Forums-->

    <!--  PAGINATION -->
    <div class="pagination-content"></div>
    <!-- END  PAGINATION -->
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

    <!-- Top Points Users-->
    @include('sidebar-widgets.top-pts-users')
    <!-- END New Users-->

    <!-- Top Rating Users-->
    @include('sidebar-widgets.top-rating-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    {{-- @include('sidebar-widgets.users-replays') --}}
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection

@section('js')
    <script>
        $(function () {
            getLastNews(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                $('.load-wrapp').show();
                var page = $(this).attr('data-page');
                getLastNews(page);
            })

            // Stream section collapse and expand
            var toggle_flag = 0;
            $(".toggle-action").on("click", function(){
                toggle_flag = !toggle_flag;
                $(".stream-section").slideToggle(function(){
                    if (toggle_flag)
                        $(".toggle-action").text('show')
                    else
                        $(".toggle-action").text('hide')
                });
            })
        });

        function getLastNews(page) {
            var container = $('#ajax_last_forums');
            var body = $("html, body");

            $.get('{{route('home.last_forum.pagination')}}'+'?page='+page, {}, function (data) {
                container.html(data.news);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection