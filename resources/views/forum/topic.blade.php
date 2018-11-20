@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    {{--{{dd($topic)}}--}}
    <div class="row">
        {{--<div class="col-md-3">--}}
            {{--@include('inner_forum_sidebar')--}}
        {{--</div>--}}
        <div class="col-md-12">
            <div class="topic-wrapper">
                <div class="page-title w-100">{{$topic->title}}</div>
                <div class="topic-info">
                <span>
                    {{$topic->user->name}}
                </span>
                    <span class="separator">|</span>
                    <span>{{$topic->user->rating}}</span>
                    <span class="separator">|</span>
                    <span>{{$topic->created_at}}</span>
                    <span class="separator">|</span>
                    <span>Ответов: {{$topic->comments_count}}</span>
                    <span class="separator">|</span>
                    <span>Прочитано:{{$topic->reviews}}</span>
                </div>
                <div class="topic-content-wrapper">
                    <div class="topic-content">
                        {!! $topic->content !!}
                    </div>
                </div>
            </div>
            <div class="topic-comments-wrapper">
                <div class="page-title w-100">Ответы:</div>
                @if($comments)
                    @foreach($comments as $item => $comment)
                        <div class="comment-title col-md-12">
                            <span>#{{$item}}</span>
                            <span class="comment-date">{{$comment->created_at}}</span>
                            <a href="{{route('user_profile',['id' => $comment->user->id])}}"><span
                                        class="comment-user">{{$comment->user->name}}</span></a>
                            <span class="comment-flag">
                            <span class="flag-icon flag-icon-{{mb_strtolower($comment->user->country->code)}}"></span>
                        </span>
                            <a href="">{{$comment->user->rating}} <span>кг</span></a>
                        </div>
                        <div class="col-md-12 comment-content">{!! $comment->content !!}</div>
                    @endforeach
                @endif
                <div class="row">
                    <div class="add-comment-form-wrapper col">
                        <div class="comments-block-title">Добавить комментарий</div>

                        @if(Auth::user())
                            @php
                                $route = route('forum.topic.comment.store');
                                $relation =  \App\Comment::RELATION_FORUM_TOPIC;
                                $comment_type = 'topic_id';
                                $object_id = $topic->id;
                            @endphp
                            @include('forum.forum-comment-form')
                        @else
                            <p>
                                <span class="flag-icon flag-icon-ru"></span>
                                Вы не зарегистрированы на сайте, поэтому данная
                                функция отсутствует.</p>
                            <p>
                                <span class="flag-icon flag-icon-gb"></span>
                                You are not register on the site and this function is disabled.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection