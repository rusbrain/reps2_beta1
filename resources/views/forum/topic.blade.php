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
                    <a href="{{route('forum.index')}}">/ Форум</a>
                </li>
                <li>
                    <a href="{{route('forum.section.index', ['name' => $topic->section->name])}}">/ {{$topic->section->title}}</a>
                </li>
                <li>
                    <a href="{{route('forum.topic.index',['id'=>$topic->id])}}"
                       class="active">/ {!! $topic->title !!}</a>
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
                    <img src="{{route('home')}}/images/icons/arrow-right-white.png" alt="">
                    <a href="{{route('forum.topic.create')}}">
                        Добавить новую тему
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-12 section-info">
            <div>
                <span>Просмотров:
                    <span class="qty">{{$topic->reviews}}</span>
                </span>
                <span>Ответов:
                    <span class="qty">{{($topic->comments_count > 0) ? $topic->comments_count : $comments->total() }}</span>
                </span>
            </div>
            <div class="text-right">
                @if(Auth::id() == $topic->user->id && $general_helper->checkForumEdit($topic))
                    <a href="{{route('forum.topic.edit',['id'=>$topic->id])}}" class="user-theme-edit">
                        <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                        <span>Редактировать</span>
                    </a>
                @elseif($general_helper->isAdmin() || $general_helper->isModerator())
                    <a href="{{route('forum.topic.edit',['id'=>$topic->id])}}" class="user-theme-edit">
                        <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                        <span>Редактировать</span>
                    </a>
                @endif
                <div class="edit-info">
                    @if(!is_null($topic->updated_by_user) && $topic->updated_by_user != '')
                        {{$topic->updated_by_user}} отредактировал сообщение {{$topic->updated_at->format('d-m-Y')}}
                    @endif
                </div>
            </div>
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
                        <a href="" class="user-menu-link @if(!Auth::user()) display-none @endif "></a>
                        <div class="user-menu">
                            <a href="{{route('user.add_friend',['id'=>$topic->user->id])}}">Добавить в друзья</a>
                            <a href="{{route('user.messages',['id' => $topic->user->id])}}">Сообщение</a>
                            <a href="{{route('user.set_ignore',['id'=>$topic->user->id])}}">Игнор-лист</a>
                        </div>
                    </div>
                    <div class="">
                        @php
                            $countries = $general_helper->getCountries();
                        @endphp

                        @if($topic->user->country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$topic->user->country_id]->code)}}"></span>
                        @else
                            <span class="flag-icon"></span>
                        @endif

                        @if($topic->user->race)
                            <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$topic->user->race]}}" alt="">
                        @else
                            <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                        @endif
                        
                    </div>
                    
                    <div>
                        {{$topic->user->points . ' pts | '}}                  
                        <a href="{{route('user.get_rating', ['id' => $topic->user->id])}}"
                           class="user-rating">{{$topic->user->rating}} кг</a>
                    </div>
                </div>
                <div class="article-creating-date">
                    <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                    {{\Carbon\Carbon::parse($topic->created_at)->format('H:i d.m.Y')}}
                </div>
            </div>
            <div class="col-md-12 article-content-wrapper">
                <div class="article-content">
                    {!! $general_helper->oldContentFilter($topic->content) !!}
                </div>
                <div class="article-footer">
                    <div class="quote">
                        <img src="{{route('home')}}/images/icons/frame.png" alt=""
                             data-user="{{$topic->user->name}}">
                        Цитировать
                    </div>
                    @if(!\App\Replay::isApproved($topic->approved))
                        <div class="error margin-left-40 text-bold margin-top-10">
                            Не подтвержден
                        </div>
                    @endif
                    <div class="article-rating">
                        @php 
                        $modal = (!Auth::guest() &&  $topic->user->id == Auth::user()->id) ?'#no-rating':'#vote-modal';
                        @endphp 
                        <a href="{{$modal}}" class="positive-vote vote-replay-up" data-toggle="modal"
                           data-rating="1" data-route="{{route('forum.topic.set_rating',['id'=>$topic->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                            <span id="positive-vote">{{$topic->positive_count}}</span>
                        </a>
                        <a href="{{$modal}}" class="negative-vote vote-replay-down" data-toggle="modal"
                           data-rating="-1" data-route="{{route('forum.topic.set_rating',['id'=>$topic->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                            <span id="negative-vote">{{$topic->negative_count}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- close div /.section-article -->
    </div><!-- close div /.content-box -->

    <!--Comments-->
    @include('comments.comments', ['object' => 'topic', 'id' => $topic->id, 'comments_pagination_route' => 'forum.topic.comment.pagination'])
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
