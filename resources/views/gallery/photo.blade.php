@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('sidebar-left')
    <!-- User Gallery widget -->
    @include('sidebar-widgets.user-gallery',['user' => $photo->user,'gallery' => $general_helper->getUserGallery($photo->user->id)])
    <!-- END User Gallery widget -->
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
                    <a href="#"
                       class="active">/ {{$photo->comment != '' ? $general_helper->oldContentFilter($photo->comment) :'Без названия'}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Галерея</div>
        </div>
        <div class="col-md-12">
            <div class="gallery-image-wrapper">
                <div class="gallery-image-info-panel">
                    <div>
                        <div class="font-14">{{$photo->comment}}</div>
                    @if(Auth::id() != $photo->user->id)
                        <!--display if user is not author-->
                            <div>
                                <span>автор:</span>
                                <a href="{{route('user_profile',['id' =>$photo->user->id])}}">{{$photo->user->name}}</a>
                            </div>
                            <!-- -- -->
                        @endif
                    </div>
                    <div class="article-rating">
                        <a href="#vote-modal" class="positive-vote vote-replay-up" data-toggle="modal"
                           data-rating="1" data-route="{{route('gallery.set_rating',['id'=>$photo->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                            <span id="positive-vote">{{$photo->positive_count}}</span>
                        </a>
                        <a href="#vote-modal" class="negative-vote vote-replay-down" data-toggle="modal"
                           data-rating="-1" data-route="{{route('gallery.set_rating',['id'=>$photo->id])}}">
                            <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                            <span id="negative-vote">{{$photo->negative_count}}</span>
                        </a>
                    </div>
                    @if(Auth::id() == $photo->user->id)
                        <div class="reputation-button-wrapper">
                            <a href="{{route('gallery.get_rating', ['id' => $photo->id])}}" class="btn-blue">
                                рейтинг лист
                            </a>
                        </div>
                    @endif
                    <div>
                        @if($photo->photo_before)
                            <a href="{{route('gallery.view', ['id' => $photo->photo_before->id])}}" class="prev-image">&laquo;</a>
                        @endif
                        @if($photo->photo_next)
                            <a href="{{route('gallery.view', ['id' => $photo->photo_next->id])}}" class="next-image">&raquo;</a>
                        @endif
                    </div>
                </div>
                @if($photo->for_adults == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                    <div class="text-center padding-top-bottom-10 text-bold">
                        Фотография с рейтингом 21+. <br>
                        Доступно только зарегистрированным пользователям
                    </div>
                @else
                    <img src="{{$photo->file->link}}" alt="" class="">
                @endif


                @if(Auth::id() == $photo->user->id)
                <!--display if user is not author-->
                    <div>
                        <form action="{{route('gallery.update',['id'=>$photo->id])}}"
                              class="edit-gallery-image-form" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Подпись:</label>
                                <input type="text" id="comment"
                                       class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}"
                                       name="comment" value="{{old('comment')??$photo->comment}}">
                                @if ($errors->has('comment'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="for_adults" class="display-flex align-items-center">
                                    <input type="checkbox" name="for_adults" id="for_adults" class="margin-right-5"
                                           value="1" @if(old('for_adults')??$photo->for_adults) checked @endif>
                                    <span>18+</span>
                                    @if ($errors->has('for_adults'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('for_adults') }}</strong>
                                        </span>
                                    @endif
                                </label>
                            </div>
                            <div class="form-group bnt-form-wrapper">
                                <a href="" class="btn-empty btn-empty-form">Удалить</a>
                                <button type="submit" class="btn-blue btn-form">Обновить</button>
                            </div>
                        </form>
                    </div>
                    <!-- -- -->
                @endif
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <!--Comments-->
    @php $comments = $photo->comments @endphp
    @include('comments.comments',['object' => 'gallery', 'id' => $photo->id])
    <!--END Comments-->

    <!--ADD Comment-->
    @include('comments.comment-add', [
        'route' => route('gallery.comment.store'),
        'relation' => \App\Comment::RELATION_USER_GALLERY,
        'comment_type' => 'gallery_id',
        'object_id' => $photo->id
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

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection