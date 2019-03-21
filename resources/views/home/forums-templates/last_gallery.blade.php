@inject('general_helper', 'App\Services\GeneralViewHelper')
<div class="row">
    <div class="col-12 home-last-forum-type margin-bottom-10">Галереи</div>
    <div class="gallery-image-info-panel col-md-12">
        <div>
            <div class="font-14">
                <a href="{{route('gallery.view', ['id' => $photo->id])}}">{{$photo->comment}}</a>
            </div>
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
    </div>
    @if($photo->for_adults == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
        <div class="text-center padding-top-bottom-10 text-bold col-md-12">
            Фотография с рейтингом 21+. <br>
            Доступно только зарегистрированным пользователям
        </div>
    @else
        <div class="col-md-12">
            @if($photo->for_adults == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !$general_helper->isAdult(Auth::user()))
                <div class="position-relative">
                    <img src="{{$photo->file->link}}" alt="" class="">
                    <div class="full-opacity-hover">[21+]</div>
                </div>
            @else
                <a href="{{route('gallery.view', ['id' => $photo->id])}}">
                    <img src="{{$photo->file->link}}" alt="" class="">
                </a>
            @endif
        </div>
    @endif
</div>