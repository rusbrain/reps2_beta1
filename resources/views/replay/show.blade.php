@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('left_inner_replay_sidebar')
        </div>
        <div class="col-md-8 border-gray">
            <div class="row">

                <div class="page-title w-100">{{$replay->title}}</div>
                <div class="col-md-6">
                    <div class="replay-desc-wrapper">
                        <p>Страны:
                            <span class="flag-icon flag-icon-{{mb_strtolower($general_helper->getCountries()[$replay->first_country_id]->code)}}"></span> vs
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
                    <div>{{$replay->map->name}}</div>
                    <div class="map-wrapper">
                        <img src="/{{$replay->map->url}}" alt="">
                    </div>
                    <div class="vote-replay">
                        <a href="{{route('replay.set_rating',['id'=>$replay->id, 'rating'=>1])}}" class="vote-replay-up"><i
                                    class="fas fa-thumbs-up"></i>({{$replay->positive_count}})</a>
                        <a href="{{route('replay.set_rating',['id'=>$replay->id, 'rating'=>-1])}}" class="vote-replay-down"><i
                                    class="fas fa-thumbs-down"></i> ({{$replay->negative_count}})</a>
                    </div>
                </div>
            </div>

            <div class="row evolution-replay">
                <div class="page-title w-100">Оценить реплай</div>
                <form action="{{route('replay.set_evaluation',['id'=>$replay->id])}}" method="post" class="col-md-12">
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
            </div>

            <div class="row comments-wrapper">
{{--                                        {{dd($comments)}}--}}
                <div class="page-title w-100">Коментанрии</div>
                @foreach($comments as $item => $comment)
                    <div class="comment-title col-md-12">
                        <span>#{{$item}}</span>
                        <span class="comment-date">{{$comment->created_at}}</span>
                        <a href="{{route('user_profile',['id' => $comment->user->id])}}"><span
                                    class="comment-user">{{$comment->user->name}}</span></a>
                        <span class="comment-flag">
                        <span class="flag-icon flag-icon-{{mb_strtolower($comment->user->country->code)}}"></span>
                    </span>
                    </div>
                    <div class="col-md-12 comment-content">{{$comment->content}}</div>
                @endforeach
            </div>

            @if(Auth::user())
                <div class="row add-comment">
                    <div class="page-title w-100">Добавить комментарий</div>
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="text">Текст</label>
                            <textarea name="content" class="form-control" id="text" cols="30" rows="10">

                    </textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="">
                            <input type="hidden" name="object_id" value="">
                            <input type="hidden" name="relation" value="">
                            <button class="form-control" type="submit">Добавить</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection