@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.search-replay-form')
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
                    @if($replay->user_replay == 1)
                        <a href="{{route('replay.users')}}">/ Реплеи пользователей</a>
                    @else
                        <a href="{{route('replay.gosus')}}">/ Госу реплеи</a>
                    @endif
                </li>
                <li>
                    <a href="" class="active">/ {{$replay->title}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title ">
           
            <div>{{$replay->title}}</div>

            <div class="author-info">
                <a href="{{route('user_profile',['id' => $replay->user->id])}}">
                    {{$replay->user->name. ' | '}}
                </a>
                <div class="">                   
                    @if($replay->user->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->user->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif

                    @if($replay->user->race)
                        <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$replay->user->race]}}" alt="">
                    @else
                        <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                    @endif
                    
                </div>
                
                <div>
                    {{$replay->user->points . ' pts | '}}            
                    <a href="{{route('user.get_rating', ['id' => $replay->user->id])}}"
                       class="user-rating">{{$replay->user->rating}} кг</a>
                </div>
            </div>
        </div>
        <div class="user-replay-wrapper">
            <div class="col-md-12 user-replay-header">
                <div class="user-nickname text-bold replay-header-content">
                    <a href="">{!! $replay->content !!}</a>
                </div>
                <div class="info">
                    <a href="#comments">
                        <img src="{{route('home')}}/images/icons/message-square-white.png" alt="">
                        {{($replay->comments_count > 0) ? $replay->comments_count : 0 }}
                    </a>
                    <a href="#">
                        <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                        {{\Carbon\Carbon::parse($replay->created_at)->format('H:i d.m.Y')}}
                    </a>
                </div>
            </div>
            <div class="replay-content">
                <div class="col-md-8">
                    <div>
                        <div class="replay-desc-right">Страны:</div>
                        <div class="replay-desc-left">
                            @if($replay->first_country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->first_country_id]->code)}}"></span>
                            @else
                                <span>NO</span>
                            @endif
                            VS
                            @if($replay->second_country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->second_country_id]->code)}}"></span>
                            @else
                                <span>NO</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Матчап:</div>
                        <div class="replay-desc-left">{{$replay->first_race}} vs {{$replay->second_race}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Локации:</div>
                        <div class="replay-desc-left">
                            <span>
                                @if($replay->first_location && $replay->first_location != 0)
                                    {{$replay->first_location}}
                                @else
                                    no
                                @endif
                            </span>
                            vs
                            <span>
                                @if($replay->second_location && $replay->second_location != 0)
                                    {{$replay->second_location}}
                                @else
                                    no
                                @endif
                            </span>
                        </div>
                    </div>
                   
                    <div>
                        <div class="replay-desc-right">Рейтинг:</div>
                        <div class="replay-desc-left">{{$replay->rating??'0'}}</div>
                    </div>
                  
                    <div class="replay-action-wrapper">
                        @if(Auth::id() == $replay->user->id || $general_helper->isAdmin() || $general_helper->isModerator())
                            <a href="{{route('replay.edit', ['id' => $replay->id])}}" class="user-theme-edit">
                                <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                                <span>Редактировать</span>
                            </a>
                        @endif
                        @if(!\App\Replay::isApproved($replay->approved))
                            <div class="error margin-left-40 text-bold margin-top-10">
                                Не подтвержден
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 position-relative">
                    <div class="border-0">{{$replay->map->name??'не указано'}}</div>
                    @if(isset($replay->map->url))
                        <div class="replay-map-wrapper">
                            <img src="{{route('home')}}/{{$replay->map->url}}" class="replay-map"
                                 alt="{{$replay->map->name??'не указано'}}">
                        </div>
                    @else
                        <div class="replay-map-empty">
                            Не указано
                        </div>
                    @endif
                    <div class="replay-rating">    
                        @php 
                        $modal = (!Auth::guest() && $replay->user->id == Auth::user()->id) ?'#no-rating':'#vote-modal';
                        @endphp                   
                        <a href="{{ $modal }}" class="positive-vote vote-replay-up" data-toggle="modal"
                           data-rating="1" data-route="{{route('replay.set_rating',['id'=>$replay->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                            <span id="positive-vote">{{$replay->positive_count}}</span>
                        </a>
                        <a href="{{ $modal }}" class="negative-vote vote-replay-down" data-toggle="modal"
                           data-rating="-1" data-route="{{route('replay.set_rating',['id'=>$replay->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                            <span id="negative-vote">{{$replay->negative_count}}</span>
                        </a>
                    </div>
                    <div class="replay-download">
                        @if(!is_null($replay->file_id))
                            <img src="{{route('home')}}/images/icons/download-blue.png" alt="">
                            <a href="{{route('replay.download', ['id' => $replay->id])}}" class="">Скачать</a>
                            <span>({{$replay->downloaded??0}})</span>
                        @else
                            <span>VOD</span>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- close div /.user-replay-wrapper -->
    </div><!-- close div /.content-box -->
    @if($replay->video_iframe)
    <div class="content-box">
        <div class="col-md-12 video-link-wrapper">
          {!! $replay->video_iframe !!}
        </div>
    </div>
    @endif

    <!--Comments-->
    @include('comments.comments',['object' => 'replay', 'id' => $replay->id, 'comments_pagination_route' => 'replay.comment.pagination'])
    <!--END Comments-->

    <!--ADD Comment-->
    @include('comments.comment-add', [
        'route' => route('replay.comment.store'),
        'relation' => \App\Comment::RELATION_REPLAY,
        'comment_type' => 'replay_id',
        'object_id' => $replay->id
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
