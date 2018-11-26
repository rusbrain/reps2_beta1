@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('inner_forum_sidebar')
        </div>
        <div class="col-md-9 content-center-main-wrapper">
            <div class="content-center-main">
{{--                {{dd($topics)}}--}}

                <div class="page-title w-100">{{($topics->title)?$topics->title:''}}</div>
                @foreach($topics->topics as $topic)
                    <div class="forum-section-row">
                        <a class="w-100" href="{{route('forum.topic.index',['id' => $topic->id])}}">
                            <span>{!! $topic->icon??'<i class="fas fa-file-alt"></i>' !!}</span>
                            <span>{!! $topic->title !!}</span>
                            <span class="separator">|</span>
                            <span>({{$topic->comments_count}}\{{$topic->reviews}})</span>

                            @if(Auth::user() && Auth::id() == $topic->user_id)
                                <a href="{{route('forum.topic.edit',['id'=>$topic->id])}}" class="topic-edit" title="Редактировать">
                                    <i class="fas fa-pen"></i>
                                </a>
                            @endif
                            <span class="section-topic-date">
                                {{\Carbon\Carbon::parse($topic->created_at)->format('d.m.Y')}}
                            </span>
                        </a>
                        <a href="{{route('forum.topic.index',['id' => $topic->id])}}/#comment">
                            <i class="far fa-comment-alt"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{--@php $data = $topics @endphp--}}
    {{--<div class="row margin-top-20">--}}
        {{--@include('pagination')--}}
    {{--</div>--}}
@endsection
