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
                    <a href="/">Главная</a>
                </li>
                <li>
                    @if($user->id == Auth::id()){
                    <a href="{{route('user_profile',['id' =>$user->id])}}">/ Мой Аккаунт</a>
                    @else
                        <a href="{{route('user_profile',['id' =>$user->id])}}">/ Профиль: {{$user->name}}</a>
                    @endif
                </li>
                <li>
                    @if($user->id == Auth::id()){
                    <a href="#" class="active">/ Мои посты</a>
                    @else
                        <a href="#" class="active">/ Посты пользователя: {{$user->name}} </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Мои посты</div>
        </div>
        <div id="ajax_section_user_comments"
                data-path="{{($user->id == Auth::id()) ? route('user.comments.pagination'):route('user.user_comments.pagination',['id' => $user->id])}}">
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <!--  PAGINATION -->
    <div class="pagination-content"></div>
    <!-- END  PAGINATION -->

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
            var container = $('#ajax_section_user_comments');
            var body = $("html, body");
            var path = container.attr('data-path');

            $.get(path + '?page=' + page, {}, function (data) {
                container.html(data.comments);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection