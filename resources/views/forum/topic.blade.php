@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('sidebar-left')
    <!-- All Forum Topics -->
{{--    @include('sidebar-widgets.all-forum-sections')--}}
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
                    <a href="{{route('forum.index')}}">/ Форум</a>
                </li>
                <li>
                    <a href="{{route('forum.section.index', ['name' => $topic->section->name])}}">/ {{$topic->section->title}}</a>
                </li>
                <li>
                    <a href="{{route('forum.topic.index',['id'=>$topic->id])}}" class="active">/ {{$topic->title}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>{{$topic->title}}</div>
            <div>
                @if(Auth::user())
                    <a href="">
                        <img src="{{route('home')}}/images/icons/arrow-right-white.png" alt="">
                    </a>
                    <a href="">
                        Добавить новую тему
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-12 section-info">
        <span>Просмотров:
            <span class="qty">{{$topic->reviews}}</span>
        </span>
            <span>Ответов:
                <span class="qty">{{($topic->comments_count > 0) ? $topic->comments_count : $comments->total() }}</span>
            </span>
        </div>
        <div class="article-wrapper">
            <div class="col-md-12 article-title">
                <div>
                    @if($topic->user->avatar)
                        <a href="{{route('user_profile',['id' => $topic->user->id])}}">
                            <img src="{{$topic->user->avatar->link}}" class="user-avatar" alt="">
                        </a>
                    @else
                        <a href="{{route('user_profile',['id' => $topic->user->id])}}"
                           class="logged-user-avatar no-header">A</a>
                    @endif
                    <div class="user-nickname">
                        <a href="{{route('user_profile',['id' => $topic->user->id])}}">{{$topic->user->name}}</a>
                        <a href="" class="user-menu-link"></a>
                        <div class="user-menu">
                            <a href="{{route('user.add_friend',['id'=>$topic->user->id])}}">Добавить в друзья</a>
                            <a href="{{route('user.messages',['id' => $topic->user->id])}}">Сообщение</a>
                            <a href="{{route('user.set_ignore',['id'=>$topic->user->id])}}">Игнор-лист</a>
                        </div>
                    </div>
                    <div class="user-role">
                        @if($topic->user->user_role_id != 0)
                            {{$topic->user->role->title}}
                        @else
                            user
                        @endif
                    </div>
                    <div>
                        <a href="{{route('user.get_rating', ['id' => $topic->user->id])}}"
                           class="user-rating">pst {{$topic->user->rating}}</a>
                    </div>
                </div>
                <div class="article-creating-date">
                    <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                    {{$topic->created_at}}
                </div>
            </div>
            <div class="col-md-12 article-content-wrapper">
                <div class="article-content">
                    {!! $general_helper->oldContentFilter($topic->content) !!}
                </div>
                <div class="article-footer">
                    <div class="quote">
                        <img src="{{route('home')}}/images/icons/frame.png" alt="">
                        Цитировать
                    </div>
                    <div class="article-rating">
                        <a href="" class="positive-vote">
                            <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                            <span>{{$topic->positive_count}}</span>
                        </a>
                        <a href="" class="negative-vote">
                            <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                            <span>{{$topic->negative_count}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- close div /.section-article -->
    </div><!-- close div /.content-box -->

    <!--Comments-->
    @include('comments.comments')
    <!--END Comments-->

    <!--ADD Comment-->
    @include('comments.comment-add', [
        'route' => route('forum.topic.comment.store'),
        'relation' =>  \App\Comment::RELATION_FORUM_TOPIC,
        'comment_type' => 'topic_id',
        'object_id' => $topic->id
    ])
    <!--END ADD Comment-->
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