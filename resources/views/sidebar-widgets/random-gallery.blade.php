@php $rand_images = $general_helper->getRandomImg();@endphp
@if($rand_images)
    <div class="widget-wrapper">
        <div class="widget-header">Случайные картинки</div>
        @foreach($rand_images as $rand_image)
            <a class="widget-gallery-img" href="{{route('gallery.view', ['id'=>$rand_image['id']])}}">
                @if($rand_image['for_adults'] == \App\UserGallery::USER_GALLERY_FOR_ADULTS && !Auth::user())
                    [18+]
                @else
                    <div class="">
                        <img src="{{$rand_image['file']['link']}}" alt="">
                    </div>
                @endif
            </a>
        @endforeach
    </div>
@endif