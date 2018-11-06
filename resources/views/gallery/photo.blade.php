@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries(); @endphp
@section('content')
    {{--    {{dd($photo)}}--}}
    {{--    {{dd($gallery)}}--}}
    {{--    {{dd($photo)}}--}}
    <div class="row">
        <div class="col-md-4">
            @foreach($gallery as $item)
                <a href="{{route('gallery.view',['id'=> $item->id])}}" class="user-gallery-images"
                   style="font-size: 12px; color: grey">
                    {{$item->file->title}}
                </a>
            @endforeach
        </div>
        <div class="col-md-8 border-gray">
            <div class="row">
                <div class="gallery-links col">
                    @if($prev)
                        <a href="{{route('gallery.view', ['id' => $prev->id])}}"><< назад</a>
                    @endif
                    @if($next)
                        <a href="{{route('gallery.view', ['id' => $next->id])}}"> вперед >></a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="gallery-img-wrapper col">
                    @if($photo->for_adults == 1)
                        @if(!Auth::user())
                            <p>
                                <span>{{$photo->file}}</span><br>
                                Фотография с рейтингом 18+
                                Доступно только зарегистрированным пользователям
                            </p>
                        @else
                            <img src="{{$photo->file->link}}" alt="">
                        @endif
                    @else
                        <img src="{{$photo->file->link}}" alt="">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col comments-wrapper">
                    <div class="comments-block-title">Комментарии:</div>
                    @if($photo->comments)
                        @php $i = 1; @endphp
                        @foreach($photo->comments as $comment)
                            <div class="comment">
                                <div class="comment-title">
                                    <span>#{{$i}}</span> -
                                    <span class="flag-icon flag-icon-{{$comment->user_id}}"></span>
                                    <span>user_name</span>
                                    <span>user kg</span>
                                    <br>
                                    <span>{{$comment->create_at}}</span>
                                </div>
                                <div class="comment-content">
                                    {{$comment->content}}
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                        {{dd($photo->comments)}}
                    @else
                        <p>комментарии отсутствуют</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col add-comment-form-wrapper">
                    <div class="comments-block-title">Добавить комментарий</div>
                    @if(Auth::user())
                        <div class="comment-form">
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Заголовок</label>
                                    <input class="form-control" type="text" id="title" value="" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="content">Комментарий</label>
                                    <textarea class="form-control" name="content" id="content" cols="30"
                                              rows="10"></textarea>
                                    <input type="hidden" name="relation"
                                           value="{{\App\Comment::RELATION_USER_GALLERY}}">
                                    <input type="hidden" name="gallery_id" value="{{$photo->id}}">
                                </div>
                                <button class="btn btn-primary" type="submit">Отправить</button>
                            </form>
                        </div>
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