@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!--Votes-->
    @include('sidebar-widgets.votes')
    <!-- END Vote -->

    <!-- Gosu Replay -->
    @include('sidebar-widgets.gosu-replays')
    <!-- END Gosu Replay -->

    <!-- Main Forum Topics -->
    @include('sidebar-widgets.general-forum-sections')
    <!-- END Main Forum Topics -->
@endsection

@section('content')
    <!--Last News-->
    @if($last_news)
        <div class="content-box">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="content-box-title">Последние новости</h1>
                </div>
                <div class="col-md-6 margin-top-20">
                    @php $i=0; @endphp
                    @foreach($last_news as $last_forum)
                        @if($i==0)
                            <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                @if($last_forum->preview_image)
                                    <img src="{{$last_forum->preview_image->link ?? '/images/logo.png'}}"
                                         class="content-box-topic-img"
                                         alt="">
                                @endif
                            </a>
                            <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                                <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                    <h2 class="margin-bottom-10">{!! $last_forum->title??'название форума' !!}</h2>
                                </a>
                                <p class="content-box-topic-extract">
                                    {!! $general_helper->oldContentFilter($last_forum->preview_content ?? mb_substr($last_forum->content,0,200,'UTF-8').' ...')!!}
                                </p>
                                <div class="content-box-topic-view">
                                    <span>{{$last_forum->reviews ?? '0'}} просмотров</span>
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <img src="images/icons/arrow-right.png" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif
                        @php $i++; @endphp
                    @endforeach
                </div>
                <div class="col-md-6 margin-top-20">
                    @php $j=0; @endphp
                    @foreach($last_news as $last_forum)
                        @if($j > 0)
                            <div class="row content-box-topic-row">
                                <div class="col-md-4">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <img src="{{$last_forum->preview_image->link ??'/images/banner.png'}}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-8 padding-left-0">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}"
                                       class="padding-right-15 display-block">
                                        <h2>{!! $last_forum->title ?? 'название форума' !!}</h2>
                                    </a>
                                    <div class="content-box-topic-view">{{$last_forum->reviews ?? '0'}} просмотров</div>
                                </div>
                            </div>
                        @endif
                        @php $j++; @endphp
                    @endforeach
                </div>
            </div>
        </div><!-- close div /.content-box -->
    @endif
    <!--END Last News-->

    <!--Last Forums-->
    @if($general_helper->getLastForumHome())
        @php $f=0; @endphp
        @foreach($general_helper->getLastForumHome() as $last_forum)
            <div class="content-box">
                <div class="row">
                    @if($f == 0)
                        <div class="col-md-12">
                            <h1 class="content-box-title">Последние форумы</h1>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}" class="content-box-forum-img-wrapper">
                            <img src="{{$last_forum->preview_image->link ??'/images/forum-topic-image-1-big.png'}}"
                                 class="content-box-forum-img" alt="">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="content-box-topic-desc padding-top-10 margin-bottom-15">
                            <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                <h2 class="margin-bottom-10">{!! $last_forum->title ?? 'название темы' !!}</h2>
                            </a>
                            <p class="content-box-topic-extract">
                                {!! $general_helper->oldContentFilter($last_forum->preview_content ?? mb_substr($last_forum->content,0,200,'UTF-8').' ...')!!}
                            </p>
                            <div class="content-box-topic-view">
                                <span>{{$last_forum->reviews ?? '0'}} просмотров</span>
                                <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                    <img src="images/icons/arrow-right.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- close div /.content-box -->
            @php $f++; @endphp
        @endforeach
    @endif
    <!--END Last Forums-->

    <!--Popular Forums-->
    @if($popular_forum_topics)
        <div class="content-box">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="content-box-title">Популярные форумы</h1>
                </div>
                <div class="col-md-6 margin-top-20">
                    @php $t=0; @endphp
                    @foreach($popular_forum_topics as $last_forum)
                        @if($t == 0)
                            <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                @if($last_forum->preview_image)
                                    <img src="{{$last_forum->preview_image->link ?? '/forum-topic-image-1-big.png'}}"
                                         class="content-box-topic-img"
                                         alt="">
                                @endif
                            </a>
                            <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                                <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                    <h2 class="margin-bottom-10">{!! $last_forum->title ?? 'Название темы' !!}</h2>
                                </a>
                                <p class="content-box-topic-extract">
                                    {!! $general_helper->oldContentFilter($last_forum->preview_content ?? mb_substr($last_forum->content,0,200,'UTF-8').' ...')!!}
                                </p>
                                <div class="content-box-topic-view">
                                    <span>{{$last_forum->reviews ?? '0'}} просмотров</span>
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <img src="images/icons/arrow-right.png" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif
                        @php $t++; @endphp
                    @endforeach
                </div>
                <div class="col-md-6 margin-top-20">
                    @php $ft=0; @endphp
                    @foreach($popular_forum_topics as $last_forum)
                        @if($ft > 0)
                            <div class="row content-box-topic-row">
                                <div class="col-md-4">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}" class="в">
                                        <img src="{{$last_forum->preview_image->link ??'/images/forum-topic-image-1-big.png'}}" alt="">
                                    </a>
                                </div>
                                <div class="col-md-8 padding-left-0">
                                    <a class="padding-right-15 display-block" href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <h2>{!! $last_forum->title ?? 'Название темы' !!}</h2>
                                    </a>
                                    <div class="content-box-topic-view">{{$last_forum->reviews ?? '0'}} просмотров</div>
                                </div>
                            </div>
                        @endif
                        @php $ft++; @endphp
                    @endforeach
                </div>
            </div>
        </div><!-- close div /.content-box -->
    @endif
    <!--END Popular Forums-->

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