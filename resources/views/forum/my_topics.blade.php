@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-12 content-center-main-wrapper">
            <a href="{{route('forum.topic.create')}}" class="btn btn-primary create-top-btn">Добавить пост</a>
            <div class="content-center-main">
                <div class="page-title w-100">Мои посты</div>
                {{--{{dd($topics)}}--}}
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
