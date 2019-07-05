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

@section('stream-list')
    <div class="widget-wrapper">
        <div class="widget-header"></div>
        <div class="streams_list" id="ajax_streamlist_area">
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
            {{-- @include('stream-section.stream-list') --}}
        </div>
    </div>    
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
           
            // video stream
            getStreamsList(true);            

            $('.streams_list').on('click', '.widget-stream-lists a', function(e){               
                e.preventDefault();
                var selectId = $(this).attr('data-id');
                getSelectStream(selectId);
                $('.list_menu').removeClass('active');
                $(".stream-list-wrapper").removeClass('open');
                $('.streamlist').css('visibility','hidden')
            })

            // Last News
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
                if (toggle_flag) {
                    $(".stream-section").addClass('active')
                    $(".toggle-action").text('show')
                }else{
                    $(".stream-section").removeClass('active')
                    $(".toggle-action").text('hide')
                }
            })            
        });

        function getLastNews(page) {
            var container = $('#ajax_last_forums');
            var body = $("html, body");

            $.get('{{route('home.last_forum.pagination')}}'+'?page='+page, {}, function (data) {
                container.html(data.news);
                $('.pagination-content').html(data.pagination);
                $('#ajax_last_forums .load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }

        function getSelectStream(stream_id) {
            var stream_container = $('#video-frame-container');
            var body = $("html, body");
            $.get('{{route('home.stream.view')}}'+'?id='+stream_id, {}, function (data) {
                stream_container.html(data.stream);   
                $('#video-frame-container .load-wrapp').hide();
            });
        }

        function getStreamsList(init = false) {
            // var today = new Date();
            // var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            // console.log(time)
            var streamListContainer = $('#ajax_streamlist_area');
            var body = $("html, body");
            $.get('{{route('home.streamlist.get')}}', {}, function (data) {
                streamListContainer.html(data.streams_list);
                if(init) {
                    var init_streamId = $(".widget-stream-lists:first-child a").attr('data-id');   
                    getSelectStream(init_streamId);
                }               
                setTimeout(function(){
                    getStreamsList(false);
                },10000)
                $('#ajax_streamlist_area .load-wrapp').hide();
            });
        }

        function menu_toggle(event, menuObj) {
            event.preventDefault();          
            // stream menu action
            if(menuObj.hasClass('active') != true) {
                $(".stream-list-wrapper").addClass('open')
                $('.list_menu').addClass('active');
                $('.streamlist').css('visibility','visible')
            }else {
                $('.list_menu').removeClass('active');
                $(".stream-list-wrapper").removeClass('open')
                $('.streamlist').css('visibility','hidden')
            }
        }

        function theatre_mode(event, theatreBtn) {
            event.preventDefault();  
            var streamArea = $(".stream-area");
            if(streamArea.hasClass('theatre-on') == true) {
                streamArea.removeClass('theatre-on')
                streamArea.addClass('theatre-off')
                $("body").addClass('theatre');
            }else {
                streamArea.removeClass('theatre-off')
                streamArea.addClass('theatre-on')
                $("body").removeClass('theatre');
            }
        }

        function chatroom_toggle(event, chatBtn) {
            event.preventDefault();          
            // stream menu action
            var streamArea = $(".stream-area");
            if(streamArea.hasClass('chat_open') == true) {
                streamArea.removeClass('chat_open')
                streamArea.addClass('chat_close')
            }else {
                streamArea.removeClass('chat_close')
                streamArea.addClass('chat_open')
            }
        }
    </script>
@endsection