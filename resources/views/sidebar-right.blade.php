@php
    $banner = $general_helper->getRandomBanner();
    $rand_images = $general_helper->getRandomImg();
    $new_users = $general_helper->getNewUsers();
    $countries = $general_helper->getCountries();
    $last_user_replays = $general_helper->getLastUserReplay();
@endphp
<div class="sidebar-wrapper">
    <!--Banners-->
    @if($banner)
        <div class="widget-wrapper padding-top-40">
            <div class="widget-banner">
                <img src="{{$banner->file->link}}" alt="banner">
            </div>
        </div>
    @endif
    <!-- END Banners -->

    <!-- New Users-->
    @if(!empty($new_users))
        <div class="widget-wrapper">
            <div class="widget-header">Новые пользователи</div>
            @foreach($new_users as $new_user)
                <div class="widget-new-user">
                    <a href="{{route('user_profile',['id'=>$new_user->id])}}">
                        <span class="color-blue">#{{$new_user->id}}</span>
                        @if($new_user->country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$new_user->country_id]->code)}}"></span>
                        @else
                            <span></span>
                        @endif
                        <span>{{$new_user->name}}</span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    <!-- END New Users-->

    <!-- User's Replays-->
    <?php if ($last_user_replays) : ?>
    <div class="widget-wrapper">
        <div class="widget-header">
            Пользовательские реплеи
        </div>
        <div class="widget-forum-topics-wrapper">
            @foreach($last_user_replays as $last_user_replay)
                <div class="widget-forum-topic">
                    <span>{{$last_user_replay->title}}</span>
                    <span class="widget-forum-topic-comments">{{$last_user_replay->comments_count}}</span>
                </div>
            @endforeach
            <div class="justify-content-center display-flex">
                <a href="{{route('replay.users')}}" class="btn-empty margin-top-10" type="submit">
                    Ещё
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- END User's Replays-->
    <!-- Gallery -->
    @if($rand_images)
        <div class="widget-wrapper">
            <div class="widget-header">Cлучайные картинки</div>
            @foreach($rand_images as $rand_image)
                <a class="widget-gallery-img" href="{{route('gallery.view', ['id'=>$rand_image['id']])}}">
                    @if($rand_image['for_adults'] == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                        [18+]
                    @else
                        <img src="{{$rand_image['file']['link']}}" alt="">
                    @endif
                </a>
            @endforeach
        </div>
    @endif
<!-- END Gallery -->
</div>