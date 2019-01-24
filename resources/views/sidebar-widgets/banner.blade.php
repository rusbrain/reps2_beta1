@php $banner = $general_helper->getRandomBanner(); @endphp
@if($banner)
    <div class="widget-wrapper padding-top-40">
        <div class="widget-banner">
            <img src="{{$banner->file->link}}" alt="banner">
        </div>
    </div>
@endif