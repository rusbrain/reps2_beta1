@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries(); @endphp
@section('content')
    @php
        $replays = $general_helper->getLastGosuReplay();
        $last_forums = $general_helper->getLastForumHome();
        $types = $general_helper->getReplayTypes();
    @endphp
    <div class="">
        <div class="page-title row">Home page</div>
        <div class="row">
            <div class="col w-100">
                @if($popular_forum_topics)
                    @php $i=0; @endphp
                    @foreach($popular_forum_topics as $last_forum)
                        @if($i == 0)
                            <div class="row top-forum-wrapper">
                                <div class="col-5">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <img src="{{$last_forum->preview_image->link??'/images/header.gif'}}" alt="">
                                    </a>
                                </div>
                                <div class="col-7">
                                    <div class="top-forum-title">
                                        <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                            {{$last_forum->title}}
                                        </a>
                                    </div>
                                    <div class="top-forum-extract">
                                        {!! $last_forum->preview_content??substr($last_forum->content,0,45) !!}
                                    </div>
                                    <a class="view-results read-more"
                                       href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">[читать]</a>
                                </div>
                            </div>
                        @else
                            @if($i == 1)
                                <div class="row top-forum-small-wrapper">
                            @endif
                                    <div class="col-3">
                                        <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}"
                                           class="top-forum-small" data-id="{{$last_forum->id}}">
                                            <img src="{{$last_forum->preview_image->link??'/images/header.gif'}}"
                                                 alt="">
                                            <div class="top-forum-title-small">{{$last_forum->title}}</div>
                                        </a>
                                    </div>
                            @if($i == 4)
                                </div>
                            @endif
                        @endif
                        @php $i++; @endphp
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="home-widget">
                    <div class="page-title w-100">Gosu реплеи</div>
                    @if($replays)
                        @foreach($replays as $replay)
                            <div class=" home-widget-inner-row gosu-replays">
                                <div class="">
                                    <a href="{{route('replay.get', ['id' => $replay->id])}}">
                                        <img src="{{$replay->map->url??'/images/header.gif'}}" alt="">
                                    </a>
                                </div>
                                <div class="">
                                    <div>
                                        <a href="{{route('replay.get', ['id' => $replay->id])}}">Название: {{$replay->title}}</a>
                                    </div>
                                    <div>Страны:
                                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->first_country_id]->code)??'no'}}"></span>
                                        vs
                                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->second_country_id]->code)??'no'}}"></span>
                                    </div>
                                    <div>Матчап: {{$replay->first_race??'No'}} vs {{$replay->second_race??'No'}}</div>
                                    <div>Тип: {{$types[$replay->type_id]->title}}</div>
                                    <div>{!! $replay->content !!}</div>
                                </div>
                            </div>
                        @endforeach
                        <a class="view-results read-more" href="{{route('replay.gosus')}}">[Ещё]</a>
                    @else
                        <p class="">На данный момент нет Госу реплеев</p>
                    @endif
                </div>
            </div>

            <div class="col-md-7">
                <div class="">
                    <div class="page-title w-100">Последние форумы</div>
                    @if($last_forums)
                        @foreach($last_forums as $last_forum)
                            <div class="forum-wrapper">
                                <div class="forum-title">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        {{$last_forum->title??'название форму'}}</a>
                                </div>
                                <div class="forum-image">
                                    <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">
                                        <img src="{{$last_forum->preview_image->link??'/images/header.gif'}}" alt="">
                                    </a>
                                </div>
                                <div class="forum-extract">
                                    {!! $last_forum->preview_content??substr($last_forum->content,0,45) !!}
                                </div>
                                <a class="pull-right" href="{{route('forum.topic.index',['id'=>$last_forum->id])}}">[читать полностью]</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection