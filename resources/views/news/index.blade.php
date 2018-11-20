@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('inner_forum_sidebar')
        </div>
        <div class="col-md-9 content-center-main-wrapper">
            <div class="content-center-main">
                <div class="page-title">Новости</div>
                @foreach($news as $single_news)
                    <div class="row">
                        <div class="col">
                            <div class="news-wrapper">
                                <div class="news-title">
                                    <a class="w-100" href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                                        <span>#{{$single_news->id}}</span>
                                        <span>{!! $single_news->title !!}</span>
                                    </a>
                                    <div>
                                        <span>{{$single_news->user->name}}</span>
                                        <span class="separator">|</span>
                                        <span>{{$single_news->created_at}}</span>
                                        <span class="separator">|</span>
                                        <span class="bold">Комминтарии:{{$single_news->comments_count}}</span>
                                        <span class="separator">|</span>
                                        <span class="bold">Прочитано:{{$single_news->reviews}}</span>
                                    </div>
                                </div>
                                <div class="news-preview-img">
                                    <a href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                                        <img src="{{$single_news->preview_img->link??''}}" alt="">
                                    </a>
                                </div>
                                <div class="news-content">
                                    {!! $single_news->preview_content !!}
                                </div>
                                <div class="read-more">
                                    <a href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                                        [читать полностью]
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection