@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('inner_forum_sidebar')
        </div>
        <div class="col-md-9 content-center-main-wrapper">
            <div class="content-center-main">
                <div class="page-title w-100">{{$topics->title}}</div>
                @foreach($topics->topics as $topic)
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
                                <i class="far fa-pen"></i> Редактировать
                            </a>
                        @endif
                        <a href="{{route('forum.topic.index',['id' => $topic->id])}}/#comment">
                            <i class="far fa-comment-alt"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
