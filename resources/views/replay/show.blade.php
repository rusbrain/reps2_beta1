@extends('layouts.site')
@section('content')
    <div class="">
        <div class="row">
            <div class="page-title w-100">{{$replay->title}}</div>
            {{--                        {{dd($replay)}}--}}
            <div class="col-md-6">
                <div class="replay-desc-wrapper">
                    <p>Страны:
                        <span class="flag-icon flag-icon-{{mb_strtolower($replay->first_country->code)}}"></span> vs
                        <span class="flag-icon flag-icon-{{mb_strtolower($replay->second_country->code)}}"></span>
                    </p>
                    <p>Матчап: <span>{{$replay->first_race}}</span> vs <span>{{$replay->second_race}}</span></p>
                    <p>Локации: <span>{{($replay->first_location)?$replay->first_location : 'no'}}</span> vs
                        <span>{{($replay->second_location)?$replay->second_location : 'no'}}</span></p>
                    <p>Длительность: <span>{{($replay->length)?$replay->length:'no'}}</span></p>
                    <p>Чемпионат: <span>{{($replay->championship)?$replay->championship:'no'}}</span></p>
                    <p>Версия <span>{{($replay->game_version)?$replay->game_version:'no'}}</span></p>
                    <p>Рейтинг: <span>{{($replay->rating)?$replay->rating:'no'}}</span></p>
                    <p class="">Юзер Рейтинг: (<span>{{($replay->user_rating)?$replay->user_rating:'no'}}</span>)</p>
                    <p>Описание: {{$replay->content}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map-wrapper">
                    <img src="/{{$replay->map->url}}" alt="">
                </div>
            </div>
        </div>

        <div class="row vote-replay">
            <div class="page-title w-100">Оценить реплай</div>
            <form action="" method="post">
                <label for=""></label>
                <input type="radio" name="">

                <button type="submit">Оценить</button>
            </form>
        </div>

        <div class="row comments-wrapper">
            {{--            {{dd($comments)}}--}}
            <div class="page-title w-100">Коментанрии</div>
            @foreach($comments as $item => $comment)
                <div class="comment-title col-md-12">
                    <span>#{{$item}}</span>
                    <span class="comment-date">{{$comment->created_at}}</span>
                    <span class="comment-user">{{$comment->user->user_game}}</span>
                    <span class="comment-flag">
                        <span class="flag-icon flag-icon-{{mb_strtolower($comment->user->country->code)}}"></span>
                    </span>
                    <span class="comment-rating">
                        <span class="comment-rating-plus"><i class="fa fa-plus"></i></span>
                        {{$comment->user->rating}}
                        <span class="comment-rating-minus"><i class="fa fa-minus"></i></span>
                    </span>
                </div>
                <div class="col-md-12 comment-content">{{$comment->content}}</div>
            @endforeach
        </div>
    </div>
@endsection