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
                    <a href="" class="active">/ Колонки</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Колонки</div>
            <div>
                @if(Auth::user())
                    <img src="{{route('home')}}/images/icons/arrow-right-white.png" alt="">
                    <a href="{{route('forum.topic.create')}}">
                        Добавить новую тему
                    </a>
                @endif
            </div>
        </div>
        @if($topics)
            <div class="col-md-12 section-info">
                <span>Темы:
                    <span class="qty">{{$topics->total()}}</span>
                </span>
                    <span>Ответов:
                    <span class="qty">{{$total_comment_count}}</span>
                </span>
            </div>
            @foreach($topics as $topic)
                <div class="section-article">
                    <div class="col-md-6">
                        <a href="{{route('forum.topic.index',['id' => $topic->id])}}" class="section-article-title">
                            {!! $topic->title !!}
                        </a>
                        <div class="section-article-info">
                            <a href="" class="section-article-view">
                                <img src="{{route('home')}}/images/icons/eye.png" alt="">
                                <span>{{$topic->reviews}}</span>
                            </a>
                            <a href="" class="section-article-comments">
                                <img src="{{route('home')}}/images/icons/message-square-empty.png" alt="">
                                <span>{{$topic->comments_count}}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('user_profile',['id' =>$topic->user->id])}}" class="section-article-author">
                            @if($topic->user->avatar)
                                <img src="{{$topic->user->avatar->link}}" class="user-avatar" alt="">
                            @else
                                <span class="logged-user-avatar">A</span>
                            @endif
                            <span class="name">{{$topic->user->name}}</span>
                        </a>
                    </div>
                    <div class="col-md-4 section-article-date">
                        <img src="{{route('home')}}/images/icons/clock.png" alt="">
                        <span>{{\Carbon\Carbon::parse($topic->created_at)->format('H:i d.m.Y')}}</span>
                        <a href="{{route('forum.topic.index',['id' => $topic->id])}}#comments">
                            <img src="{{route('home')}}/images/icons/message-square-blue.png" class="margin-left-15" alt="">
                        </a>
                    </div>
                </div><!-- close div /.section-article -->
            @endforeach

            <!--  PAGINATION -->
            @php  $data = $topics @endphp
            @include('pagination')
            <!-- END  PAGINATION -->
        @else
            <div class="col-md-12 section-info">
                <h2>В данный момент в этом разделе нет активных тем</h2>
            </div>
        @endif
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