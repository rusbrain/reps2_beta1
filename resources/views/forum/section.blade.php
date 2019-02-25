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
                    <a href="" class="active">/ {{$data->title}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>{{$data->title}}</div>
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
        <div id="ajax_section_topics" data-comments="{{$total_comment_count}}">
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
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
            var comments_qty =$('#ajax_section_topics').attr('data-comments');
            $.get('{{route('forum.section.pagination',['name' => $data->name])}}'+'?page='+page, {}, function (data) {
                $('#ajax_section_topics').html(data.topics);
                $('.qty').html(comments_qty);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection