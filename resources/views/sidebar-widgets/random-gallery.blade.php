@php $rand_images = $general_helper->getRandomImg();@endphp
@if($rand_images)
    <div class="widget-wrapper">
        <div class="widget-header">Случайные картинки</div>
        @foreach($rand_images as $rand_image)
            <a class="widget-gallery-img" href="{{route('gallery.view', ['id'=>$rand_image['id']])}}">
                @if($rand_image['for_adults'] == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                    [21+]
                @elseif($rand_image['for_adults'] == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !$general_helper->isAdult(Auth::user()))
                    <div class="position-relative">
                        <img src="{{$rand_image['file']['link']}}" alt="">
                        <div class="full-opacity-hover">[21+]</div>
                    </div>
                @else
                    <div class="">
                        <img src="{{$rand_image['file']['link']}}" alt="">
                    </div>
                @endif
            </a>
        @endforeach
    </div>
@endif