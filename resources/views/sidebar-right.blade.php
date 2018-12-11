@php
    $banner = $general_helper->getRandomBanner();
    $rand_images = $general_helper->getRandomImg();
    $new_users = $general_helper->getNewUsers();
    $countries = $general_helper->getCountries();
@endphp

<div class="sidebar-right">
    <div class="sidebar-widget random-image">
        <div class="sidebar-widget-title">Банеры</div>
        <div class="sidebar-widget-content">
            @if($banner)
                @php  @endphp
                <a href="#" class="random-banner">
                    <img src="{{$banner->file->link}}" alt="">
                </a>
            @else
                <p class="sidebar-widget-no-results">В данный момент банеров нет</p>
            @endif
        </div>
    </div>

    <div class="sidebar-widget random-image">
        <div class="sidebar-widget-title">Случайные картинки</div>
        <div class="sidebar-widget-content">
            @if($rand_images)
                @foreach($rand_images as $rand_image)
                    <a href="{{route('gallery.view', ['id'=>$rand_image['id']])}}">
                        @if($rand_image['for_adults'] == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                            [18+]
                        @else
                            <img src="{{$rand_image['file']['link']}}" alt="">
                        @endif
                    </a>
                @endforeach
            @else
                <p class="sidebar-widget-no-results">В данный момент случайных картинок нет</p>
            @endif
        </div>
    </div>
    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Новые пользователи</div>
        <div class="sidebar-widget-content">
            @if(!empty($new_users))
                @foreach($new_users as $new_user)
                    <div>
                        <a href="{{route('user_profile',['id'=>$new_user->id])}}">
                            <span>#{{$new_user->id}}</span>
                            @if($new_user->country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$new_user->country_id]->code)}}"></span>
                            @else
                                <span></span>
                            @endif
                            <span class="name">{{$new_user->name}}</span>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>