<!-- User Gallery widget -->
@php
    if(Auth::user()){
            $gallery = $general_helper->getUserGallery(Auth::id());
        }
@endphp
@if($gallery)
<div class="widget-wrapper user-gallery-widget">
    <div class="widget-title">
        Галерея Miroslav
    </div>
    <div class="widget-forum-topics-wrapper">
        @foreach($gallery as $item)
            <div class="widget-forum-topic">
                <img src="images/icons/image_icon.png" alt="">
                <a href="{{route('gallery.view',['id'=> $item->id])}}" class="user-gallery-widget-link">
                    {{$item->file->title}}
                    <span class="color-blue">{{Auth::user()->name}}</span>
                </a>
            </div>
        @endforeach

        <!--Pagination-->
        @php  $data = $gallery @endphp
        @include('pagination')
        <!--END Pagination-->
    </div>
</div>
@endif
<!-- END User Gallery widget -->