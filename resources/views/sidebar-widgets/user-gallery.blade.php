@if($gallery)
    <div class="widget-wrapper user-gallery-widget">
        <div class="widget-title">
            <span class="margin-right-10">Галерея:</span> {{$user->name}}
        </div>
        <div class="widget-forum-topics-wrapper">
            @foreach($gallery as $item)
                <a href="{{route('gallery.view',['id'=> $item->id])}}"
                   class="widget-forum-topic user-gallery-widget-link">
                    <img src="{{route('home')}}/images/icons/image_icon.png" alt="">
                    <div class="widget-gallery-img-preview">
                        <img src="{{route('home')}}/{{$item->file->link}}" alt="">
                    </div>
                    <span class="photo-comment">
                        {!!$item->comment != '' ? $general_helper->oldContentFilter($item->comment) :'Без названия' !!}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
@endif