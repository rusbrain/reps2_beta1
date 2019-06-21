@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.all-forum-sections')
    <!-- END All Forum Topics -->
@endsection

@section('content')

    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">
                        Главная
                    </a>
                </li>
                <li>
                    <a href="{{route('forum.index')}}">/ Форум</a>
                </li>
                <li>
                    <a href="" class="active">/ Результаты поиска</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Вы искали: {{$search_text}}</div>
            <div>
                @if(Auth::user())
                    <img src="{{route('home')}}/images/icons/arrow-right-white.png" alt="">
                    <a href="{{route('forum.topic.create')}}">
                        Добавить новую тему
                    </a>
                @endif
            </div>
        </div>

        <!--  CONTENT -->
        <div id="ajax_section_topics" >
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
        </div>
        <!-- END CONTENT -->

        <!--  PAGINATION -->
        <div class="pagination-content"></div>
        <!-- END  PAGINATION -->
    </div><!-- close div /.content-box -->
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

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
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection

@section('js')
    <script>
        $(function () {
            getSections(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                $('.load-wrapp').show();
                var page = $(this).attr('data-page');
                getSections(page);
            })
        });
        function getSections(page) {
            var container = $('#ajax_section_topics');
            var body = $("html, body");

            $.get('{{route('forum.topic.search.pagination')}}'+'?page='+page+'&text='+'{{$search_text}}', {}, function (data) {
                container.html(data.topics);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection