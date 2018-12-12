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
            @if(Auth::user() && Auth::id() == $photo->user_id)
                <div class="row">
                    <a href="{{route('gallery.list_user',['id'=>Auth::user()->id])}}">« Вернуться к управлению | </a>
                    <a href="{{route('gallery.list_my',['id'=>Auth::user()->id])}}">« Просмотр галереи »</a>
                </div>
                <div class="row">
                    <div class="col">
                        <h3>Форма редактирования фотографии:</h3>
                        <form action="{{route('gallery.update',['id'=>$photo->id])}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group ">
                                        <label class="margin-right-15">Подпись:</label>
                                        <input type="text" class="form-control "
                                               value="{!! old('comment')??$photo->comment !!}"
                                               placeholder="Подпись" name="comment">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <label for="for_adults">
                                            <input type="checkbox" name="for_adults" id="for_adults"
                                                   class="flat-red"
                                                   value="1"
                                                   @if($photo->for_adults == 1) checked @endif
                                            >
                                            <span>18+</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="gallery-links col">
                    @if($photo->photo_before)
                        <a href="{{route('gallery.view', ['id' => $photo->photo_before->id])}}"><< назад</a>
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
                            <span>{{$photo->file->title}}</span><br>
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
                        <div class="comments-block-title ">Комментарии:</div>
                        @if($photo->comments->total() > 0)
                            @php $i = 1; @endphp
                            @foreach($photo->comments as $comment)
                                <div class="comment">
                                    <div class="comment-title">
                                        <span>#{{$i}} </span>
                                        @if($comment->user->country_id)
                                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$comment->user->country_id]->code)}}"></span>
                                        @endif
                                        <span>{{$comment->user->name}}</span>
                                        <a href="">{{$comment->user->rating}}<span>кг</span></a>
                                    </div>
                                    <div class="comment-title">{{$comment->created_at}}</div>
                                    <div class="comment-content">
                                        <div class="text-bold">{!! $general_helper->oldContentFilter($comment->title) !!}</div>
                                        {!!  $general_helper->oldContentFilter($comment->content) !!}
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                            <nav class="comment-navigation">
                                @php  $data = $photo->comments @endphp
                                @include('pagination')
                            </nav>
                        @else
                            <div class="comment-content">комментарии отсутствуют</div>
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
                        <div class="border-gray">
                            @include('comment-form')
                        </div>
                    @else
                        <div class="no-logged-user-message">
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
@endsection