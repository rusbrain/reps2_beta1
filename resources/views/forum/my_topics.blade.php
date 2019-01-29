@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.all-forum-sections')
    <!-- END All Forum Topics -->
@endsection
{{dd($topics)}}
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
                    <a href="#" class="active">/ Мои темы</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div>
        <a href="" class="btn-blue create-theme-btn">Создать тему</a>
    </div>

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Мои темы</div>
        </div>

        {{--@if($topics->total() > 0)--}}

            {{--@foreach()--}}
            {{--@endforeach--}}
        {{--@else--}}

        {{--@endif--}}

        <div class="accordion user-posts" id="user-posts">

            <div class="card">
                <div class="card-header" id="heading_post_id_1">
                    <a class="user-section-title" data-toggle="collapse"
                       data-target="#post_id_1" aria-expanded="true" aria-controls="post_id_1">
                        Общий
                        <span class="icon_collapse open"></span>
                    </a>
                </div>
                <div id="post_id_1" class="collapse show user-section-post-wrapper"
                     aria-labelledby="heading_post_id_1"
                     data-parent="#user-posts">
                    <div class="card-body">
                        <div class="user-post-info">
                            <div>
                                <a href="" class="margin-right-10">Общий </a>
                                <span>|</span>
                                <a href="" class="margin-left-10">Лан в Москве 13.05.18</a>
                            </div>
                            <div>
                                <img src="images/icons/eye.png" alt="">
                                <span>20:12  Дек 21, 2018</span>
                                <a href="" class="link-to-post margin-left-15">#342</a>
                            </div>
                        </div>
                        <div class="user-post-content">
                            молодцы )))) и Аркчек с оформлением и Терранмен за статью )))
                            спасибо парни --
                            <div class="user-post-content-footer">
                                <div>
                                    <img src="images/icons/eye.png" class="margin-right-5" alt="">
                                    <span class="margin-right-20">11264</span>
                                    <img src="images/icons/message-square-empty.png" class="margin-right-5" alt="">
                                    <span>32</span>
                                </div>
                                <div>
                                    <a href="">
                                        <img src="images/icons/message-square-blue.png" alt="" class="margin-right-15">
                                    </a>
                                    <a href="" class="user-theme-edit">
                                        <img src="images/icons/svg/edit_icon.svg" alt="">
                                        <span>Редактировать</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!--close div /.card-body-->
                </div>
            </div>
        </div>
    </div><!-- close div /.content-box -->


    <div class="row">
        <div class="col-md-12 content-center-main-wrapper">
            <a href="{{route('forum.topic.create')}}" class="btn btn-primary create-top-btn">Добавить пост</a>
            <div class="content-center-main">
                <div class="page-title w-100">Мои посты</div>

                @if($topics->total() > 0)
                    @foreach($topics as $topic)
                        <div class="forum-section-row">
                            <a class="w-100" href="{{route('forum.topic.index',['id' => $topic->id])}}">
                                <span>{!! $topic->icon??'<i class="fas fa-file-alt"></i>' !!}</span>
                                <span>{!! $topic->title !!}</span>
                                <span class="separator">|</span>
                                <span>({{count($topic->comments)}}\{{$topic->reviews}})</span>
                                <span class="section-topic-date">{{\Carbon\Carbon::parse($topic->created_at)->format('d.m.Y')}}</span>
                            </a>
                            @if(Auth::user() && Auth::id() == $topic->user_id)
                                <a href="{{route('forum.topic.edit',['id'=>$topic->id])}}" title="Редактировать">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @endif
                            <a href="{{route('forum.topic.index',['id' => $topic->id])}}/#comment">
                                <i class="far fa-comment-alt"></i>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="no-logged-user-message">
                        У Вас нет постов
                    </div>
                @endif
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