@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $countries = $general_helper->getCountries()
@endphp
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('replay.inner_replay_sidebar')
        </div>
        <div class="col-md-9">
            <div class="row border-gray">
                <div class="page-title w-100">{{$replay->title}}</div>
                <div class="col-md-6">
                    <div class="replay-desc-wrapper">
                        <p>Страны:
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->first_country_id]->code)}}"></span>
                            vs
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->second_country_id]->code)}}"></span>
                        </p>
                        <p>Матчап: <span>{{$replay->first_race}}</span> vs <span>{{$replay->second_race}}</span></p>
                        <p>Локации:
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
                        </p>
                        <p>Длительность: <span>{{$replay->length??'no'}}</span></p>
                        <p>Чемпионат: <span>{{$replay->championship??'no'}}</span></p>
                        <p>Версия <span>{{$replay->game_version->version??'no'}}</span>
                        </p>
                        <p>Рейтинг при создании: <span>{{$replay->creating_rate??'no'}}</span></p>
                        <p>Рейтинг: <span>{{$replay->rating??'no'}}</span></p>
                        <p class="">Юзер Рейтинг: (<span>{{$replay->user_rating??'no'}}</span>)
                        </p>
                        <p>Описание: {{$replay->content}}</p>
                    </div>
                </div>
                <div class="col-md-6 position-relative">
                    <div>{{$replay->map->name}}</div>
                    <div class="map-wrapper">
                        <img src="/{{$replay->map->url}}" alt="">
                    </div>
                    @if(Auth::user())
                        <div class="vote-replay">
                            <a href="#vote-modal"
                               class="vote-replay-up" data-toggle="modal" data-rating="1">
                                <i class="fas fa-thumbs-up"></i>
                                (<span id="positive-vote">{{$replay->positive_count}}</span>)
                            </a>

                            <a href="#vote-modal"
                               class="vote-replay-down" data-toggle="modal" data-rating="-1">
                                <i class="fas fa-thumbs-down"></i>
                                (<span id="negative-vote">{{$replay->negative_count}}</span>)
                            </a>
                        </div>
                    @else
                        <div>
                            Вы не зарегистрированы, по-етому не можете проголосовать
                        </div>
                    @endif
                    <div class="download-btn-wrapper">
                        <a class="download-btn" href="{{route('replay.download', ['id' => $replay->id])}}">
                            <i class="fas fa-download"></i>
                            Скачать ({{$replay->downloaded}})
                        </a>
                    </div>
                    @if(Auth::user() && Auth::id() == $replay->user->id)
                        <div class="edit-btn-wrapper">
                            <a class="edit-btn" href="{{route('replay.edit', ['id' => $replay->id])}}">
                                <i class="fas fa-pen"></i>
                                Редактировать
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row evolution-replay">
                <div class="page-title w-100">Оценить реплай</div>

                @if(Auth::user())
                    <form action="{{route('replay.set_evaluation',['id'=>$replay->id])}}" method="post"
                          class="col-md-12">
                        @csrf
                        <div class="evolution-replay-form-content">
                            <div class="col">
                                <label for="rate_1">1</label>
                                <input type="radio" name="rating" id="rate_1" value="1">
                            </div>
                            <div class="col">
                                <label for="rate_2">2</label>
                                <input type="radio" name="rating" id="rate_2" value="2">
                            </div>
                            <div class="col">
                                <label for="rate_3">3</label>
                                <input type="radio" name="rating" id="rate_3" value="3">
                            </div>
                            <div class="col">
                                <label for="rate_4">4</label>
                                <input type="radio" name="rating" id="rate_4" value="4">
                            </div>
                            <div class="col">
                                <label for="rate_5">5</label>
                                <input type="radio" name="rating" id="rate_5" value="5">
                            </div>
                            <button class="col" type="submit">Оценить</button>
                        </div>
                    </form>
                @else
                    <div class="no-logged-user-message">
                        Данная возможность доступна только зарегистрированным пользователям
                    </div>
                @endif
            </div>
            <div class="row comments-wrapper">
                <div class="page-title w-100">Коментанрии</div>
                @if($comments->total() > 0)
                    @foreach($comments as $item => $comment)
                        <div class="comment-title col-md-12">
                            <span>#{{$item}}</span>
                            <span class="comment-date">{{$comment->created_at}}</span>
                            <a href="{{route('user_profile',['id' => $comment->user->id])}}"><span
                                        class="comment-user">{{$comment->user->name}}</span></a>
                            <span class="comment-flag">
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$comment->user->country_id]->code)}}"></span>
                        </span>
                            <a href="{{route('user.get_rating', ['id' => $comment->user->id])}}">{{$comment->user->rating}}
                                <span>кг</span></a>
                        </div>
                        <div class="col-md-12 comment-content">
                            <div class="text-bold">{!! $general_helper->oldContentFilter($comment->title) !!}</div>
                            {!! $comment->content !!}
                        </div>
                    @endforeach
                    <nav class="comment-navigation">
                        @php  $data = $comments @endphp
                        @include('pagination')
                    </nav>
                @else
                    <p>В данный момент комментарии отсутствуют</p>
                @endif
            </div>
            <div class="row">
                <div class="add-comment-form-wrapper col border-gray">
                    <div class="comments-block-title row">Добавить комментарий</div>
                    @if(Auth::user())
                        @php
                            $route = route('replay.comment.store');
                            $relation =  \App\Comment::RELATION_REPLAY;
                            $comment_type = 'replay_id';
                            $object_id = $replay->id;
                        @endphp
                        @include('comment-form')
                    @else
                        <div class="no-logged-user-message row">
                            <p>
                                <span class="flag-icon flag-icon-ru"></span>
                                Вы не зарегистрированы на сайте, поэтому данная
                                функция отсутствует.</p>
                            <p>
                                <span class="flag-icon flag-icon-gb"></span>
                                You are not register on the site and this function is disabled.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <div class="negative">
                                    <i class="fas fa-thumbs-down"></i>
                                </div>
                            </label>
                            <input type="hidden" name="rating" id="rating" value="">
                        </div>
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <input type="text" class="form-control" name="comment" id="comment" value="">
                        </div>
                        <button class="btn btn-primary pull-right" type="submit">Проголосовать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection