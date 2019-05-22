@php $banners = $general_helper->getActiveBanners(); @endphp
@if($banners)
    <div class="widget-wrapper padding-top-20">
        @foreach($banners as $banner)
            <div class="widget-banner">
                <img src="{{$banner->file->link}}" alt="banner">
            </div>
        @endforeach
    </div>
@endif