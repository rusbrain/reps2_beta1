@php $banners = $general_helper->getActiveBanners(); @endphp
@if($banners)
    <div class="widget-wrapper padding-top-20">
        @foreach($banners as $banner)
            <div class="widget-banner">
                <a href="{{$banner->url_redirect}}">
                    <img src="{{$banner->file->link}}" alt="banner">
                </a>
            </div>
        @endforeach
    </div>
@endif