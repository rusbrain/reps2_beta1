@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $countries = $general_helper->getCountries();
    $gallery = $general_helper->getUserGallery($photo->user_id);
@endphp
@section('content')
    <div class="row">
        <div class="col-md-3 left-inner-gallery-sidebar">
            @foreach($gallery as $item)
                <a href="{{route('gallery.view',['id'=> $item->id])}}" class="user-gallery-images"
                   style="font-size: 12px; color: grey">
                    {{$item->file->title}}
                </a>
            @endforeach
        </div>
        <div class="col-md-9 border-gray">
            <div class="row">
                <div class="gallery-links col">
                    @if($photo->photo_prev)
                        <a href="{{route('gallery.view', ['id' => $photo->photo_prev->id])}}"><< назад</a>
                    @endif
                    @if($photo->photo_next)
                        <a href="{{route('gallery.view', ['id' => $photo->photo_next->id])}}"> вперед >></a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="gallery-img-wrapper col">
                    @if($photo->for_adults == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                        <p>
                            <span>{{$photo->file}}</span><br>
                            Фотография с рейтингом 18+
                            Доступно только зарегистрированным пользователям
                        </p>
                    @else
                        <img src="{{$photo->file->link}}" alt="">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="comments-wrapper">
                        <div class="comments-block-title">Комментарии:</div>
                        @if($photo->comments)
                            @php $i = 1; @endphp
                            @foreach($photo->comments as $comment)
                                <div class="comment">
                                    <div class="comment-title">
                                        <span>#{{$i}} </span>
                                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$comment->user->country_id]->code)}}"></span>
                                        <span>{{$comment->user->name}}</span>
                                        <a href="">{{$comment->user->rating}}<span>кг</span></a>
                                    </div>
                                    <div class="comment-title">{{$comment->created_at}}</div>
                                    <div class="comment-content">
                                        {{$comment->content}}
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                            <nav class="comment-navigation">
                                @php  $data = $photo->comments @endphp
                                @include('comment-pagination')
                            </nav>
                        @else
                            <p>комментарии отсутствуют</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="add-comment-form-wrapper col">
                    <div class="comments-block-title">Добавить комментарий</div>
                    @if(Auth::user())
                        @php
                            $route = route('gallery.comment.store');
                            $relation =  \App\Comment::RELATION_USER_GALLERY;
                            $comment_type = 'gallery_id';
                            $object_id = $photo->id;
                        @endphp
                        @include('comment-form')
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
@endsection