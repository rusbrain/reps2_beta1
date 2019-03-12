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
                <div class="user-role">
                    @if($replay->user->user_role_id != 0)
                        {{$replay->user->role->title . ' | '}}
                        {{$general_helper->getUserStatus($replay->user->score)}} {{$replay->user->score . ' pts | '}}
                    @else
                        {{$general_helper->getUserStatus($replay->user->score)}} {{$replay->user->score . ' pts | '}}
                    @endif
                </div>
                <div>
                    <a href="{{route('user.get_rating', ['id' => $replay->user->id])}}"
                       class="user-rating"> {{$replay->user->rating}} кг</a>
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
                        {{($replay->comments_count > 0) ? $replay->comments_count : $comments->total() }}
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
                        <div class="replay-desc-right">Длительность:</div>
                        <div class="replay-desc-left">{{$replay->length??'не указано'}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Чемпионат:</div>
                        <div class="replay-desc-left">{{$replay->championship??'не указано'}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Версия:</div>
                        <div class="replay-desc-left">{{$replay->game_version->version??'не указано'}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Рейтинг при создании:</div>
                        <div class="replay-desc-left">{{$replay->creating_rate??'0'}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Рейтинг:</div>
                        <div class="replay-desc-left">{{$replay->rating??'0'}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Юзер Рейтинг:</div>
                        <div class="replay-desc-left">({{$replay->user_rating??'0'}})</div>
                    </div>
                    @if(Auth::id() == $replay->user->id)
                        <a href="{{route('replay.edit', ['id' => $replay->id])}}" class="user-theme-edit">
                            <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                            <span>Редактировать</span>
                        </a>
                    @endif
                </div>
                <div class="col-md-4 position-relative">
                    <div>{{$replay->map->name??'не указано'}}</div>
                    @if(isset($replay->map->url))
                        <img src="{{route('home')}}/{{$replay->map->url}}" class="replay-map"
                             alt="{{$replay->map->name??'не указано'}}">
                    @else
                        <div class="replay-map-empty">
                            Не указано
                        </div>
                    @endif
                    <div class="replay-rating">
                        @if(Auth::user())
                            <a href="#vote-modal" class="positive-vote vote-replay-up" data-toggle="modal"
                               data-rating="1">
                                <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                                <span id="positive-vote">{{$replay->positive_count}}</span>
                            </a>
                            <a href="#vote-modal" class="negative-vote vote-replay-down" data-toggle="modal"
                               data-rating="-1">
                                <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                                <span id="negative-vote">{{$replay->negative_count}}</span>
                            </a>
                        @else
                            <p>Зарегистрируйтесь что бы проголосовать</p>
                        @endif
                    </div>
                    <div class="replay-download">
                        <img src="{{route('home')}}/images/icons/download-blue.png" alt="">
                        <a href="{{route('replay.download', ['id' => $replay->id])}}" class="">Скачать</a>
                        <span>({{$replay->downloaded??0}})</span>
                    </div>
                </div>
            </div>
        </div><!-- close div /.user-replay-wrapper -->
    </div><!-- close div /.content-box -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Оценить реплай</div>
        </div>
        <div class="col-md-12">
            @if(Auth::user())
                <form action="{{route('replay.set_evaluation',['id'=>$replay->id])}}" method="POST"
                      class="replay-vote-form">
                    @csrf
                    <div class="row">
                        <div class="">
                            <input type="radio" name="rating" id="rate_1" value="1">
                            <label for="rate_1">1</label>
                        </div>
                        <div class="">
                            <input type="radio" name="rating" id="rate_2" value="1">
                            <label for="rate_2">2</label>
                        </div>
                        <div class="">
                            <input type="radio" name="rating" id="rate_3" value="1">
                            <label for="rate_3">3</label>
                        </div>
                        <div class="">
                            <input type="radio" name="rating" id="rate_4" value="1">
                            <label for="rate_4">4</label>
                        </div>
                        <div class="">
                            <input type="radio" name="rating" id="rate_5" value="1">
                            <label for="rate_5">5</label>
                        </div>
                        <button type="submit" class="btn-empty margin-left-40">Оценить</button>
                    </div>
                </form>
            @else
                <div class="text-center padding-top-bottom-10">
                    Данная возможность доступна только зарегистрированным пользователям
                </div>
            @endif

        </div>
    </div>

    <!--Comments-->
    @include('comments.comments',['object' => 'replay', 'id' => $replay->id])
    <!--END Comments-->

    <!--ADD Comment-->
    @include('comments.comment-add', [
        'route' => route('replay.comment.store'),
        'relation' => \App\Comment::RELATION_REPLAY,
        'comment_type' => 'replay_id',
        'object_id' => $replay->id
    ])
    <!--END ADD Comment-->

    <!-- Modal -->
    <div class="modal fade" id="vote-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Оставте комментарий</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vote-form" action="{{route('replay.set_rating',['id'=>$replay->id])}}">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Голос:
                                <div class="positive">
                                    <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                                </div>
                                <div class="negative">
                                    <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                                </div>
                            </label>
                            <input type="hidden" name="rating" id="rating" value="">
                        </div>
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <input type="text" class="form-control" name="comment" id="comment" value="">
                        </div>
                        <button class="btn-blue btn-form" type="submit">Проголосовать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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