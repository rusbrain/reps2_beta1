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
                    <a href="#" class="active">/ Новости</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    @if($news)
        @php $n = 0; @endphp
        @foreach($news as $single_news)
            <div class="content-box">
                @if($n == 0)
                    <div class="col-md-12 section-title">
                        <h1>Новости</h1>
                    </div>
                @endif
                <div class="col-md-12 news-wrapper">
                    @if($single_news->preview_image)
                        <img src="{{$single_news->preview_image->link ?? route('home').'/images/logo.png'}}"
                             class="" alt="">
                    @endif
                    <a href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                        <h2>{!! $single_news->title !!}</h2>
                    </a>
                    <div class="news-info">
                        @if($single_news->user->avatar)
                            <a href="{{route('user_profile',['id' => $single_news->user->id])}}">
                                <img src="{{$single_news->user->avatar->link}}" class="margin-right-10" alt="">
                            </a>
                        @else
                            <a href="{{route('user_profile',['id' => $single_news->user->id])}}"
                               class="logged-user-avatar">A</a>
                        @endif
                        <a href="{{route('user_profile',['id' => $single_news->user->id])}}"
                           class="margin-right-30">{{$single_news->user->name}}</a>
                        <img src="{{route('home')}}/images/icons/clock.png" class="margin-right-5" alt="created at">
                        <span>20:12  Дек 21, 2018</span>
                    </div>
                    <div class="news-content">
                        {!! $general_helper->closeAllTags($general_helper->oldContentFilter($single_news->preview_content ?? mb_substr($single_news->content,0,150,'UTF-8').' ...'))!!}
                        <a href="{{route('forum.topic.index',['id' => $single_news->id])}}" class="read-more-link">
                            <img src="{{route('home')}}/images/icons/arrow-right.png" alt="">
                        </a>
                    </div>
                    <div class="news-footer">
                        <div>
                            <img src="{{route('home')}}/images/icons/eye.png" class="margin-right-5" alt="">
                            <span class="margin-right-5">{{$single_news->reviews ?? '0'}}</span>
                            <span class="margin-right-30">просмотров</span>

                            <img src="{{route('home')}}/images/icons/message-square-empty.png" class="margin-right-5" alt="">
                            <span>{{$single_news->comments_count}}</span>
                        </div>
                        <div>
                            #{{$single_news->id}}
                        </div>
                    </div>
                </div><!-- close div /.news-wrapper -->
            </div><!-- close div /.content-box -->
            @php $n++; @endphp
        @endforeach

        <!-- PAGINATION -->
        @php  $data = $news @endphp
        @include('pagination')
        <!-- END PAGINATION -->

    @else
        <h1> В данный момент новостей нет</h1>
    @endif


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

